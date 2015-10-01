<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%topic}}".
 *
 * @property integer $tpc_id
 * @property integer $tpc_resource
 * @property integer $tpc_level
 * @property integer $tpc_lft
 * @property integer $tpc_rgt
 * @property string $tpc_title
 * @property string $tpc_text
 * @property integer $tpc_active
 * @property string $tpc_created
 * @property string $tpc_updated
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%topic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tpc_resource', 'tpc_lft', 'tpc_rgt', 'tpc_title', 'tpc_text', 'tpc_created', 'tpc_updated'], 'required'],
            [['tpc_resource', 'tpc_level', 'tpc_lft', 'tpc_rgt', 'tpc_active'], 'integer'],
            [['tpc_text'], 'string'],
            [['tpc_created', 'tpc_updated'], 'safe'],
            [['tpc_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tpc_id' => 'Tpc ID',
            'tpc_resource' => 'Ресурс',
            'tpc_level' => 'Уровень',
            'tpc_lft' => 'Tpc Lft',
            'tpc_rgt' => 'Tpc Rgt',
            'tpc_title' => 'Название',
            'tpc_text' => 'Текст',
            'tpc_active' => 'Активен',
            'tpc_created' => 'Создан',
            'tpc_updated' => 'Изменен',
        ];
    }
}
