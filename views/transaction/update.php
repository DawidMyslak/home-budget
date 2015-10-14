<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = 'Transactions';
$this->params['subtitle'] = 'Update Transaction';

?>

<div class="transaction-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
