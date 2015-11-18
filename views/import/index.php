<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['subtitle'] = 'Import History';
?>

<div class="import-index">

    <div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'date',
            'file_original_name',
            
            [
                'attribute' => 'bank_id',
                'value' => 'bank.name',
                'label' => 'Bank',
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'headerOptions' => ['style' => 'width: 40px;'],
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item (including related transactions)?'),
                            'data-method' => 'post',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
    
    </div>

</div>
