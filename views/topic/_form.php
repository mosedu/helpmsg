<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;


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

    <?= $model->isNewRecord ? $form->field($model, 'tpc_resource', ['template' => '{input}'])->hiddenInput() : '' ?>

    <?= $model->isNewRecord ? $form->field($model, 'tpc_parent_id', ['template' => '{input}'])->hiddenInput() : '' ?>

    <?= '' // $form->field($model, 'tpc_level')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_lft')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_rgt')->textInput() ?>

    <?= $form->field($model, 'tpc_title')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'tpc_text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'tpc_text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'pastePlainText' => true,
            'buttons' => ['formatting', 'bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist', 'link', 'alignment', 'image',], // 'outdent', 'indent',
            'imageManagerJson' => Url::to(['/topic/images-get']),
            'imageUpload' => Url::to(['/topic/image-upload']),
            'plugins' => [
//                'image',
                'imagemanager',
//                'clips',
//                'fullscreen',
            ]
        ]
    ]) ?>

    <?= '' // $form->field($model, 'tpc_active')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_created')->textInput() ?>

    <?= '' // $form->field($model, 'tpc_updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
