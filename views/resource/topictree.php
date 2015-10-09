<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $resource app\models\Resource */
/* @var $list array */

$this->title = ($resource === null ? 'Содержание' : $resource->res_name);
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user;
$oTopic = null;
$aLindOpt = ['style' => 'color: #888888; font-size: 8px;', 'class'=>'showinmodal'];

$n = 0;
function addItem(&$curEl, &$list, $curlevel) {
    global $n;
    Yii::info('addItem: curlevel = ' . $curlevel);
    $el = current($list);
    while( $el !== false ) {
        $n++;
        if( $n > 25 ) {
            break;
        }
        Yii::info($el->tpc_id . ': ' . $el->tpc_level);
        if( $el->tpc_level == $curlevel ) {
            Yii::info($el->tpc_id . ': add');
            if( !isset($curEl['items']) ) {
                $curEl['items'] = [];
            }
            $curEl['items'][] = [
                'url' => ['resource/topics', 'id' => $el->tpc_resource, 'topicid'=>$el->tpc_id],
                'id' => $el->tpc_id,
//            'icon',
                'label' => $el->tpc_title,
            ];
            next($list);
            $el = current($list);
        }
        else if( $el->tpc_level > $curlevel ) {
            Yii::info($el->tpc_id . ': child');
            addItem($curEl['items'][count($curEl['items']) - 1], $list, $curlevel + 1);
            $el = current($list);
        }
        else {
            Yii::info($el->tpc_id . ': prev');
            break;
//            return;
        }
    }
}

$a = [];
addItem($a, $list, 0);
Yii::info(print_r($a, true));

?>
<!-- div class="col-sm-3" -->
    <!-- h4 style="margin-top: 0;"><?= Html::encode($resource->res_name)
        . ' <sup>'
        . ($user->can('updateResource') ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['resource/update', 'id' => $resource->res_id, ], array_merge($aLindOpt, ['title' => 'Изменение ' . $resource->res_name])) : '')
        . ' '
        . ($user->can('createTopic') ? Html::a('<span class="glyphicon glyphicon-plus"></span>', ['topic/create', 'resourceid' => $resource->res_id,], array_merge($aLindOpt, ['title' => 'Новая статья'])) : '')
        . '</sup>'
        ; ?></h4 -->

<?php

$this->beginBlock('topiclist');
    $oldLevel = -1;
    if( !isset($topicid) ) {
        $topicid = -1;
    }

    $id = array_reduce($list, function($val, $item) use ($topicid) { return (($val == -1) && ($item->tpc_id == $topicid)) ? $topicid : $val; }, -1);
    /** @var app\models\Topic $ob */
    $liClass = '';

    foreach($list As $ob) {
        if( $id == -1 ) {
            $id = $ob->tpc_id;
            $topicid = $id;
        }
        if( $oldLevel < $ob->tpc_level ) {
            echo ($oldLevel >= 0 ? (str_repeat("\t", $oldLevel + 1) . '<li>') : '') . '<ul class="treeview">' . "\n";
        }
        else if( $oldLevel > $ob->tpc_level ) {
            $n = $oldLevel;
            while( $n > $ob->tpc_level ) {
                echo str_repeat("\t", $n) . '</ul>' . ($n > 0 ? '</li>' : '') . "\n";
                $n--;
            }
        }
        $oldLevel = $ob->tpc_level;
        $sClass = trim($liClass . ($topicid == $ob->tpc_id ? ' active' : ''));
        echo str_repeat("\t", $ob->tpc_level + 1)
            . '<li'.($sClass != '' ? (' class="'.$sClass.'"') : '').'>'
            . Html::a(Html::encode($ob->tpc_title), ['resource/topics', 'id' => $ob->tpc_resource, 'topicid'=>$ob->tpc_id])
            . ' <sup>'
            . ($user->can('updateTopic') ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['topic/update', 'id' => $ob->tpc_id], array_merge($aLindOpt, ['title' => 'Изменение ' . $ob->tpc_title])) : '')
            . ' '
            . ($user->can('createTopic') ? Html::a('<span class="glyphicon glyphicon-plus"></span>', ['topic/create', 'resourceid' => $ob->tpc_resource, 'parentid' => $ob->tpc_id], array_merge($aLindOpt, ['title' => 'Новая статья'])) : '')
            . '</sup>'
            . '</li>'
            . "\n";
        if(  $topicid == $ob->tpc_id ) {
            $oTopic = $ob;
        }
    }
    while( $oldLevel > -1 ) {
        echo str_repeat("\t", $oldLevel) . '</ul>' . ($oldLevel > 0 ? '</li>' : '') . "\n";
        $oldLevel--;
    }
$this->endBlock();
?>


<!-- /div -->

<!-- div class="col-sm-9" -->
    <?php if( $oTopic ) { ?>
        <h3 style="margin-top: 0;"><?= $oTopic->tpc_title . ($user->can('updateTopic') ? (' <sup>' . Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['topic/update', 'id' => $oTopic->tpc_id], array_merge($aLindOpt, ['title' => 'Изменение ' . $oTopic->tpc_title])) . '</sup>') : '') ?> <span style="font-size: 12px; color: #777777; display: block; float: right;"><?= date('d.m.Y H:i', strtotime($oTopic->tpc_updated)); ?></span></h3>
        <?= $oTopic->tpc_text; ?>
    <?php } ?>
<!-- /div -->

<?php


$sDopCss = <<<EOT
li.active a {
    font-weight: bold;
    color: #990000;
}

ul.treeview {
    padding-left: 0;
    list-style-type: none;
}

li ul.treeview {
    padding-left: 15px;
}

EOT;

$this->registerCss($sDopCss);

