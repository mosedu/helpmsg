<?php

namespace app\models;

use Yii;

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
            [['res_name', 'res_created'], 'required'],
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
