<?php

namespace app\models;

use Yii;
use app\models\Statistic;

class MoneyWithCategoriesChart {
    public $labels;
    public $series;
    
    public function prepareData($statistic) {
        $this->labels = [];
        $this->series = [];
        
        if ($statistic->moneyWithCategories) {            
            foreach ($statistic->moneyWithCategories as $item) {
                $this->labels[] = $item['name'];
                $this->series[] = $item['sum'];
            }
        }
    }
}

class MoneyWithMonthsChart
{
    public $labels;
    public $series1;
    public $series2;
    
    public function prepareData($statistic) {
        $this->labels = [];
        $this->series1 = [];
        $this->series2 = [];
        
        if ($statistic->moneyWithMonths) {
            foreach ($statistic->moneyWithMonths as $item) {
                $this->labels[] = $item['date'];
                $this->series1[] = $item['sum_out'];
                $this->series2[] = $item['sum_in'];
            }
            
            $this->labels[] = '';
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
