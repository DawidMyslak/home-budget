<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Subcategory;
use app\assets\CategoryAsset;

CategoryAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Keyword */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="keyword-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        ['prompt' => '']
    ) ?>

    <?= $form->field($model, 'subcategory_id')->dropDownList(
        ArrayHelper::map(Subcategory::find()->all(), 'id', 'name'),
        ['prompt' => '']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var categories = <?= Json::encode($categories) ?>;
</script>
