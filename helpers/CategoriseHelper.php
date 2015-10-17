<?php

namespace app\helpers;

use Yii;
use app\models\Keyword;

class CategoriseHelper
{
    private $userKeywords;
    private $globalKeywords;
    
    /**
     * @return void
     */
    public function prepareKeywords() {
        // find keywords for currently logged in user
        $this->userKeywords = Keyword::findAll(['user_id' => Yii::$app->user->identity->id]);
        
        // find global keywords
        $this->globalKeywords = Keyword::findAll(['user_id' => null]);
    }
    
    /**
     * @return boolean
     */
    private static function match($description, $name) {
        // remove all white spaces and make it lowercase
        $description = strtolower(preg_replace('/\s+/', '', $description));
        $name = strtolower(preg_replace('/\s+/', '', $name));
        
        // check if description contains name
        if (strpos($description, $name) !== false) {
            return true;
        }
        
        return false;
    }
    
    /**
     * @return Keyword|null
     */
    public function search($description) {
        // first, search in user keywords
        foreach ($this->userKeywords as $keyword) {
            if (self::match($description, $keyword->name)) {
                return $keyword;
            }
        }
        
        // then try in global keywords
        foreach ($this->globalKeywords as $keyword) {
            if (self::match($description, $keyword->name)) {
                return $keyword;
            }
        }
        
        return null;
    }
}
