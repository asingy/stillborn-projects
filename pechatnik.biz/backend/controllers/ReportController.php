<?php

namespace backend\controllers;

use Yii;
use backend\models\ReportAgent;
use backend\models\ReportSystem;
use backend\search\ReportAgentSearch;
use backend\search\ReportSystemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportController implements the CRUD actions for ReportAgent model.
 */
class ReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ReportAgent models.
     * @return mixed
     */
    public function actionAgent()
    {
        $searchModel = new ReportAgentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('agent', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSystem()
    {
        $searchModel = new ReportSystemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('system', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}
