<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Categories';
$this->params['subtitle'] = 'Create Category';

?>

<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>