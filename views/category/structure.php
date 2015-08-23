<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $categories app\models\Category */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-structure">
    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="list-group">
    <?php foreach ($categories as $category): ?>
        <li class="list-group-item list-group-item-success"><?= Html::encode($category->name) ?></li>
        <?php foreach ($category->subcategories as $subcategory): ?>
            <li class="list-group-item"><?= Html::encode($subcategory->name) ?></li>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </ul>

</div>
