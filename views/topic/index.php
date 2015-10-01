<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Topic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tpc_id',
            'tpc_resource',
            'tpc_level',
            'tpc_lft',
            'tpc_rgt',
            // 'tpc_title',
            // 'tpc_text:ntext',
            // 'tpc_active',
            // 'tpc_created',
            // 'tpc_updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
