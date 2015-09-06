<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $categories app\models\Category */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-index">
    
    <h1>Statistics (<?= $statistic->year ?>)</h1>
    
    <p>
        <?= Html::a(2014, ['index', 'year' => 2014]) ?>,
        <?= Html::a(2015, ['index', 'year' => 2015]) ?>
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
    <h3>Expenses in categories</h3>
    
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
            <?php foreach ($statistic->moneyWithCategories as $item): ?>
                <li class="list-group-item">
                    <?= $item['name'] ?>
                    <span class="badge">&euro;<?= $item['sum'] ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="chart-area">
                <div class="ct-chart ct-chart-a ct-perfect-fourth"></div>
            </div>
        </div>
    </div>
    
    <hr>
    <h3>Expenses in months</h3>
    
    <div class="chart-area">
        <div class="ct-chart ct-chart-b ct-perfect-fourth"></div>
    </div>
    
    <hr>
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
            <?php $previousCategory = ''; foreach ($statistic->moneyWithSubcategories as $item): ?>
            <tr>
                <td><?= $previousCategory != $item['cname'] ? $item['cname'] : '' ?></td>
                <td><?= $item['sname'] ?></td>
                <td>&euro;<?= $item['sum'] ?></td>
            </tr>
            <?php $previousCategory = $item['cname']; endforeach; ?>
        </tbody>
    </table>

</div>

<!-- charts -->

<script>        
    var data = {
        labels: <?= $chart->moneyWithCategoriesChart->labels; ?>,
        series: <?= $chart->moneyWithCategoriesChart->series; ?>
    };
    
    var options = {
        fullWidth: true,
        height: 300,
        labelOffset: 40,
        labelInterpolationFnc: function(value) {
            return value[0];
        }
    };
    
    new Chartist.Pie('.ct-chart-a', data, options);
    
    var data = {
        labels: <?= $chart->moneyWithMonthsChart->labels; ?>,
        series: [
            <?= $chart->moneyWithMonthsChart->series1; ?>,
            <?= $chart->moneyWithMonthsChart->series2; ?>
        ]
    };
    
    var options = {
        fullWidth: true,
        chartPadding: {
            right: 40
        },
        height: 300,
        low: 0,
        lineSmooth: Chartist.Interpolation.cardinal({
            tension: 0
        })
    };
    
    new Chartist.Line('.ct-chart-b', data, options);
</script>
