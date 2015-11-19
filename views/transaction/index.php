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
?>

<div class="transaction-index">

    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-success" role="alert"><i class="fa fa-info-circle"></i><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>
    
    <?php $buttons = Html::a('Expenses',
        urldecode(Url::toRoute(['index', 'display' => TransactionSearch::EXPENSES])),
        ['class' => $searchModel->display === TransactionSearch::EXPENSES ? 'btn btn-success btn-sm' : 'btn btn-default btn-sm']) ?>
    
    <?php $buttons .= Html::a('Incomes',
        urldecode(Url::toRoute(['index', 'display' => TransactionSearch::INCOMES])),
        ['class' => $searchModel->display === TransactionSearch::INCOMES ? 'btn btn-success btn-sm' : 'btn btn-default btn-sm']) ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">
    
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
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'headerOptions' => ['style' => 'width: 80px;'],
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pencil fa-lg" data-toggle="tooltip" data-placement="top" title="Update"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
    
    </div>

</div>
