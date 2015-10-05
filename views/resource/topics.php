<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 02.10.2015
 * Time: 11:35
 */

use app\models\Topic;
use app\models\Resource;

/* @var $this yii\web\View */
/* @var $model app\models\Resource */

if( $model === null ) {
    echo $this->render('list', ['list' => Resource::find()->where(['>', 'res_active', 0])->orderBy('res_name')->all()]);
}
else {
    echo $this->render(
        'topictree',
        [
            'resource' => $model,
            'list' => Topic::find()->where(['tpc_resource' => $model->res_id])->orderBy('tpc_lft')->all(),
            'topicid' => $topicid,
        ]
    );
}

