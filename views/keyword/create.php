<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Keyword */

$this->title = 'Keywords';
$this->params['subtitle'] = 'Create Keyword';

?>

<div class="keyword-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
