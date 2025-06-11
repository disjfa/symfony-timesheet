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

        $organizations = $timeEntryQuery->getOrganizations();
        if ($organizations) {
            $qb->join('time_entry.project', 'project');
            $qb->andWhere('project.organization IN (:organizations)');
            $qb->setParameter('organizations', $organizations);
        }

        $users = $timeEntryQuery->getUsers();
        if ($users) {
            $qb->andWhere('time_entry.user IN (:users)');
            $qb->setParameter('users', $users);
        }

        $projects = $timeEntryQuery->getProjects();
        if ($projects) {
            $qb->andWhere('time_entry.project IN (:projects)');
            $qb->setParameter('projects', $projects);
        }

        return $qb->getQuery()->getResult();
    }
}
