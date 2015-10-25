<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Keyword;
use app\models\KeywordSearch;
use app\models\Transaction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class KeywordController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Keyword models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KeywordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Keyword models.
     * @return mixed
     */
    public function actionSuggestion()
    {
        $searchModel = new KeywordSearch();

        return $this->render('suggestion', [
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new Keyword model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Keyword();
        $model->name = Yii::$app->request->get('name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = new Transaction();
            $transaction->categorise($model);
            
            Yii::$app->getSession()->setFlash('result', 'Keyword created, ' . $transaction->getResult());
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Keyword model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = new Transaction();
            $transaction->categorise($model);
            
            Yii::$app->getSession()->setFlash('result', 'Keyword updated, ' . $transaction->getResult());
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Keyword model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->getSession()->setFlash('result', 'Keyword deleted.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Keyword model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Keyword the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Keyword::findById($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
