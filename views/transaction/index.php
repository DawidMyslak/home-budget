<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['subtitle'] = 'Manage';
$this->params['buttons'][] = ['label' => 'Create Transaction', 'url' => ['create']];

?>

<div class="transaction-index">

    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'date',
                'value' => 'formattedDate',
                'label' => 'Date',
            ],
            'description',
            'money_in',
            'money_out',
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
