<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = 'Transactions';
$this->params['subtitle'] = 'Create Transaction';
?>

<div class="transaction-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
