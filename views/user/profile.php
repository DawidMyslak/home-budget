
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Account';
$this->params['subtitle'] = 'Profile';

?>
<div class="user-profile">

    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-sm-1">
            <i class="fa fa-user fa-5x usericon"></i> 
        </div>
        <div class="col-sm-11">
            <h2 class="welcome">Welcome</h1>
            <h4 class="username"><?= Html::encode($model->username) ?></h4>
        </div>
    </div>

</div>
