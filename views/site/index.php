<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\assets\StartAsset;

StartAsset::register($this);

$this->title = 'HomeBudget.ie';
?>

<div class="home">
    <div class="container">
    
        <div class="jumbotron">
            <h1 class="animated pulse">HomeBudget.ie</h1>
    
            <p class="lead animated zoomIn">Your incomes and expenses in one place</p>
            
            <?= Html::a('Sign Up', ['register'], ['class' => 'btn btn-lg btn-default animated flipInX']) ?>
        </div>
        
    </div>
</div>

<div class="container">
    <div class="row">
        
        <div class="col-sm-4 tile">
            <i class="fa fa-file-text fa-5x"></i>
            
            <h2>Import</h2>
            
            <p>Import transactions from your bank.</p>
        </div>
        <div class="col-sm-4 tile">
            <i class="fa fa-tags fa-5x"></i>
            
            <h2>Categorize</h2>

            <p>Automatically categorize expenses.</p>
        </div>
        <div class="col-sm-4 tile">
            <i class="fa fa-pie-chart fa-5x"></i>
            
            <h2>Analyze</h2>

            <p>Analyze charts and categorized data.</p>
        </div>
        
    </div>
</div>

<div class="white-section">
    <div class="container">
        <div class="row">
            
            <div class="col-sm-4 tile">
                <i class="fa fa-users fa-5x"></i>
                
                <h2>Share</h2>
    
                <p>Share your data with family and friends.</p>
            </div>
            <div class="col-sm-4 tile">
                <i class="fa fa-mobile fa-3x"></i>
                <i class="fa fa-tablet fa-5x"></i>
                
                <h2>Multi-platform</h2>
                
                <p>Access on laptop, tablet or smartphone.</p>
            </div>
            <div class="col-sm-4 tile">
                <i class="fa fa-check-square-o fa-5x"></i>
                
                <h2>Free</h2>
    
                <p>Enjoy HomeBudget.ie for free!</p>
            </div>
            
        </div>
    </div>
</div>
