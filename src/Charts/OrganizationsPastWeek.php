<?php

namespace App\Charts;

use App\Repository\TimeEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Spatie\Color\Named;
use Spatie\Color\Names;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class OrganizationsPastWeek
{
    use Names;

    private TimeEntryRepository $timEntryRepository;
    private ChartBuilderInterface $chartBuilder;

    public function __construct(TimeEntryRepository $timEntryRepository, ChartBuilderInterface $chartBuilder)
    {
        $this->timEntryRepository = $timEntryRepository;
        $this->chartBuilder = $chartBuilder;
    }

    public function getChart(): Chart
    {
        $timeEntryQuery = $this->timEntryRepository->createQueryBuilder('time_entry');
        $lastWeek = new \DateTime('last week');
        $timeEntryQuery->where('time_entry.start_date > :start_date');
        $timeEntryQuery->setParameter('start_date', $lastWeek);
        $timeEntries = $timeEntryQuery->getQuery()->getResult();

        $graph = new ArrayCollection();
        foreach ($timeEntries as $timeEntry) {
            $project = $graph->get($timeEntry->getProject()->getOrganization()->getId());
            if (null === $project) {
                $project = [
                    'name' => $timeEntry->getProject()->getOrganization()->getName(),
                    'seconds' => 0,
                ];
            }
            $project['seconds'] += $timeEntry->getSeconds();
            $graph->set($timeEntry->getProject()->getOrganization()->getId(), $project);
        }

        $colorNames = array_keys($this->names);
        shuffle($colorNames);

        $graphSorted = $graph->toArray();
        usort($graphSorted, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        $labels = [];
        $data = [];
        $backgroundColors = [];
        foreach ($graphSorted as $item) {
            $color = Named::fromString(array_shift($colorNames));

            $backgroundColors[] = (string) $color->toRgb();
            $labels[] = $item['name'];
            $data[] = $item['seconds'] / 60 / 60;
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Hours',
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $backgroundColors,
                    'data' => $data,
                    'tension' => 0.4,
                ],
            ],
        ]);
        $chart->setOptions([
            'maintainAspectRatio' => false,
            'indexAxis' => 'y',
        ]);

        return $chart;
    }
}
