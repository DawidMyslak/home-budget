<?php

use yii\helpers\Html;
use yii\helpers\Json;
use app\assets\StatisticAsset;

StatisticAsset::register($this);

/* @var $this yii\web\View */
/* @var $categories app\models\Category */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-index">
    
    <h1>Statistics (<?= $statistic->year ?>)</h1>
    
    <p>
        <?php foreach ($statistic->years as $item): ?>
            <?= Html::a($item['year'], ['index', 'year' => $item['year']]) ?>
        <?php endforeach; ?>
    </p>
    
    <hr>
    
    <div class="row">
        <div class="col-md-4">
            Money In
            <h2>&euro;<?= $statistic->moneyIn ?></h2>    
        </div>
        <div class="col-md-4">
            Money Out
            <h2>&euro;<?= $statistic->moneyOut ?></h2>    
        </div>
        <div class="col-md-4">
            Balance
            <h2><?= $statistic->status ?> &euro;<?= $statistic->balance ?></h2>    
        </div>
    </div>
    
    <hr>
    <h3>Money in categories</h3>
    
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
            <?php foreach ($statistic->moneyInCategories as $index => $item): ?>
                <li class="list-group-item">
                    <span class="percent" style="width: <?= $item['percent'] ?>%;"></span>
                    <span class="ct-desc ct-color-<?= $index ?>"></span><?= $item['name'] ?>
                    <span class="badge">&euro;<?= $item['sum'] ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="ct-chart-area">
                <div class="ct-chart ct-chart-a ct-perfect-fourth"></div>
            </div>
        </div>
    </div>
    
    <hr>
    <h3>Money in months</h3>
    <span class="ct-desc ct-color-0"></span>Money In &nbsp;&nbsp;&nbsp; <span class="ct-desc ct-color-1"></span>Money Out
    
    <div class="ct-chart-area ct-chart-line-area">
        <div class="ct-chart ct-chart-b ct-perfect-fourth"></div>
    </div>
    
    <hr>
    <h3>Balance in months</h3>
    <span class="ct-desc ct-color-0"></span>Positive &nbsp;&nbsp;&nbsp; <span class="ct-desc ct-color-1"></span>Negative
    
    <div class="ct-chart-area ct-chart-bar-area">
        <div class="ct-chart ct-chart-c ct-perfect-fourth"></div>
    </div>
    
    <hr>
    <h3>Money in subcategories</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Money</th>
            </tr>
        </thead>
        <tbody>
            <?php $previousCategory = ''; foreach ($statistic->moneyInSubcategories as $item): ?>
            <tr>
                <td><?= $previousCategory != $item['cname'] ? $item['cname'] : '' ?></td>
                <td><?= $item['sname'] ?></td>
                <td>&euro;<?= $item['sum'] ?></td>
            </tr>
            <?php $previousCategory = $item['cname']; endforeach; ?>
        </tbody>
    </table>

</div>

<!-- charts data -->

<script>        
    var dataA = {
        labels: <?= Json::encode($chart->moneyInCategoriesChart->labels) ?>,
        series: <?= Json::encode($chart->moneyInCategoriesChart->series) ?>
    };
    
    var dataB = {
        labels: <?= Json::encode($chart->moneyInMonthsChart->labels) ?>,
        series: [
            {
                name: 'Money In',
                data: <?= Json::encode($chart->moneyInMonthsChart->series1) ?>
            },
            {
                name: 'Money Out',
                data: <?= Json::encode($chart->moneyInMonthsChart->series2) ?>
            }
        ]
    };
    
    var dataC = {
        labels: <?= Json::encode($chart->balanceInMonthsChart->labels) ?>,
        series: [<?= Json::encode($chart->balanceInMonthsChart->series) ?>]
    };
</script>
