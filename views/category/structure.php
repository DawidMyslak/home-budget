<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $categories app\models\Category */

$this->title = 'Structure';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-structure">

    <ul class="list-group">
    <?php foreach ($categories as $category): ?>
        <li class="list-group-item list-group-item-success"><?= Html::encode($category->name) ?></li>
        <?php foreach ($category->subcategories as $subcategory): ?>
            <li class="list-group-item"><?= Html::encode($subcategory->name) ?></li>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </ul>

</div>
