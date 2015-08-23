<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class StatisticController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        // money with categories
        $sql = 'SELECT c.id AS id, IFNULL(c.name, "Uncategorized") AS name, SUM(money_out) AS sum FROM category c
                RIGHT JOIN transaction t ON c.id=t.category_id
                WHERE t.user_id=:user_id
                GROUP BY c.id';
                
        $moneyWithCategories = Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', Yii::$app->user->identity->id)
            ->queryAll();
        
        // money in
        $sql = 'SELECT SUM(money_in) FROM transaction WHERE user_id=:user_id';
        
        $moneyIn = Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', Yii::$app->user->identity->id)
            ->queryScalar();
        
        // money out
        $sql = 'SELECT SUM(money_out) FROM transaction WHERE user_id=:user_id';
        
        $moneyOut = Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', Yii::$app->user->identity->id)
            ->queryScalar();
            
        // balance    
        $balance = $moneyIn - $moneyOut;

        return $this->render('index', [
            'moneyIn' => $moneyIn,
            'moneyOut' => $moneyOut,
            'balance' => $balance,
            'moneyWithCategories' => $moneyWithCategories,
        ]);
    }
}
