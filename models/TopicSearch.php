<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Topic;

/**
 * TopicSearch represents the model behind the search form about `app\models\Topic`.
 */
class TopicSearch extends Topic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tpc_id', 'tpc_resource', 'tpc_level', 'tpc_lft', 'tpc_rgt', 'tpc_active'], 'integer'],
            [['tpc_title', 'tpc_text', 'tpc_created', 'tpc_updated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Topic::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tpc_id' => $this->tpc_id,
            'tpc_resource' => $this->tpc_resource,
            'tpc_level' => $this->tpc_level,
            'tpc_lft' => $this->tpc_lft,
            'tpc_rgt' => $this->tpc_rgt,
            'tpc_active' => $this->tpc_active,
            'tpc_created' => $this->tpc_created,
            'tpc_updated' => $this->tpc_updated,
        ]);

        $query->andFilterWhere(['like', 'tpc_title', $this->tpc_title])
            ->andFilterWhere(['like', 'tpc_text', $this->tpc_text]);

        return $dataProvider;
    }
}
