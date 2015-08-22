<?php

namespace app\helpers;

use Yii;
use app\models\Keyword;

class CategoriseHelper
{
    private $userKeywords;
    private $globalKeywords;
    
    public function prepareKeywords() {
        $this->userKeywords = Keyword::findAll(['user_id' => Yii::$app->user->identity->id]);
        $this->globalKeywords = Keyword::findAll(['user_id' => null]);
    }
    
    private static function match($description, $name) {
        if (strpos(strtolower($description), $name) !== false) {
            return true;
        }
        
        return false;
    }
    
    public function search($description) {
        foreach ($this->userKeywords as $keyword) {
            if (self::match($description, $keyword->name)) {
                return $keyword;
            }
        }
        
        foreach ($this->globalKeywords as $keyword) {
            if (self::match($description, $keyword->name)) {
                return $keyword;
            }
        }
        
        return null;
    }
}
