<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Bank;

/* @var $this yii\web\View */
/* @var $model app\models\Import */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="import-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'bank_id')->dropDownList(
        ArrayHelper::map(Bank::getAll(), 'id', 'name'),
        ['prompt' => '']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
