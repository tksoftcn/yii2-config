<?php

namespace tksoft\config\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use tksoft\config\models\ConfigTable;

/**
 * ConfigSearch represents the model behind the search form about `tksoft\config\models\ConfigTable`.
 */
class ConfigSearch extends ConfigTable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catid', 'isrequired', 'min', 'max', 'displayorder', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'key', 'value', 'type', 'data', 'rule'], 'safe'],
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
        $query = ConfigTable::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catid' => $this->catid,
            'isrequired' => $this->isrequired,
            'min' => $this->min,
            'max' => $this->max,
            'displayorder' => $this->displayorder,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'rule', $this->rule]);

        return $dataProvider;
    }
}
