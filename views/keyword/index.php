<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KeywordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Keywords';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="keyword-index">

<?php if ($searchModel->possibleKeywords): ?>
    <h1>Keywords Suggestions</h1>

    <ul class="list-group">
    <?php foreach ($searchModel->possibleKeywords as $keyword): ?>
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
            
            'name',
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
