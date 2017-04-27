<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SmartPackageConfiguration
 *
 * @ORM\Table(name="smart_package_configuration")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\SmartPackageConfigurationRepository")
 */
class SmartPackageConfiguration
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
     * @ORM\Column(name="smart_code", type="string", length=20, unique=true)
     * @Groups({"configuration", "medication"})
     */
    private $smartCode;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=16)
     * @Groups({"configuration", "medication"})
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="frequency", type="integer")
     * @Groups({"configuration", "medication"})
     */
    private $frequency;

    /**
     * @var float
     *
     * @ORM\Column(name="coefficient", type="float")
     * @Groups({"configuration", "medication"})
     */
    private $coefficient;

    /**
     * @var integer
     *
     * @ORM\Column(name="periode", type="integer")
     * @Groups({"configuration", "medication"})
     */
    private $periode;

    /**
     * @ORM\OneToMany(targetEntity="Medication", mappedBy="smartPackageConfiguration", cascade={"persist"})
     * @Groups({"smartPackageConfiguration"})
     * @Groups({"configuration"})
     * @var Medication[]
     */
    protected $medications;

    public function __construct()
    {
        $this->medications = new ArrayCollection();
    }

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
     * Set smartCode
     *
     * @param string $smartCode
     *
     * @return SmartPackageConfiguration
     */
    public function setSmartCode($smartCode)
    {
        $this->smartCode = $smartCode;

        return $this;
    }

    /**
     * Get smartCode
     *
     * @return string
     */
    public function getSmartCode()
    {
        return $this->smartCode;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return SmartPackageConfiguration
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set frequency
     *
     * @param integer $frequency
     *
     * @return SmartPackageConfiguration
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return integer
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set coefficient
     *
     * @param float $coefficient
     *
     * @return SmartPackageConfiguration
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return float
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set periode
     *
     * @param integer $periode
     *
     * @return SmartPackageConfiguration
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * Get periode
     *
     * @return integer
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * Add medication
     *
     * @param \ApiBundle\Entity\Medication $medication
     *
     * @return SmartPackageConfiguration
     */
    public function addMedication(\ApiBundle\Entity\Medication $medication)
    {
        $this->medications[] = $medication;

        return $this;
    }

    /**
     * Remove medication
     *
     * @param \ApiBundle\Entity\Medication $medication
     */
    public function removeMedication(\ApiBundle\Entity\Medication $medication)
    {
        $this->medications->removeElement($medication);
    }

    /**
     * Get medications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedications()
    {
        return $this->medications;
    }
}
