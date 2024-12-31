<?php
$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'bin',
        'var',
        'vendor'
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'yoda_style' => false,
        'global_namespace_import' => ['import_classes' => null],
    ])
    ->setFinder($finder)
;
