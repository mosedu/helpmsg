<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tpc_resource')->textInput() ?>

    <?= $form->field($model, 'tpc_level')->textInput() ?>

    <?= $form->field($model, 'tpc_lft')->textInput() ?>

    <?= $form->field($model, 'tpc_rgt')->textInput() ?>

    <?= $form->field($model, 'tpc_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpc_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tpc_active')->textInput() ?>

    <?= $form->field($model, 'tpc_created')->textInput() ?>

    <?= $form->field($model, 'tpc_updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
