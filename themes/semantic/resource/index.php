<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ресурсы';
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user;

?>
<div class="resource-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    if( $user->can('createResource') ) {
    ?>
        <p>
            <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php
    }
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'res_name',
                'content' => function ($model, $key, $index, $column) use ($searchModel) {
                    $sDop = $model->res_active == 0 ? '<span class="glyphicon glyphicon-remove" style="float: right"></span>' : '';
                    return $sDop . '' . Html::encode($model->res_name);
                },
            ],
//            'res_id',
//            'res_name',
//            'res_active',
            'res_created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
                    . ($user->can('updateResource') ? ' {update}' : '')
                    . ($user->can('workResource') ? ' {delete}' : '')
                    . ($user->can('createTopic') ? ' {createtopic}' : ''),
                'buttons' => [
                    'createtopic' => function ($url, $model) {
                        return Html::a( '<span class="glyphicon glyphicon-plus"></span>', ['topic/create', 'resourceid'=>$model->res_id], // $url,
                            ['title' => 'Добавить статью на ресурс ' . Html::encode($model->res_name), 'class'=>'btn btn-success showinmodal']);
                    },
                ],
                'buttonOptions' => ['class' => 'btn btn-success'],
            ],
        ],
    ]); ?>

</div>
