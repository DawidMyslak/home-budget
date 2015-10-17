<?php

use yii\helpers\Html;
use app\models\Category;

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
                <?php foreach (Category::getAll() as $item):
                $forecastInCategory = $forecast->getForecastInCategory($item['id']);
                if ($forecastInCategory): ?>
                <li class="list-group-item">
                    <?= Html::encode($item['name']) ?>
                    <span class="pull-right">&euro;<?= $forecastInCategory ?></span>
                </li>
                <?php endif; endforeach; ?>
            </ul>
        </div>
    </div>

</div>
