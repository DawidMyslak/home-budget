<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Transactions', ['import'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'date',
            'description',
            'money_in',
            'money_out',
            [
                'attribute' => 'category',
                'value' => 'category.name',
            ],
            [
                'attribute' => 'subcategory',
                'value' => 'subcategory.name',
            ],
            // 'balance',
            // 'hash',
            // 'user_id',
            // 'category_id',
            // 'subcategory_id',
            // 'keyword_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
