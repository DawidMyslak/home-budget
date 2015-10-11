<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KeywordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Keywords';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="keyword-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Keyword', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'name',
            [
                'attribute' => 'category_id',
                'value' => 'category.name',
                'label' => 'Category',
            ],
            [
                'attribute' => 'subcategory_id',
                'value' => 'subcategory.name',
                'label' => 'Subcategory', 
            ],
            
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}', 'headerOptions' => ['style' => 'width: 80px;']],
        ],
    ]); ?>

</div>
