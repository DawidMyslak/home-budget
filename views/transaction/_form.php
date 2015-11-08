<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Subcategory;
use app\assets\DropdownAsset;

DropdownAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php $model->date = $model->formattedDate; ?>
    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        'type' => DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'autoclose' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_out')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(Category::getAll(), 'id', 'name'),
        ['prompt' => '']
    )->label('Category') ?>

    <?= $form->field($model, 'subcategory_id')->dropDownList(
        ArrayHelper::map(Subcategory::getAll(), 'id', 'name'),
        ['prompt' => '']
    )->label('Subcategory') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var model = 'transaction';
    var categories = <?= Json::htmlEncode(Category::getStructure()) ?>;
</script>
