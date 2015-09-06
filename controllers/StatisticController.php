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
        $year = Yii::$app->request->get('year', 2015);
        
        $statistic = new Statistic();
        $statistic->prepareData($year);

        return $this->render('index', [
            'statistic' => $statistic
        ]);
    }
}
