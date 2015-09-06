<?php

namespace app\models;

use Yii;

class Statistic extends \yii\base\Object
{
    public static function getMoneyWithMonths($userId, $year)
    {
        $sql = 'SELECT DATE_FORMAT(date, "%Y-%m") AS date, SUM(money_out) AS sum_out, SUM(money_in) AS sum_in
                FROM transaction
                WHERE user_id=:user_id AND YEAR(date)=:year
                GROUP BY DATE_FORMAT(date, "%Y-%m")
                ORDER BY date';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->bindValue(':year', $year)
            ->queryAll();
    }
    
    public static function getMoneyWithCategories($userId, $year)
    {
        $sql = 'SELECT c.id AS id, IFNULL(c.name, "Uncategorized") AS name, SUM(t.money_out) AS sum
                FROM category c
                RIGHT JOIN transaction t ON c.id=t.category_id
                WHERE t.user_id=:user_id AND YEAR(t.date)=:year
                GROUP BY c.id
                ORDER BY c.id';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->bindValue(':year', $year)
            ->queryAll();
    }
    
    public static function getMoneyWithSubcategories($userId, $year)
    {
        $sql = 'SELECT c.id AS cid, s.id AS sid, IFNULL(c.name, "Uncategorized") AS cname, IFNULL(s.name, "Uncategorized") AS sname, SUM(t.money_out) AS sum
                FROM subcategory s
                RIGHT JOIN transaction t ON s.id=t.subcategory_id
                LEFT JOIN category c ON s.category_id=c.id
                WHERE t.user_id=:user_id AND YEAR(t.date)=:year
                GROUP BY s.id
                ORDER BY c.id, s.id;';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->bindValue(':year', $year)
            ->queryAll();
    }
    
    public static function getMoneyIn($userId, $year)
    {
        $sql = 'SELECT SUM(money_in) FROM transaction WHERE user_id=:user_id AND YEAR(date)=:year';
        
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->bindValue(':year', $year)
            ->queryScalar();
    }
    
    public static function getMoneyOut($userId, $year)
    {
        $sql = 'SELECT SUM(money_out) FROM transaction WHERE user_id=:user_id AND YEAR(date)=:year';
        
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $userId)
            ->bindValue(':year', $year)
            ->queryScalar();
    }
}
