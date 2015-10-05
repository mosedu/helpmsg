<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $list array */

$this->title = 'Ресурсы';
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user;

?>
<div class="resource-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
//         echo nl2br(print_r($list, true));
        foreach($list As $ob) {
            echo '<p>'.Html::a(Html::encode($ob->res_name), ['resource/topics', 'id' => $ob->res_id]).'<p>';
        }

    ?>


</div>
