<?php

namespace app\models;

use Yii;

class Statistic extends \yii\base\Object
{
    public static function getMoneyWithMonths($userId)
    {
        $sql = 'SELECT DATE_FORMAT(date, "%Y-%m") AS date, SUM(money_out) AS sum_out, SUM(money_in) AS sum_in
                FROM transaction
                WHERE user_id=:user_id
                GROUP BY DATE_FORMAT(date, "%Y-%m")
                ORDER BY date';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->queryAll();
    }
    
    public static function getMoneyWithCategories($userId)
    {
        $sql = 'SELECT c.id AS id, IFNULL(c.name, "Uncategorized") AS name, SUM(money_out) AS sum
                FROM category c
                RIGHT JOIN transaction t ON c.id=t.category_id
                WHERE t.user_id=:user_id
                GROUP BY c.id
                ORDER BY sum DESC';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->queryAll();
    }
    
    public static function getMoneyIn($userId)
    {
        $sql = 'SELECT SUM(money_in) FROM transaction WHERE user_id=:user_id';
        
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->queryScalar();
    }
    
    public static function getMoneyOut($userId)
    {
        $sql = 'SELECT SUM(money_out) FROM transaction WHERE user_id=:user_id';
        
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->queryScalar();
    }
}
