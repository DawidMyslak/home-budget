<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $categories app\models\Category */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-index">
    
    <h1>Statistics (<?= $year ?>)</h1>
    
    <p>
        <?= Html::a(2014, ['index', 'year' => 2014]) ?>,
        <?= Html::a(2015, ['index', 'year' => 2015]) ?>
    </p>
    
    <hr>
    
    <div class="row">
        <div class="col-md-4">
            Money In
            <h2>&euro;<?= $moneyIn ?></h2>    
        </div>
        <div class="col-md-4">
            Money Out
            <h2>&euro;<?= $moneyOut ?></h2>    
        </div>
        <div class="col-md-4">
            Balance
            <h2><?= $status ?> &euro;<?= $balance ?></h2>    
        </div>
    </div>
    
    <hr>
    <h3>Expenses in categories</h3>
    
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
            <?php foreach ($moneyWithCategories as $item): ?>
                <li class="list-group-item">
                    <?= $item['name'] ?>
                    <span class="badge">&euro;<?= $item['sum'] ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <div style="height: 300px;">
                <div class="ct-chart ct-chart-a ct-perfect-fourth"></div>
            </div>
        </div>
    </div>
    
    <hr>
    <h3>Expenses in months</h3>
    
    <div style="height: 300px;">
        <div class="ct-chart ct-chart-b ct-perfect-fourth"></div>
    </div>
    
    <!-- temporary code, needs to be moved -->
    
    <style>
        .ct-label {
            font-size: 14px;
        }
        
        .ct-perfect-fourth:before {
            padding: 0;
        }
    </style>
    
    <script>
        <?php
            $labels = '[';
            $series = '[';
            
            foreach ($moneyWithCategories as $item) {
                $labels .= '"' . $item['name'] . '", ';
                $series .= $item['sum'] . ', ';
            }
            
            $labels = substr($labels, 0, -2) . ']';
            $series = substr($series, 0, -2) . ']';
        ?>
        
        var data = {
            labels: <?= $labels; ?>,
            series: <?= $series; ?>
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
        
        <?php
            $labels = '[';
            $series1 = '[';
            $series2 = '[';
            
            foreach ($moneyWithMonths as $item) {
                $labels .= '"' . $item['date'] . '", ';
                $series1 .= $item['sum_out'] . ', ';
                $series2 .= $item['sum_in'] . ', ';
            }
            
            $labels .= '""]';
            $series1 = substr($series1, 0, -2) . ']';
            $series2 = substr($series2, 0, -2) . ']';
        ?>
        
        var data = {
            labels: <?= $labels; ?>,
            series: [
                <?= $series1; ?>,
                <?= $series2; ?>
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
    
    <!-- end of temporary -->
    
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
            <?php foreach ($moneyWithSubcategories as $item): ?>
            <tr>
                <td><?= $item['cname'] ?></td>
                <td><?= $item['sname'] ?></td>
                <td>&euro;<?= $item['sum'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
