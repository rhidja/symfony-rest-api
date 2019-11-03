<?php
namespace UserBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Http\HttpUtils;

class AuthTokenAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
    * Durée de validité du token en secondes, 12 heures
    */
    const TOKEN_VALIDITY_DURATION = 43200;

    /**
     * @var HttpUtils
     */
    protected $httpUtils;

    /**
     * AuthTokenAuthenticator constructor.
     * @param HttpUtils $httpUtils
     */
    public function __construct(HttpUtils $httpUtils)
    {
        $this->httpUtils = $httpUtils;
    }

    /**
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken|void
     */
    public function createToken(Request $request, $providerKey)
    {

        $targetUrl = '/auth-tokens';
        if ($request->getMethod() === "POST" && $this->httpUtils->checkRequestPath($request, $targetUrl)) {
            return;
        }

        $authTokenHeader = $request->headers->get('X-Auth-Token');

        if (!$authTokenHeader) {
            throw new BadCredentialsException('X-Auth-Token header is required');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $authTokenHeader,
            $providerKey
        );
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof AuthTokenUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of AuthTokenUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $authTokenHeader = $token->getCredentials();
        $authToken = $userProvider->getAuthToken($authTokenHeader);

        if (!$authToken || !$this->isTokenValid($authToken)) {
            throw new BadCredentialsException('Invalid authentication token');
        }

        $user = $authToken->getUser();
        $pre = new PreAuthenticatedToken(
            $user,
            $authTokenHeader,
            $providerKey,
            $user->getRoles()
        );

        $pre->setAuthenticated(true);

        return $pre;
    }

    /**
     * @param TokenInterface $token
     * @param $providerKey
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
    * Vérifie la validité du token
    */
    private function isTokenValid($authToken)
    {
        return (time() - $authToken->getCreatedAt()->getTimestamp()) < self::TOKEN_VALIDITY_DURATION;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw $exception;
    }
}
