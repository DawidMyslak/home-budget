<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\TransactionSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['subtitle'] = 'Manage';
$this->params['buttons'][] = ['label' => 'Create', 'url' => ['create']];
$this->params['buttons'][] = ['label' => 'Import', 'url' => ['/import/create']];
$this->params['buttons'][] = ['label' => 'Import History', 'url' => ['/import/index']];

?>

<div class="transaction-index">

    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>
    
    <?php $buttons = Html::a('Expenses',
        urldecode(Url::toRoute(['index', 'display' => TransactionSearch::EXPENSES])),
        ['class' => $searchModel->display === TransactionSearch::EXPENSES ? 'btn btn-info btn-sm' : 'btn btn-default btn-sm']) ?>
    
    <?php $buttons .= Html::a('Income',
        urldecode(Url::toRoute(['index', 'display' => TransactionSearch::INCOME])),
        ['class' => $searchModel->display === TransactionSearch::INCOME ? 'btn btn-info btn-sm' : 'btn btn-default btn-sm']) ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}$buttons\n{items}\n{pager}",
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'date',
                'value' => 'formattedDate',
                'label' => 'Date',
            ],
            'description',
            $searchModel->display,
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
