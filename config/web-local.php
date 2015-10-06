<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 01.10.2015
 * Time: 11:51
 */

$config = [
    'components' => [
/*        'view' => [
            'theme' => [
                'basePath' => '@app/themes/semantic',
//                'baseUrl' => '@web/themes/semantic',
                'pathMap' => [
                    '@app/views' => '@app/themes/semantic',
                ],
            ],
        ],
*/
        /*
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'css' => ['css/custom-bootstrap.css'],
                ],
            ],
        ],
        */
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', ], // 'trace'
                    'logFile' => '@app/runtime/logs/web.log',
                    'maxFileSize' => 250,
                    'maxLogFiles' => 2,
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;