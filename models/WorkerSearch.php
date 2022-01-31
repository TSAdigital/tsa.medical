<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WorkerSearch represents the model behind the search form of `app\models\Worker`.
 */
class WorkerSearch extends Worker
{
    public $department_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'department', 'gender', 'snils', 'inn', 'status', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'firs_name', 'middle_name', 'department_name', 'birthdate'], 'safe'],
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
        $query = Worker::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
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
                'last_name',
                'firs_name',
                'middle_name',
                'status',
            ]
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'department' => $this->department,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'snils' => $this->snils,
            'inn' => $this->inn,
            'worker.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'firs_name', $this->firs_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'department.name', $this->department_name]);

        return $dataProvider;
    }
}
