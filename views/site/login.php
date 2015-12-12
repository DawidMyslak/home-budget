<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['subtitle'] = 'Sign In';
?>

<div class="site-login">

    <p>Please fill out the following fields to login:</p>
    
    <div class="row">
        <div class="col-sm-5">

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        
                <?= $form->field($model, 'username') ?>
        
                <?= $form->field($model, 'password')->passwordInput() ?>
        
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="row"><div class="col-md-5">{input} {label}</div><div class="col-md-7">{error}</div></div>',
                ]) ?>
        
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>
        
            <?php ActiveForm::end(); ?>
    
        </div>
    </div>
</div>
