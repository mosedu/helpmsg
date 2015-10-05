<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 05.10.2015
 * Time: 16:36
 */

namespace app\themes\semantic;

use yii\web\AssetBundle;

class SemanticAsset extends AssetBundle {
    public $basePath = '@app/themes/semantic';
    public $sourcePath = '@app/themes/semantic/dist';
    public $css = [
        'semantic.css',
//        'semantic.min.css',
    ];
    public $js = [
        'semantic.js'
        // 'semantic.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}