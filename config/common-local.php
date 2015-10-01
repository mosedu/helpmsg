<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 01.10.2015
 * Time: 11:49
 */

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=helpmsgtdd',
            'username' => 'helpmsgtdduser',
            'password' => 'helpmsgtddpass',
            'charset' => 'utf8',
            'tablePrefix' => 'hlpmsg_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'attributes' => [
                PDO::ATTR_PERSISTENT => TRUE,
            ],
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
