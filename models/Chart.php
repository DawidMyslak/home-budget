<?php

namespace app\models;

use Yii;
use app\models\Statistic;

class MoneyInCategoriesChart {
    public $labels;
    public $series;
    
    /**
     * @return void
     */
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
    
    /**
     * @return void
     */
    public function prepareData($statistic, $months) {
        $this->labels = [];
        $this->series1 = [];
        $this->series2 = [];
        
        foreach ($months as $month) {
            $this->labels[] = $month;
            $series1 = '';
            $series2 = '';
            
            foreach ($statistic->moneyInMonths as $item) {
                if ($month === $item['date']) {
                    $series1 = $item['sum_in'];
                    $series2 = $item['sum_out'];
                    break;
                }
            }
            
            $this->series1[] = $series1;
            $this->series2[] = $series2;
        }
    }
}

class BalanceInMonthsChart
{
    public $labels;
    public $series;
    
    /**
     * @return void
     */
    public function prepareData($statistic, $months) {
        $this->labels = [];
        $this->series = [];
        
        foreach ($months as $month) {
            $this->labels[] = $month;
            $series = '';
            
            foreach ($statistic->balanceInMonths as $item) {
                if ($month === $item['date']) {
                    $series = $item['balance'];
                    break;
                }
            }
            
            $this->series[] = $series;
        }
    }
}

class Chart extends \yii\base\Object
{
    public $moneyInCategoriesChart;
    public $moneyInMonthsChart;
    public $balanceInMonthsChart;
    
    /**
     * @return void
     */
    public function prepareData($statistic) {
        $this->moneyInCategoriesChart = new MoneyInCategoriesChart();
        $this->moneyInCategoriesChart->prepareData($statistic);
        
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        
        $this->moneyInMonthsChart = new MoneyInMonthsChart();
        $this->moneyInMonthsChart->prepareData($statistic, $months);
        
        $this->balanceInMonthsChart = new BalanceInMonthsChart();
        $this->balanceInMonthsChart->prepareData($statistic, $months);
    }
}
