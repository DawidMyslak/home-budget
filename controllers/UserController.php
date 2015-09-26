<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\User;
use app\models\forms\PasswordForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
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
     * Displays currently logged in User model.
     * @return mixed
     */
    public function actionProfile()
    {
        return $this->render('profile', [
            'model' => Yii::$app->user->identity,
        ]);
    }
    
    public function actionPassword()
    {
        $model = new PasswordForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Yii::$app->user->identity;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->newPassword);
            
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
