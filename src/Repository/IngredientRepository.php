<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Data\SearchIngredient;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Ingredient>
 *
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    /**
     * Add ingredient into database
     *
     * @param Ingredient $entity
     * @param boolean $flush
     * @return void
     */
    public function add(Ingredient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * remove ingredient from database
     *
     * @param Ingredient $entity
     * @param boolean $flush
     * @return void
     */
    public function remove(Ingredient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Search ingredient
     *
     * @param SearchIngredient $search
     * @return array
     */
    public function searchIngredient(SearchIngredient $search): array
    {
        $query = $this
            ->createQueryBuilder('i')
            ->select('i');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('i.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        return $query->getQuery()->getResult();
    }
}
