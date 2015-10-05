<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user;

?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- p>
        <?= '' // Html::a('Create Topic', ['create'], ['class' => 'btn btn-success']) ?>
    </p -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'tpc_id',
                'content' => function ($model, $key, $index, $column) use ($searchModel) {
                    return $model->tpc_id . '<br />' . $model->tpc_resource . ' * ' . $model->tpc_parent_id . ' [' . $model->tpc_lft . ', ' . $model->tpc_rgt . ']';
                },
            ],
//            'tpc_id',
//            'tpc_resource',
            'tpc_level',
//            'tpc_lft',
//            'tpc_rgt',
             'tpc_title',
            // 'tpc_text:ntext',
            // 'tpc_active',
            'tpc_created',
            'tpc_updated',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
                    . ($user->can('updateTopic') ? ' {update}' : '')
                    . ($user->can('hideTopic') ? ' {delete}' : '')
                    . ($user->can('createTopic') ? ' {createtopic}' : ''),
                'buttons' => [
                    'createtopic' => function ($url, $model) {
                        return Html::a( '<span class="glyphicon glyphicon-plus"></span>', ['topic/create', 'resourceid'=>$model->tpc_resource, 'parentid'=>$model->tpc_id], // $url,
                            ['title' => 'Добавить дочернюю к ' . Html::encode($model->tpc_title), 'class'=>'btn btn-success showinmodal']);
                    },
                ],
                'buttonOptions' => ['class' => 'btn btn-success'],
            ],
        ],
    ]); ?>

</div>
