<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KeywordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Keywords';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="keyword-index">

<?php if ($possibleKeywords): ?>
    <h1>Keywords Suggestions</h1>

    <ul class="list-group">
    <?php foreach ($possibleKeywords as $keyword): ?>
        <li class="list-group-item"><?= Html::a($keyword['name'], ['create', 'name' => $keyword['name']]) ?> (in <strong><?= Html::encode($keyword['count']) ?></strong> transactions)</li>
    <?php endforeach; ?>
    </ul>
    
<?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Keyword', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'user_id',
            [
                'attribute' => 'category',
                'value' => 'category.name',
            ],
            [
                'attribute' => 'subcategory',
                'value' => 'subcategory.name',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
