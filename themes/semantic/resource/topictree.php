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
<div class="ui grid">
<div class="four wide column">
<div class="ui vertical fluid menu">

    <div class="item"><div class="header"><?= Html::encode($resource->res_name)
        . ' <sup>'
        . Html::a('<i class="edit icon"></i>', ['resource/update', 'id' => $resource->res_id, ])
        . ' '
        . Html::a('<i class="add icon"></i>', ['topic/create', 'resourceid' => $resource->res_id,])
        . '</sup>'
        ; ?></div></div>

<?php
    $oldLevel = -1;
    /** @var app\models\Topic $ob */
    $liClass = '';

    foreach($list As $ob) {
        if( $oldLevel < $ob->tpc_level ) {
//            echo ($oldLevel >= 0 ? str_repeat("\t", $oldLevel + 1) : '') . '<ul style="padding-left: 10px;">' . "\n";
            echo ($oldLevel >= 0 ? str_repeat("\t", $oldLevel + 1) : '') . '<div class="item">' . "\n";
        }
        else if( $oldLevel > $ob->tpc_level ) {
            $n = $oldLevel;
            while( $n > $ob->tpc_level ) {
//                echo str_repeat("\t", $n) . '</ul>' . "\n";
                echo str_repeat("\t", $n) . '</div>' . "\n";
                $n--;
            }
        }
        $oldLevel = $ob->tpc_level;
        $sClass = trim($liClass . ($topicid == $ob->tpc_id ? ' active' : ''));
        echo str_repeat("\t", $ob->tpc_level + 1)
//            . '<li'.($sClass != '' ? (' class="'.$sClass.'"') : '').'>'
            . Html::a(Html::encode($ob->tpc_title), ['resource/topics', 'id' => $ob->tpc_resource, 'topicid'=>$ob->tpc_id], ['class' => 'item'])
            . ' <sup>'
            . Html::a('<i class="edit icon"></i>', ['topic/update', 'id' => $ob->tpc_id, ])
            . ' '
            . Html::a('<i class="add icon"></i>', ['topic/create', 'resourceid' => $ob->tpc_resource, 'parentid' => $ob->tpc_id])
            . '</sup>'
//            . '</li>'
            . "\n";
        if(  $topicid == $ob->tpc_id ) {
            $oTopic = $ob;
        }
    }
    while( $oldLevel > -1 ) {
//        echo str_repeat("\t", $oldLevel) . '</ul>' . "\n";
        echo str_repeat("\t", $oldLevel) . '</div>' . "\n";
        $oldLevel--;
    }
?>


</div>
</div>

<div class="twelve wide stretched column">
    <?php if( $oTopic ) { ?>
        <div>
            <div style="float: right"><?= date('d.m.Y H:i', strtotime($oTopic->tpc_updated)); ?></div>
            <?= $oTopic->tpc_text; ?>
        </div>
    <?php } ?>
</div>

</div>
