<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $categories array */
$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Subcategory', ['/subcategory/create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <ul class="list-group">
    <?php foreach ($categories as $category): ?>
        <li class="list-group-item list-group-item-success">
            <?= Html::encode($category['name']) ?>
            
            <span class="pull-right">
                <?php if ($category['user_id'] !== null): ?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $category['id']]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $category['id']], [
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?php endif; ?>
            </span>
        </li>
        <?php foreach ($category['subcategories'] as $subcategory): ?>
            <li class="list-group-item">
                <?= Html::encode($subcategory['name']) ?>
                
                <span class="pull-right">
                    <?php if ($subcategory['user_id'] !== null): ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/subcategory/update', 'id' => $subcategory['id']]) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/subcategory/delete', 'id' => $subcategory['id']], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?php endif; ?>
                </span>
            </li>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </ul>

</div>