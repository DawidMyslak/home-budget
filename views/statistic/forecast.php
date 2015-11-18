<?php

use yii\helpers\Html;
use app\models\Category;
use app\helpers\FormatHelper;
use app\assets\ForecastAsset;

ForecastAsset::register($this);

/* @var $this yii\web\View */
/* @var $forecast app\models\Forecast */

$this->title = 'Statistics';
$this->params['subtitle'] = 'Forecast';
?>

<div class="statistic-forecast">
    
    <h3 class="list-title">Estimated expenses in current month</h3>
    
    <div class="row">
        <div class="col-sm-12">
            <ul class="list-group">
                <?php foreach (Category::getAll() as $item): ?>
                <li class="list-group-item transparent-item">
                    <label>
                        <input type="checkbox" <?= in_array($item['id'], [2, 3, 4, 5, 6]) ? 'checked' : '' ?>>
                        <?= Html::encode($item['name']) ?>
                    </label>
                    <span class="pull-right">&euro;<?= FormatHelper::number($forecast->getForecastInCategory($item['id'])) ?></span>
                </li>
                <?php endforeach; ?>
                <li class="list-group-item list-group-item-success">
                    Total
                    <span class="pull-right expenses"></span>
                </li>
            </ul>
        </div>
    </div>

</div>
