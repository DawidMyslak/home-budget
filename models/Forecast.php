<?php

namespace app\models;

use Yii;

class Forecast extends \yii\base\Object
{   
    /**
     * @return array
     */
    public function getForecastInCategory($categoryId)
    {
        $sql = 'SELECT SUM(sum) / 3 FROM (SELECT * FROM (SELECT SUM(money_out) AS sum FROM transaction
                WHERE DATE_FORMAT(date ,"%Y-%m") < DATE_FORMAT(NOW(), "%Y-%m")
                AND DATE_FORMAT(date, "%Y-%m") >= DATE_FORMAT(NOW() - INTERVAL 5 MONTH, "%Y-%m")
                AND category_id = :category_id AND user_id = :user_id
                GROUP BY DATE_FORMAT(date, "%Y-%m")
                ORDER BY sum
                LIMIT 4) AS temp
                ORDER BY sum desc
                LIMIT 3) AS temp2';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', Yii::$app->user->identity->id)
            ->bindValue(':category_id', $categoryId)
            ->queryScalar();
    }
}
