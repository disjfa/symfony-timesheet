<?php

namespace App\Query;

use App\Entity\Organization;
use Symfony\Component\HttpFoundation\Request;

class TimeEntryQuery
{
    private ?int $organizationId = null;
    private ?\DateTime $startDate = null;
    private ?\DateTime $endDate = null;

    public function __construct()
    {
        $request = Request::createFromGlobals();

        $this->endDate = new \DateTime('last monday');
        $this->startDate = clone $this->endDate;
        $this->startDate->modify('-7 days');
        $this->endDate->modify('-1 second');

        $organizationId = filter_var($request->query->get('organization'), FILTER_VALIDATE_INT);
        if ($organizationId) {
            $this->organizationId = $organizationId;
        }
    }

    public function setOrganization(Organization $organization)
    {
        $this->organizationId = $organization->getId();
    }

    public function getOrganizationId(): ?int
    {
        return $this->organizationId;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }
}
