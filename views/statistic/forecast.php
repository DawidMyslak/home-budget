<?php

use yii\helpers\Html;
use app\models\Category;
use app\helpers\FormatHelper;

/* @var $this yii\web\View */
/* @var $forecast app\models\Forecast */

$this->title = 'Statistics';
$this->params['subtitle'] = 'Forecast';

?>

<div class="statistic-forecast">
    
    <h3>Estimated expenses in current month</h3>
    
    <div class="row">
        <div class="col-sm-12">
            <ul class="list-group">
                <?php $summary = 0; foreach (Category::getAll() as $item):
                $forecastInCategory = $forecast->getForecastInCategory($item['id']);
                if ($forecastInCategory && in_array($item['id'], [2, 3, 4, 5, 6])): ?>
                <li class="list-group-item">
                    <?= Html::encode($item['name']) ?>
                    <span class="pull-right">&euro;<?= FormatHelper::number($forecastInCategory) ?></span>
                    <?php $summary += $forecastInCategory; ?>
                </li>
                <?php endif; endforeach; ?>
                <li class="list-group-item list-group-item-success">
                    Summary
                    <span class="pull-right">&euro;<?= FormatHelper::number($summary) ?></span>
                </li>
            </ul>
        </div>
    </div>

</div>
