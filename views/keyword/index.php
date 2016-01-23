<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KeywordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Keywords';
$this->params['subtitle'] = 'Manage';
?>

<div class="keyword-index">
    
    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-info" role="alert"><i class="fa fa-info-circle"></i><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>

    <div class="table-responsive">

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
