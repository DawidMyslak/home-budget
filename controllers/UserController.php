<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\User;
use app\models\forms\PasswordForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller
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
     * Displays profile page.
     * @return mixed
     */
    public function actionProfile()
    {
        return $this->render('profile', [
            'model' => Yii::$app->user->identity,
        ]);
    }
    
    /**
     * Displays change password form.
     * @return mixed
     */
    public function actionPassword()
    {
        $model = new PasswordForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Yii::$app->user->identity;
            $user->setPassword($model->newPassword);
            
            if ($user->save()) {
                Yii::$app->getSession()->setFlash('result', 'Password successfully changed.');
                return $this->redirect(['profile']);
            }
        }
        
        return $this->render('password', [
            'model' => $model,
        ]);
    }
}
