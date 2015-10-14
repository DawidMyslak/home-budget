
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Account';
$this->params['subtitle'] = 'Profile';

?>
<div class="user-profile">

    <?php if (Yii::$app->session->hasFlash('result')): ?>
        <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('result') ?></div>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
        ],
    ]) ?>

</div>
