<?php

namespace crudle\app\admin\models\search;

use crudle\app\admin\models\DbTable;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DbTableSearch represents the model behind the search form of `app\modules\setup\models\DbTable`.
 */
class DbTableSearch extends DbTable
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TABLE_SCHEMA', 'TABLE_NAME', 'TABLE_COLLATION'], 'string'],
            [['TABLE_COMMENT', 'ENGINE'], 'safe'],
            [['TABLE_ROWS', 'AUTO_INCREMENT'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = DbTable::find();

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
            'ENGINE' => $this->ENGINE,
            'TABLE_COLLATION' => $this->TABLE_COLLATION,
        ]);

        $query->andFilterWhere(['like', 'TABLE_SCHEMA', $this->TABLE_SCHEMA])
            ->andFilterWhere(['like', 'TABLE_NAME', $this->TABLE_NAME])
            ->andFilterWhere(['like', 'TABLE_ROWS', $this->TABLE_ROWS])
            ->andFilterWhere(['like', 'AUTO_INCREMENT', $this->AUTO_INCREMENT])
            ->andFilterWhere(['like', 'TABLE_COMMENT', $this->TABLE_COMMENT]);

        return $dataProvider;
    }
}
