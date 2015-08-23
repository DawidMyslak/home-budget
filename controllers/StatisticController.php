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
        $moneyWithMonths = Statistic::getMoneyWithMonths(Yii::$app->user->identity->id);
        $moneyWithCategories = Statistic::getMoneyWithCategories(Yii::$app->user->identity->id);
        $moneyIn = Statistic::getMoneyIn(Yii::$app->user->identity->id);
        $moneyOut = Statistic::getMoneyOut(Yii::$app->user->identity->id);   
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
            'moneyIn' => $moneyIn,
            'moneyOut' => $moneyOut,
            'status' => $status,
            'balance' => $balance,
            'moneyWithCategories' => $moneyWithCategories,
            'moneyWithMonths' => $moneyWithMonths,
        ]);
    }
}
