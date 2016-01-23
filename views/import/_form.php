<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use app\models\Bank;

/* @var $this yii\web\View */
/* @var $model app\models\Import */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-form">

    <div class="alert alert-info" role="alert">
        <i class="fa fa-info-circle"></i>You can generate CSV file with transactions history in your on-line banking service.
    </div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    
    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'text/csv',
        ],
        'pluginOptions' => [
            'showRemove' => false,
            'showUpload' => false,
            'showPreview' => false,
            'showCaption' => true,
            'browseClass' => 'btn btn-success btn-block',
            'browseIcon' => '<i class="fa fa-folder-open"></i> ',
            'browseLabel' => 'Browse...',
        ],
    ]) ?>

    <?= $form->field($model, 'bank_id')->dropDownList(
        ArrayHelper::map(Bank::getAll(), 'id', 'name'),
        ['prompt' => '']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
