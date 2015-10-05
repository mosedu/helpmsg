<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TopicSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tpc_id') ?>

    <?= $form->field($model, 'tpc_resource') ?>

    <?= $form->field($model, 'tpc_level') ?>

    <?= $form->field($model, 'tpc_lft') ?>

    <?= $form->field($model, 'tpc_rgt') ?>

    <?php // echo $form->field($model, 'tpc_title') ?>

    <?php // echo $form->field($model, 'tpc_text') ?>

    <?php // echo $form->field($model, 'tpc_active') ?>

    <?php // echo $form->field($model, 'tpc_created') ?>

    <?php // echo $form->field($model, 'tpc_updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
