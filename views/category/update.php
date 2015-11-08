<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Categories';
$this->params['subtitle'] = 'Update Category';
?>

<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>