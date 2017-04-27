<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Medication
 *
 * @ORM\Table(name="medication")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\MedicationRepository")
 */
class Medication
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"configuration", "medication"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="med_code", type="string", length=32)
     * @Groups({"configuration", "medication"})
     */
    private $medCode;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     * @Groups({"configuration", "medication"})
     */
    private $name;

    /**
     * @var time
     *
     * @ORM\Column(name="from", type="time")
     * @Groups({"configuration", "medication"})
     */
    private $from;

    /**
     * @var time
     *
     * @ORM\Column(name="until", type="time")
     * @Groups({"configuration", "medication"})
     */
    private $until;

    /**
     * @ORM\ManyToOne(targetEntity="SmartPackageConfiguration", inversedBy="medications")
     * @var SmartPackageConfiguration
     * @Groups({"medication"})
     */
    protected $smartPackageConfiguration;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set medCode
     *
     * @param string $medCode
     *
     * @return Medication
     */
    public function setMedCode($medCode)
    {
        $this->medCode = $medCode;

        return $this;
    }

    /**
     * Get medCode
     *
     * @return string
     */
    public function getMedCode()
    {
        return $this->medCode;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Medication
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set from
     *
     * @param \DateTime $from
     *
     * @return Medication
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return \DateTime
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set until
     *
     * @param \DateTime $until
     *
     * @return Medication
     */
    public function setUntil($until)
    {
        $this->until = $until;

        return $this;
    }

    /**
     * Get until
     *
     * @return \DateTime
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * Set smartPackageConfiguration
     *
     * @param \ApiBundle\Entity\SmartPackageConfiguration $smartPackageConfiguration
     *
     * @return Medication
     */
    public function setSmartPackageConfiguration(\ApiBundle\Entity\SmartPackageConfiguration $smartPackageConfiguration = null)
    {
        $this->smartPackageConfiguration = $smartPackageConfiguration;

        return $this;
    }

    /**
     * Get smartPackageConfiguration
     *
     * @return \ApiBundle\Entity\SmartPackageConfiguration
     */
    public function getSmartPackageConfiguration()
    {
        return $this->smartPackageConfiguration;
    }
}
