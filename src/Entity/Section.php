<?php
namespace Tiptone\AyddSchedule\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tiptone\AyddSchedule\Entity\YogaClass;

/**
 * @ORM\Entity
 * @Orm\Table(name="section")
 */
class Section
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", name="start_time")
     * @var \DateTime
     */
    private $startTime;

    /**
     * @ORM\ManyToOne(targetEntity="YogaClass")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     * @var YogaClass
     */
    private $yogaClass;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Section
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     * @return Section
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @return \Tiptone\AyddSchedule\Entity\YogaClass
     */
    public function getYogaClass()
    {
        return $this->yogaClass;
    }

    /**
     * @param \Tiptone\AyddSchedule\Entity\YogaClass $yogaClass
     * @return Section
     */
    public function setYogaClass($yogaClass)
    {
        $this->yogaClass = $yogaClass;
        return $this;
    }
}
