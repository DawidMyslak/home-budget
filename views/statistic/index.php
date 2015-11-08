<?php

use yii\helpers\Html;
use yii\helpers\Json;
use app\assets\StatisticAsset;
use app\helpers\FormatHelper;

StatisticAsset::register($this);

/* @var $this yii\web\View */
/* @var $chart app\models\Chart */
/* @var $statistic app\models\Statistic */

$this->title = 'Statistics';
$this->params['subtitle'] = 'Dashboard';
?>

<div class="statistic-index">
    
    <ul class="nav nav-pills">
    <?php foreach ($statistic->years as $item): ?>
        <li role="presentation" class="<?= $item['year'] == $statistic->year ? 'active' : '' ?>">
            <?= Html::a($item['year'], ['index', 'year' => $item['year']]) ?>
        </li>
    <?php endforeach; ?>
    </ul>
    
    <hr>
    
    <div class="row">
        <div class="col-sm-4">
            Income
            <h2>&euro;<?= FormatHelper::number($statistic->moneyIn) ?></h2>    
        </div>
        <div class="col-sm-4">
            Expenses
            <h2>&euro;<?= FormatHelper::number($statistic->moneyOut) ?></h2>    
        </div>
        <div class="col-sm-4">
            Balance
            <h2><?= $statistic->status ?> &euro;<?= FormatHelper::number($statistic->balance) ?></h2>    
        </div>
    </div>
    
    <h3>Expenses in categories</h3>
    
    <div class="row">
        <div class="col-sm-7">
            <ul class="list-group">
            <?php foreach ($statistic->moneyInCategories as $index => $item): ?>
                <li class="list-group-item">
                    <span class="percent" style="width: <?= $item['percent'] ?>%;"></span>
                    <span class="ct-desc ct-color-<?= $index ?>"></span><?= Html::encode($item['name']) ?>
                    <span class="pull-right">&euro;<?= FormatHelper::number($item['sum']) ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-sm-5">
            <div class="ct-chart-area">
                <div class="ct-chart-a-center">
                    <h3 class="ct-chart-a-value">&euro;<?= FormatHelper::number($statistic->moneyOut) ?></h3>
                    <span class="ct-chart-a-label">Expenses</span>
                </div>
                <div class="ct-chart ct-chart-a ct-perfect-fourth"></div>
            </div>
        </div>
    </div>
    
    <h3>Money in months</h3>
    <span class="ct-desc ct-color-0"></span>Income &nbsp;&nbsp;&nbsp; <span class="ct-desc ct-color-1"></span>Expenses
    
    <div class="ct-chart-area ct-chart-line-area">
        <div class="ct-chart ct-chart-b ct-perfect-fourth"></div>
    </div>
    
    <h3>Balance in months</h3>
    <span class="ct-desc ct-color-0"></span>Positive &nbsp;&nbsp;&nbsp; <span class="ct-desc ct-color-1"></span>Negative
    
    <div class="ct-chart-area ct-chart-bar-area">
        <div class="ct-chart ct-chart-c ct-perfect-fourth"></div>
    </div>
    
    <h3>Expenses in subcategories</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Expenses</th>
            </tr>
        </thead>
        <tbody>
            <?php $previousCategory = ''; foreach ($statistic->moneyInSubcategories as $item): ?>
            <tr>
                <td><?= $previousCategory != $item['cname'] ? Html::encode($item['cname']) : '' ?></td>
                <td><?= Html::encode($item['sname']) ?></td>
                <td>&euro;<?= FormatHelper::number($item['sum']) ?></td>
            </tr>
            <?php $previousCategory = $item['cname']; endforeach; ?>
        </tbody>
    </table>

</div>

<!-- charts data -->

<script>        
    var dataA = {
        labels: <?= Json::htmlEncode($chart->moneyInCategoriesChart->labels) ?>,
        series: <?= Json::htmlEncode($chart->moneyInCategoriesChart->series) ?>
    };
    
    var dataB = {
        labels: <?= Json::htmlEncode($chart->moneyInMonthsChart->labels) ?>,
        series: [
            {
                name: 'Money In',
                data: <?= Json::htmlEncode($chart->moneyInMonthsChart->series1) ?>
            },
            {
                name: 'Money Out',
                data: <?= Json::htmlEncode($chart->moneyInMonthsChart->series2) ?>
            }
        ]
    };
    
    var dataC = {
        labels: <?= Json::htmlEncode($chart->balanceInMonthsChart->labels) ?>,
        series: [<?= Json::htmlEncode($chart->balanceInMonthsChart->series) ?>]
    };
</script>
