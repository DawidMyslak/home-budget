<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Displays a structure of all Category and Subcategory models.
     * @return mixed
     */
    public function actionStructure()
    {
        $categories = Category::find()
            ->with('subcategories')
            ->all();

        return $this->render('structure', [
            'categories' => $categories,
        ]);
    }
}
