<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Topic */

$this->title = $model->isNewRecord ? 'Создать' : ('Изменить: ' . ' ' . $model->tpc_title);
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
if( !$model->isNewRecord ) {
    $this->params['breadcrumbs'][] = ['label' => $model->tpc_title, 'url' => ['view', 'id' => $model->tpc_id]];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
