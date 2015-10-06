<?php

namespace app\models;

use Yii;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

use app\models\Resource;

/**
 * This is the model class for table "{{%topic}}".
 *
 * @property integer $tpc_id
 * @property integer $tpc_resource
 * @property integer $tpc_parent_id
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
    const UPLOAD_PATH = 'ufiles';
    const UPLOAD_IMG_PATH = 'img';
    const UPLOAD_FILE_PATH = 'file';

    public function behaviors() {
        return [
            // дата создания ресурса
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'tpc_created',
                'updatedAtAttribute' => 'tpc_updated',
                'value' => new Expression('NOW()'),
            ],

        ];
    }

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
            [['tpc_resource', 'tpc_title', 'tpc_text', ], 'required'],
            [['tpc_resource', 'tpc_level', 'tpc_lft', 'tpc_rgt', 'tpc_active', 'tpc_parent_id', ], 'integer'],
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
            'tpc_parent_id' => 'Родитель',
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

    public function appendTo($resourceId, $parentId = 0) {
        $oResource = Resource::findOne($resourceId);

        if( $oResource === null ) {
            throw new Exception('Ошибка ресурса');
        }

        $this->tpc_resource = $resourceId;
        $nRight = 1;

        if( $parentId != 0 ) {
            $oParent = self::findOne($parentId);
            if( $oParent === null ) {
                throw new Exception('Не найден родительский элемент');
            }
            if( $oParent->tpc_resource != $resourceId ) {
                throw new Exception('Ошибка ресурса у элемента');
            }

            $nRight = $oParent->tpc_rgt;
            $this->tpc_level = $oParent->tpc_level + 1;
            $this->tpc_parent_id = $oParent->tpc_id;
            Yii::info('appendTo('.$resourceId.', '.$parentId.') parent: level = ' . $this->tpc_level . ' right = ' . $oParent->tpc_rgt);
        }
        else {
            $nRight = Yii::$app->db->createCommand('Select MAX(tpc_rgt) From ' . Topic::tableName() . ' Where tpc_resource = :res', [':res' => $resourceId])->queryScalar();
            Yii::info('appendTo('.$resourceId.', '.$parentId.') new: level = ' . $this->tpc_level . ' right = ' . $nRight . ' ' . var_export($nRight));
            if( $nRight === null ) {
                $nRight = 1;
            }
            else {
                $nRight += 1;
            }
            $this->tpc_level = 0;
        }

        $transaction = Yii::$app->db->beginTransaction();
        $this->tpc_lft = $nRight;
        $this->tpc_rgt = $nRight + 1;

        Yii::info('appendTo('.$resourceId.', '.$parentId.') this = ' . print_r($this->attributes, true));

        $this->updateAll(
            [
                'tpc_rgt' => new Expression('tpc_rgt + 2'),
                'tpc_lft' => new Expression('IF(tpc_lft > :rgt, tpc_lft + 2, tpc_lft)'),
            ],
            'tpc_rgt >= :rgt And tpc_resource = :res',
            [
                ':rgt' => $nRight,
                ':res' => $resourceId,
            ]
        );

        $bRet = false;
        if( $this->save() ) {
            $transaction->commit();
            $bRet = true;
        }
        else {
            Yii::info('actionUpdate() error rollBack: ' . print_r($this->getErrors(), true));
            $transaction->rollBack();
        }

        return $bRet;
    }
}
