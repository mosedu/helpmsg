<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%resource}}".
 *
 * @property integer $res_id
 * @property string $res_name
 * @property integer $res_active
 * @property string $res_created
 */
class Resource extends \yii\db\ActiveRecord
{
    public function behaviors() {
        return [
            // дата создания ресурса
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'res_created',
                ],
                'value' => function ($event) {
                    /** @var Resource $model */
                    $model = $event->sender;
                    if( $model->isNewRecord ) {
                        return new Expression('NOW()');
                    }
                    return $model->res_created;
                },
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resource}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_name', ], 'required'],
            [['res_active'], 'integer'],
            [['res_created'], 'safe'],
            [['res_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'res_id' => 'Res ID',
            'res_name' => 'Название',
            'res_active' => 'Активен',
            'res_created' => 'Создан',
        ];
    }
}
