<?php
namespace Tiptone\AyddSchedule\Service;

use Doctrine\ORM\EntityManager;
use Tiptone\AyddSchedule\Entity\User;

class UserService
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
     * @param $id
     * @return User|null
     * @throws \Exception
     */
    public function find($id)
    {
        try {
            $user = $this->entityManager
                ->find(User::class, $id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $user;
    }

    public function save(User $user)
    {
        if ($user->getId()) {
            try {
                $this->entityManager->flush();
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            try {
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }
}
