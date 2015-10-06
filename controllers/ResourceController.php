<?php

namespace app\controllers;

use Yii;
use app\models\Resource;
use app\models\ResourceSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Html;

/**
 * ResourceController implements the CRUD actions for Resource model.
 */
class ResourceController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Resource models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays resorce topics
     * @param integer $id
     * @return mixed
     */
    public function actionTopics($id = 0)
    {
        return $this->render('topics', [
            'model' => ($id > 0 ? $this->findModel($id) : null ),
            'topicid' => Yii::$app->request->getQueryParam('topicid', -1),
        ]);
    }

    /**
     * Displays a single Resource model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Resource model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->actionUpdate(0);
/*
        $model = new Resource();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', ]);
//            return $this->redirect(['view', 'id' => $model->res_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
*/
    }

    /**
     * Updates an existing Resource model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if( $id == 0 ) {
            if( !Yii::$app->user->can('createResource') ) {
                throw new ForbiddenHttpException('У Вас нет прав для создания ресурса.');
            }

            $model = new Resource();
            $model->loadDefaultValues();
        }
        else {
            if( !Yii::$app->user->can('updateResource') ) {
                throw new ForbiddenHttpException('У Вас нет прав для изменения ресурса.');
            }

            $model = $this->findModel($id);
        }

        if( Yii::$app->request->isAjax ) {
            if ($model->load(Yii::$app->request->post())) {

                $aValidate = ActiveForm::validate($model);
                Yii::$app->response->format = Response::FORMAT_JSON;

                if( count($aValidate) == 0 ) {
                    if( !$model->save() ) {
                        $aValidate[Html::getInputId($model, 'res_name')] = ['Error save to DB: ' . print_r($model->getErrors(), true)];
                    }
                }
                return $aValidate;
            } else {
                return $this->renderAjax(
                    '_form',
                    [
                        'model' => $model,
                    ]
                );
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['resource/topics', 'id' => $model->res_id]);
//            return $this->redirect(['index', ]);
//            return $this->redirect(['view', 'id' => $model->res_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Resource model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if( !Yii::$app->user->can('workResource') ) {
            throw new ForbiddenHttpException();
        }
        /** @var Resource $model */
        $model = $this->findModel($id);
        $model->res_active = 0;
        $model->save();
//        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Resource model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resource the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resource::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
