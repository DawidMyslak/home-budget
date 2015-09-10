<?php

namespace app\models;

use Yii;
use app\models\Statistic;

class MoneyWithCategoriesChart {
    public $labels;
    public $series;
    
    public function prepareData($statistic) {
        $this->labels = 'null';
        $this->series = 'null';
        
        if ($statistic->moneyWithCategories) {
            $labels = '[';
            $series = '[';
            
            foreach ($statistic->moneyWithCategories as $item) {
                $labels .= '"' . $item['name'] . '", ';
                $series .= $item['sum'] . ', ';
            }
            
            $labels = substr($labels, 0, -2) . ']';
            $series = substr($series, 0, -2) . ']';
            
            $this->labels = $labels;
            $this->series = $series;
        }
    }
}

class MoneyWithMonthsChart
{
    public $labels;
    public $series1;
    public $series2;
    
    public function prepareData($statistic) {
        $this->labels = 'null';
        $this->series1 = 'null';
        $this->series2 = 'null';
        
        if ($statistic->moneyWithMonths) {
            $labels = '[';
            $series1 = '[';
            $series2 = '[';
            
            foreach ($statistic->moneyWithMonths as $item) {
                $labels .= '"' . $item['date'] . '", ';
                $series1 .= $item['sum_out'] . ', ';
                $series2 .= $item['sum_in'] . ', ';
            }
            
            $labels .= '""]';
            $series1 = substr($series1, 0, -2) . ']';
            $series2 = substr($series2, 0, -2) . ']';
            
            $this->labels = $labels;
            $this->series1 = $series1;
            $this->series2 = $series2;
        }
    }
}

class Chart extends \yii\base\Object
{
    public $moneyWithCategoriesChart;
    public $moneyWithMonthsChart;
    
    public function prepareData($statistic) {
        $this->moneyWithCategoriesChart = new MoneyWithCategoriesChart();
        $this->moneyWithCategoriesChart->prepareData($statistic);
        
        $this->moneyWithMonthsChart = new MoneyWithMonthsChart();
        $this->moneyWithMonthsChart->prepareData($statistic);
    }
}
