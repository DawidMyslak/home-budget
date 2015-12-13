<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Register';
$this->params['subtitle'] = 'Sign Up';
?>

<div class="site-register">

    <p>Please fill out the following fields to register:</p>
    
    <div class="row">
        <div class="col-sm-5">

            <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>
        
                <?= $form->field($model, 'username') ?>
        
                <?= $form->field($model, 'password')->passwordInput() ?>
                
                <?= $form->field($model, 'confirmPassword')->passwordInput() ?>
                
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-md-4">{image}</div><div class="col-md-8">{input}</div></div>',
                ]) ?>
        
                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-success', 'name' => 'register-button']) ?>
                </div>
        
            <?php ActiveForm::end(); ?>
    
        </div>
    </div>
</div>
