<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Resource */

$this->title = $model->isNewRecord ? 'Создание ресурса' : ('Изменение ресурса: ' . ' ' . $model->res_name);
$this->params['breadcrumbs'][] = ['label' => 'Ресурсы', 'url' => ['index']];
if( !$model->isNewRecord ) {
    $this->params['breadcrumbs'][] = ['label' => $model->res_name, 'url' => ['view', 'id' => $model->res_name]];
}
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="resource-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
