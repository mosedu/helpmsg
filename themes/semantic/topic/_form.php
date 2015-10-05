<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Topic */
/* @var $form yii\widgets\ActiveForm */

if( $model->isNewRecord ) {
    $model->tpc_resource = Yii::$app->request->getQueryParam('resourceid', -1);
    $model->tpc_parent_id = Yii::$app->request->getQueryParam('parentid', 0);
}
?>

<div class="topic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->isNewRecord ? $form->field($model, 'tpc_resource')->textInput() : '' ?>

    <?= $model->isNewRecord ? $form->field($model, 'tpc_parent_id')->textInput() : '' ?>

    <?= '' // $form->field($model, 'tpc_level')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_lft')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_rgt')->textInput() ?>

    <?= $form->field($model, 'tpc_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpc_text')->textarea(['rows' => 6]) ?>

    <?= '' // $form->field($model, 'tpc_active')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_created')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
