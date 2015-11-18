<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KeywordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Keywords';
$this->params['subtitle'] = 'Suggestions';
?>

<div class="keyword-suggestion">
    
    <h3 class="list-title">Popular descriptions in your transactions</h3>
    
    <ul class="list-group">
    <?php foreach ($searchModel->possibleKeywords as $keyword): ?>
        <li class="list-group-item transparent-item">
            <?= Html::a(Html::encode($keyword['name']), ['create', 'name' => $keyword['name']]) ?>
            <span class="pull-right">(in <strong><?= $keyword['count'] ?></strong> transactions)</span>
        </li>
    <?php endforeach; ?>
    </ul>

</div>
