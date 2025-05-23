<?php

namespace App\Charts;

use App\Manager\TimeSheetManager;
use Spatie\Color\Named;
use Spatie\Color\Names;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class OrganizationsPastWeek
{
    use Names;

    private ChartBuilderInterface $chartBuilder;
    private TimeSheetManager $timeSheetManager;

    public function __construct(TimeSheetManager $timeSheetManager, ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
        $this->timeSheetManager = $timeSheetManager;
    }

    public function getChart(): Chart
    {
        $organizations = $this->timeSheetManager->getOrganizations();

        $labels = [];
        $data = [];
        $backgroundColors = [];
        foreach ($organizations as $item) {
            $color = Named::fromString($item['color']);

            $backgroundColors[] = (string) $color->toRgb();
            $labels[] = $item['name'];
            $data[] = $item['seconds'] / 60 / 60;
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
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
