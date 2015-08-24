<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Statistic;

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
        $userId = Yii::$app->user->identity->id;
        $year = Yii::$app->request->get('year', 2015);
        
        $moneyWithMonths = Statistic::getMoneyWithMonths($userId, $year);
        $moneyWithCategories = Statistic::getMoneyWithCategories($userId, $year);
        $moneyWithSubcategories = Statistic::getMoneyWithSubcategories($userId, $year);
        $moneyIn = Statistic::getMoneyIn($userId, $year);
        $moneyOut = Statistic::getMoneyOut($userId, $year);   
        $balance = $moneyIn - $moneyOut;
        
        $status = '';
        if ($balance > 0) {
            $status = '+';
        }
        else if ($balance < 0) {
            $status = '-';
        }
        $balance = abs($balance);

        return $this->render('index', [
            'year' => $year,
            'moneyIn' => $moneyIn,
            'moneyOut' => $moneyOut,
            'status' => $status,
            'balance' => $balance,
            'moneyWithCategories' => $moneyWithCategories,
            'moneyWithSubcategories' => $moneyWithSubcategories,
            'moneyWithMonths' => $moneyWithMonths,
        ]);
    }
}
