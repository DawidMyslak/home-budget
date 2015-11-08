<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Subcategory */

$this->title = 'Categories';
$this->params['subtitle'] = 'Create Subcategory';
?>

<div class="subcategory-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>