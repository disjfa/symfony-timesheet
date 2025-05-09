<?php

namespace App\Charts;

use App\Entity\TimeEntry;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class TimeEntriesPerDate
{
    private ChartBuilderInterface $chartBuilder;

    public function __construct(ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
    }

    /**
     * @param Collection|TimeEntry[] $timeEntries
     */
    public function getChart(Collection $timeEntries): Chart
    {
        $minDate = new \DateTime('next year');
        $maxDate = new \DateTime('1970');

        $dates = [];
        foreach ($timeEntries as $timeEntry) {
            $startDate = $timeEntry->getStartDate();
            $date = $startDate->format('Ymd');
            if (!isset($dates[$date])) {
                $dates[$date] = [
                    'date' => clone $startDate,
                    'seconds' => 0,
                ];
            }
            $dates[$date]['seconds'] += $timeEntry->getSeconds();

            if ($startDate > $maxDate) {
                $maxDate = $startDate;
            }

            if ($startDate < $minDate) {
                $minDate = $startDate;
            }
        }

        $label = $minDate->format('Y-m-d').' - '.$maxDate->format('Y-m-d');

        while ($minDate < $maxDate) {
            $date = $minDate->format('Ymd');
            if (!isset($dates[$date]) && (int) $minDate->format('N') < 6) {
                $dates[$date] = [
                    'date' => clone $minDate,
                    'seconds' => 0,
                ];
            }
            $minDate->modify('+1 day');
        }
        ksort($dates);

        $labels = [];
        $data = [];
        foreach ($dates as $item) {
            $labels[] = $item['date']->format('d/m');
            $data[] = $item['seconds'] / 60 / 60;
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $data,
                    'tension' => 0.4,
                ],
            ],
        ]);
        //        $chart->setOptions([
        //            'maintainAspectRatio' => false,
        //            'indexAxis' => 'y',
        //        ]);

        return $chart;
    }
}
