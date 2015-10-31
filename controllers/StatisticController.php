<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Statistic;
use app\models\Chart;
use app\models\Forecast;

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
    
    /**
     * Displays statistics dashboard.
     * @return mixed
     */
    public function actionIndex()
    {
        $year = Yii::$app->request->get('year');
        
        $statistic = new Statistic();
        $statistic->prepareResults($year);
        
        $chart = new Chart();
        $chart->prepareData($statistic);

        return $this->render('index', [
            'statistic' => $statistic,
            'chart' => $chart,
        ]);
    }
    
    /**
     * Displays forecast.
     * @return mixed
     */
    public function actionForecast()
    {
        $forecast = new Forecast();
        
        return $this->render('forecast', [
            'forecast' => $forecast,
        ]);
    }
}
