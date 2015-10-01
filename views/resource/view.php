<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Resource */

$this->title = $model->res_name;
$this->params['breadcrumbs'][] = ['label' => 'Ресурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resource-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= '' /* Html::a('Изменить', ['update', 'id' => $model->res_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->res_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'res_id',
            'res_name',
//            'res_active',
            'res_created',
        ],
    ]) ?>

</div>
