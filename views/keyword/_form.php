<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Subcategory;
use app\assets\DropdownAsset;

DropdownAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Keyword */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="keyword-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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
    var model = 'keyword';
    var categories = <?= Json::htmlEncode(Category::getStructure()) ?>;
</script>
