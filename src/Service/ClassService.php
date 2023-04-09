<?php
namespace Tiptone\AyddSchedule\Service;

use Doctrine\ORM\EntityManager;
use Tiptone\AyddSchedule\Entity\YogaClass;

class ClassService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return YogaClass[]
     */
    public function findAll()
    {
        try {
            $classes = $this->entityManager
                ->getRepository(YogaClass::class)
                ->findBy([], ['name' => 'ASC']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $classes;
    }
}
