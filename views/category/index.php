<?php
use yii\helpers\Html;
use app\assets\CategoryAsset;

CategoryAsset::register($this);

/* @var $this yii\web\View */
/* @var $categories array */

$this->title = 'Categories';
$this->params['subtitle'] = 'Manage';
$this->params['buttons'][] = ['label' => 'Create Category', 'url' => ['create']];
$this->params['buttons'][] = ['label' => 'Create Subcategory', 'url' => ['/subcategory/create']];

?>

<div class="category-index">

    <div class="panel-group" role="tablist" id="accordion">
        <?php foreach ($categories as $index => $category): ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseListGroupHeading<?= $index ?>">
                    <span class="caret caret-rotated"></span>
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseListGroup<?= $index ?>">
                        <?= Html::encode($category['name']) ?>
                    </a>
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
            </div>
            <div id="collapseListGroup<?= $index ?>" class="panel-collapse collapse" role="tabpanel">
                <ul class="list-group">
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
                </ul>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>