<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\forms\PasswordForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Account';
$this->params['subtitle'] = 'Change Password';

?>

<div class="user-password">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'currentPassword')->passwordInput() ?>
    
    <?= $form->field($model, 'newPassword')->passwordInput() ?>
    
    <?= $form->field($model, 'confirmNewPassword')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Change', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
