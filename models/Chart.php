<?php

namespace app\models;

use Yii;
use app\models\Statistic;

class MoneyInCategoriesChart {
    public $labels;
    public $series;
    
    public function prepareData($statistic) {
        $this->labels = [];
        $this->series = [];
        
        if ($statistic->moneyInCategories) {            
            foreach ($statistic->moneyInCategories as $item) {
                $this->labels[] = $item['name'];
                $this->series[] = $item['sum'];
            }
        }
    }
}

class MoneyInMonthsChart
{
    public $labels;
    public $series1;
    public $series2;
    
    public function prepareData($statistic) {
        $this->labels = [];
        $this->series1 = [];
        $this->series2 = [];
        
        if ($statistic->moneyInMonths) {
            foreach ($statistic->moneyInMonths as $item) {
                $this->labels[] = $item['date'];
                $this->series1[] = $item['sum_out'];
                $this->series2[] = $item['sum_in'];
            }
            
            $this->labels[] = '';
        }
    }
}

class BalanceInMonthsChart
{
    public $labels;
    public $series1;
    
    public function prepareData($statistic) {
        $this->labels = [];
        $this->series1 = [];
        $this->series2 = [];
        
        if ($statistic->balanceInMonths) {
            foreach ($statistic->balanceInMonths as $item) {
                $this->labels[] = $item['date'];
                $this->series[] = $item['balance'];
            }
        }
    }
}

class Chart extends \yii\base\Object
{
    public $moneyInCategoriesChart;
    public $moneyInMonthsChart;
    public $balanceInMonthsChart;
    
    public function prepareData($statistic) {
        $this->moneyInCategoriesChart = new MoneyInCategoriesChart();
        $this->moneyInCategoriesChart->prepareData($statistic);
        
        $this->moneyInMonthsChart = new MoneyInMonthsChart();
        $this->moneyInMonthsChart->prepareData($statistic);
        
        $this->balanceInMonthsChart = new BalanceInMonthsChart();
        $this->balanceInMonthsChart->prepareData($statistic);
    }
}
