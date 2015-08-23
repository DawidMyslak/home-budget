<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $categories app\models\Category */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-index">
    
    <div class="row">
        <div class="col-md-4">
            Money In
            <h1><?= Html::encode($moneyIn) ?>&euro;</h1>    
        </div>
        <div class="col-md-4">
            Money Out
            <h1><?= Html::encode($moneyOut) ?>&euro;</h1>    
        </div>
        <div class="col-md-4">
            Balance
            <h1><?= Html::encode($balance) ?>&euro;</h1>    
        </div>
    </div>

    <ul class="list-group">
    <?php foreach ($moneyWithCategories as $item): ?>
        <li class="list-group-item">
            <?= Html::encode($item['name']) ?>
            <span class="badge"><?= Html::encode($item['sum']) ?>&euro;</span>
        </li>
    <?php endforeach; ?>
    </ul>

</div>
