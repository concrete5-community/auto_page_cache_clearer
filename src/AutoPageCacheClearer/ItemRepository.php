<?php

namespace A3020\AutoPageCacheClearer;

use A3020\AutoPageCacheClearer\Entity\Item;
use Doctrine\ORM\EntityManager;

class ItemRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Item::class);
    }

    /**
     * Find a particular item.
     *
     * @param $id
     *
     * @return \A3020\AutoPageCacheClearer\Entity\Item|null
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all items.
     *
     * @return \A3020\AutoPageCacheClearer\Entity\Item[]
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Delete an item.
     *
     * @param \A3020\AutoPageCacheClearer\Entity\Item $entity
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(Item $entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function store(Item $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
