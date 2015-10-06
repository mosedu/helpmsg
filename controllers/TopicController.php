<?php

namespace app\controllers;

use Yii;
use app\models\Topic;
use app\models\TopicSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Html;

use vova07\imperavi\actions\GetAction;

/**
 * TopicController implements the CRUD actions for Topic model.
 */
class TopicController extends Controller
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

    public function actions()
    {
        return [
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => '//' . $_SERVER['HTTP_HOST'] . '/' . Topic::UPLOAD_PATH . '/' . Topic::UPLOAD_IMG_PATH,
                'path' => Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . Topic::UPLOAD_PATH . DIRECTORY_SEPARATOR . Topic::UPLOAD_IMG_PATH,
                'type' => GetAction::TYPE_IMAGES,
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '//' . $_SERVER['HTTP_HOST'] . '/' . Topic::UPLOAD_PATH . '/' . Topic::UPLOAD_IMG_PATH,
                'path' => '@webroot/' . Topic::UPLOAD_PATH . '/' . Topic::UPLOAD_IMG_PATH,
            ],
        ];
    }

    /**
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Topic model.
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
     * Creates a new Topic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->actionUpdate(0);
/*
        $model = new Topic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tpc_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
*/
    }

    /**
     * Updates an existing Topic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if( $id == 0 ) {
            if( !Yii::$app->user->can('createTopic') ) {
                throw new ForbiddenHttpException('У Вас нет прав для создания страницы.');
            }

            $model = new Topic();
            $model->loadDefaultValues();
        }
        else {
            if( !Yii::$app->user->can('updateTopic') ) {
                throw new ForbiddenHttpException('У Вас нет прав для изменения страницы.');
            }

            $model = $this->findModel($id);
        }

        if( Yii::$app->request->isAjax ) {
            if ($model->load(Yii::$app->request->post())) {

                $aValidate = ActiveForm::validate($model);
                Yii::$app->response->format = Response::FORMAT_JSON;
//                Yii::info('actionUpdate('.$id.')  aValidate = ' . print_r($aValidate, true));

                if( count($aValidate) == 0 ) {
                    if( $model->isNewRecord ? $model->appendTo($model->tpc_resource, $model->tpc_parent_id) : $model->save() ) {
                    }
                    else {
                        $aValidate[Html::getInputId($model, 'tpc_text')] = ['Error save to DB: ' . print_r($model->getErrors(), true)];
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

        if ($model->load(Yii::$app->request->post()) ) {
            if( $model->isNewRecord ? $model->appendTo($model->tpc_resource, $model->tpc_parent_id) : $model->save() ) {
                return $this->redirect(['resource/topics', 'id' => $model->tpc_resource, 'topicid' => $model->tpc_id]);
//                return $this->redirect(['index', ]);
//                return $this->redirect(['view', 'id' => $model->tpc_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Topic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Topic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Topic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Topic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
