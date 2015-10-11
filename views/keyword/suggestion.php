<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KeywordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Keywords Suggestions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="keyword-suggestion">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="list-group">
    <?php foreach ($searchModel->possibleKeywords as $keyword): ?>
        <li class="list-group-item"><?= Html::a($keyword['name'], ['create', 'name' => $keyword['name']]) ?> (in <strong><?= Html::encode($keyword['count']) ?></strong> transactions)</li>
    <?php endforeach; ?>
    </ul>

</div>
