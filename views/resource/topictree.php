<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $resource app\models\Resource */
/* @var $list array */

$this->title = ($resource === null ? 'Содержание' : $resource->res_name);
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user;
$oTopic = null;
$aLindOpt = ['style' => 'color: #888888; font-size: 8px;'];
?>
<div class="col-sm-3">
    <h3><?= Html::encode($resource->res_name)
        . ' <sup>'
        . Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['resource/update', 'id' => $resource->res_id, ], $aLindOpt)
        . ' '
        . Html::a('<span class="glyphicon glyphicon-plus"></span>', ['topic/create', 'resourceid' => $resource->res_id,], $aLindOpt)
        . '</sup>'
        ; ?></h3>

<?php
    $oldLevel = -1;
    /** @var app\models\Topic $ob */
    $liClass = '';

    foreach($list As $ob) {
        if( $oldLevel < $ob->tpc_level ) {
            echo ($oldLevel >= 0 ? str_repeat("\t", $oldLevel + 1) : '') . '<ul style="padding-left: 10px;">' . "\n";
        }
        else if( $oldLevel > $ob->tpc_level ) {
            $n = $oldLevel;
            while( $n > $ob->tpc_level ) {
                echo str_repeat("\t", $n) . '</ul>' . "\n";
                $n--;
            }
        }
        $oldLevel = $ob->tpc_level;
        $sClass = trim($liClass . ($topicid == $ob->tpc_id ? ' active' : ''));
        echo str_repeat("\t", $ob->tpc_level + 1)
            . '<li'.($sClass != '' ? (' class="'.$sClass.'"') : '').'>'
            . Html::a(Html::encode($ob->tpc_title), ['resource/topics', 'id' => $ob->tpc_resource, 'topicid'=>$ob->tpc_id])
            . ' <sup>'
            . Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['topic/update', 'id' => $ob->tpc_id, ], $aLindOpt)
            . ' '
            . Html::a('<span class="glyphicon glyphicon-plus"></span>', ['topic/create', 'resourceid' => $ob->tpc_resource, 'parentid' => $ob->tpc_id], $aLindOpt)
            . '</sup>'
            . '</li>'
            . "\n";
        if(  $topicid == $ob->tpc_id ) {
            $oTopic = $ob;
        }
    }
    while( $oldLevel > -1 ) {
        echo str_repeat("\t", $oldLevel) . '</ul>' . "\n";
        $oldLevel--;
    }
?>


</div>

<div class="col-sm-9">
    <?php if( $oTopic ) { ?>
        <p><?= date('d.m.Y H:i', strtotime($oTopic->tpc_updated)); ?></p>
        <?= $oTopic->tpc_text; ?>
    <?php } ?>
</div>
