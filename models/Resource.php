<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\models\Topic;
use yii\helpers\ArrayHelper;

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
    public $topicCount;
    private static $_list = [];

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

    public function getTopics() {
        return $this
            ->hasMany(
                Topic::className(),
                ['tpc_resource' => 'res_id']
            )
            ->orderBy('tpc_lft');
    }

    /**
     * @param array $param
     * @return array of Resource
     */
    public static function getList($param = []) {
        $key = md5(print_r($param, true));
        if( !isset(self::$_list[$key]) ) {
            if( is_array($param) ) {
                self::$_list[$key] = self::find()
                    ->where(isset($param['where']) ? $param['where'] : [])
                    ->orderBy(isset($param['order']) ? $param['order'] : [])
                    ->all();
            }
            else if( $param instanceof ActiveQuery ) {
                self::$_list[$key] = $param->all();
            }
            else {
                Yii::warning('Resource::getList() unknown type $param: ' . print_r($param, true));
                self::$_list[$key] = [];
            }
        }
        return self::$_list[$key];
    }

    public static function getAllResource($onlyActive = true) {
        $aFields = array_keys((new Resource())->attributeLabels());
        $stable = Resource::tableName();
        $slave = Topic::tableName();
        $sFields = array_reduce($aFields, function($val, $item) use ($stable) { return $val . ($val == '' ? '' : ', ') . $stable . '.' .  $item; }, '');
        $sFields .= ', COUNT(' . $slave . '.tpc_id) As topicCount';

        $query = self::find()
            ->select($sFields)
            ->where($onlyActive ? [$stable . '.res_active' => 1] : [])
            ->leftJoin($slave, $slave . '.tpc_resource = ' . $stable . '.res_id')
            ->orderBy($stable . '.res_name')
            ->groupBy($stable . '.res_id');
        return ArrayHelper::map(self::getList($query), 'res_id', function($ob){ return array_merge($ob->attributes, ['topicCount' => $ob->topicCount]); });
    }

}
