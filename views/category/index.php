<?php
use yii\helpers\Html;
use app\assets\CategoryAsset;

CategoryAsset::register($this);

/* @var $this yii\web\View */
/* @var $categories array */

$this->title = 'Categories';
$this->params['subtitle'] = 'Manage';
?>

<div class="category-index">
    
    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-success" role="alert"><i class="fa fa-info-circle"></i><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>

    <div class="panel-group" role="tablist" id="accordion">
        <?php foreach ($categories as $index => $category): ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseListGroupHeading<?= $index ?>">
                    <i class="fa fa-update fa-chevron-circle-right"></i>
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseListGroup<?= $index ?>">
                        <?= Html::encode($category['name']) ?>
                    </a>
                    <span class="pull-right">
                        <?php if ($category['user_id'] !== null): ?>
                        <?= Html::a('<i class="fa fa-pencil fa-lg" data-toggle="tooltip" data-placement="top" title="Update"></i>', ['update', 'id' => $category['id']]) ?>
                        <?= Html::a('<i class="fa fa-trash fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['delete', 'id' => $category['id']], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item (including related subcategories)?',
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
                            <?= Html::a('<i class="fa fa-pencil fa-lg" data-toggle="tooltip" data-placement="top" title="Update"></i>', ['/subcategory/update', 'id' => $subcategory['id']]) ?>
                            <?= Html::a('<i class="fa fa-trash fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['/subcategory/delete', 'id' => $subcategory['id']], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?php endif; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
                <?php if (!$category['subcategories']): ?>
                    <li class="list-group-item empty transparent-item">Empty</li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>