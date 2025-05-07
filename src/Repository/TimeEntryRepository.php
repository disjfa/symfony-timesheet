<?php

namespace App\Repository;

use App\Entity\TimeEntry;
use App\Query\TimeEntryQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TimeEntry>
 */
class TimeEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeEntry::class);
    }

    /**
     * @return TimeEntry[]
     */
    public function findWithQuery(TimeEntryQuery $timeEntryQuery): array
    {
        $qb = $this->createQueryBuilder('time_entry');
        $qb->where('time_entry.start_date >= :start_date');
        $qb->andWhere('time_entry.start_date <= :end_date');
        $qb->setParameter('start_date', $timeEntryQuery->getStartDate());
        $qb->setParameter('end_date', $timeEntryQuery->getEndDate());

        $organizationId = $timeEntryQuery->getOrganizationId();
        if ($organizationId) {
            $qb->join('time_entry.project', 'project');
            $qb->andWhere('project.organization = :organization');
            $qb->setParameter('organization', $organizationId);
        }

        return $qb->getQuery()->getResult();
    }
}
