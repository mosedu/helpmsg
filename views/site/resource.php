<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use app\models\Resource;
use app\models\Topic;

$user = Yii::$app->user;

$this->title = 'Ресурсы';

$aLindOpt = ['style' => 'color: #888888; font-size: 8px;', ]; // 'class'=>'showinmodal'

?>
<div class="site-index">
    <?php
        $aFields = array_keys((new Resource())->attributeLabels());
        $stable = Resource::tableName();
        $slave = Topic::tableName();
        $sFields = array_reduce($aFields, function($val, $item) use ($stable) { return $val . ($val == '' ? '' : ', ') . $stable . '.' .  $item; }, '');
        $sFields .= ', COUNT(' . $slave . '.tpc_id) As topicCount';

//        echo '<p>sFields = '.$sFields.'</p>';

        $a = Resource::find()
            ->select($sFields)
            ->where([$stable . '.res_active' => 1])
            ->leftJoin($slave, $slave . '.tpc_resource = ' . $stable . '.res_id')
            ->groupBy($stable . '.res_id')
            ->all();

        if( count($a) == 0 ) {
            echo '<p>Пока статей нет.</p>';
        }
        foreach($a As $resource) {
            echo '<p>'
                . Html::a(Html::encode($resource->res_name), ['resource/topics', 'id'=>$resource->res_id])
                . ($resource->topicCount > 0 ? (' [' . $resource->topicCount . ']') : '')
                . ' <sup>'
                . ($user->can('updateResource') ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['resource/update', 'id' => $resource->res_id, ], array_merge($aLindOpt, ['title' => 'Изменение ' . $resource->res_name])) : '')
                . ' '
                . ($user->can('createTopic') ? Html::a('<span class="glyphicon glyphicon-plus"></span>', ['topic/create', 'resourceid' => $resource->res_id,], array_merge($aLindOpt, ['title' => 'Новая статья'])) : '')
                . '</sup>'
                . '</p>';
        }

    echo $user->can('createTopic') ? ('<p>'
        . Html::a('Создать ресурс', ['resource/create', ])
        . '</p>') : '';
    ?>
</div>
