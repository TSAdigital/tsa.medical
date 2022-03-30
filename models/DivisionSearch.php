<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DivisionSearch represents the model behind the search form of `app\models\Division`.
 */
class DivisionSearch extends Division
{
    public $department_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'department', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'department_name'], 'safe'],
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
        $query = Division::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        $query->joinWith(['department0']);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->setSort([
            'attributes' => [
                'department_name' => [
                    'asc' => ['department.name' => SORT_ASC],
                    'desc' => ['department.name' => SORT_DESC],
                    'label' => 'department.name',
                    'default' => SORT_ASC
                ],
                'name',
                'status',
            ]
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'department' => $this->department,
            'division.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'division.name', $this->name])->andFilterWhere(['like', 'department.name', $this->department_name]);

        return $dataProvider;
    }
}
