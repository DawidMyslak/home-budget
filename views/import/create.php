<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Import */

$this->title = 'Transactions';
$this->params['subtitle'] = 'Import';
?>

<div class="import-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
