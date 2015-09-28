<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Transactions', ['import'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Categorise Transactions', ['categorise'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'filter' => ArrayHelper::map(Category::getAll(), 'id', 'name'), 
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
