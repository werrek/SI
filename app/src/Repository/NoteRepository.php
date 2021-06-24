<?php
/**
 * Note repository.
 */

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class NoteRepository.
 *
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * NoteRepository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * Save record.
     *
     * @param Note $note Note entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Note $note): void
    {
        $this->_em->persist($note);
        $this->_em->flush($note);
    }

    /**
     * Delete record.
     *
     * @param Note $note Note entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Note $note): void
    {
        $this->_em->remove($note);
        $this->_em->flush($note);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('note.date', 'DESC');
    }

    /**
     * Search notes by category.
     *
     * @param string|null $category
     *
     * @return QueryBuilder Query Builder
     */
    public function queryLikeCategory(?string $category): QueryBuilder
    {
        if (null === $category) {
            return $this->queryAll();
        }

        return $this->queryAll()
            ->join('note.category', 'c')
            ->andWhere('c.title LIKE :var')
            ->setParameter('var', '%'.$category.'%');
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('note');
    }
}
