<?php
namespace Tiptone\AyddSchedule\Service;

use Doctrine\ORM\EntityManager;
use Tiptone\AyddSchedule\Entity\Section;

class SectionService
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
     * @param int $id
     * @return Section|null
     */
    public function find($id)
    {
        try {
            $section = $this->entityManager
                ->find(Section::class, $id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $section;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return Section[]
     */
    public function findWeeklySchedule(\DateTime $start, \DateTime $end)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('s')
            ->from(Section::class, 's')
            ->where('s.startTime >= :start')
            ->andWhere('s.startTime <= :end')
            ->setParameters([
                'start' => $start->format('Y-m-d'). ' 00:00:00',
                'end' => $end->format('Y-m-d') . ' 23:59:59'
            ]);

        return $qb->getQuery()->getResult();

//        $sql = "select section.id,
//                    class_id,
//                    start_time,
//                    name,
//                    description
//                from section
//                join class on
//                    section.class_id = class.id
//                where start_time between ?1 and ?2
//                order by start_time";
//
//        return $this->entityManager->createQuery($sql)
//            ->setParameter(1, $start->format('Y-m-d'). ' 00:00:00')
//            ->setParameter(2, $end->format('Y-m-d') . ' 23:59:59')
//            ->getResult();
    }
}
