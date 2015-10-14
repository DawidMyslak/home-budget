<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subcategory */

$this->title = 'Categories';
$this->params['subtitle'] = 'Update Subcategory';

?>

<div class="subcategory-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>