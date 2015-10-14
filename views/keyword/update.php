<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Keyword */

$this->title = 'Keywords';
$this->params['subtitle'] = 'Update Keyword';

?>

<div class="keyword-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
