<?php

namespace crudle\app\admin\models\search;

use crudle\app\admin\models\Database;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DatabaseSearch represents the model behind the search form of `app\modules\setup\models\Database`.
 */
class DatabaseSearch extends Database
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SCHEMA_NAME', 'DEFAULT_COLLATION_NAME'], 'string'],
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
        $query = DatabaseSearch::find();

        // add conditions that should always apply here
        // $query->joinWith('dbTable');

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
            'DEFAULT_COLLATION_NAME' => $this->DEFAULT_COLLATION_NAME,
        ]);

        $query->andFilterWhere(['like', 'SCHEMA_NAME', $this->SCHEMA_NAME]);

        return $dataProvider;
    }
}
