<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WorkerSearch represents the model behind the search form of `app\models\Worker`.
 */
class WorkerSearch extends Worker
{
    public $counterparty_name;
    public $department_name;
    public $position_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'counterparty_id', 'position_id', 'department_id', 'division_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['counterparty_name', 'department_name', 'position_name', 'document', 'document_number', 'document_date', 'start_work', 'end_work'], 'safe'],
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
        ]);

        $this->load($params);

        $query->joinWith(['counterparty', 'department', 'position']);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->setSort([
            'attributes' => [
                'counterparty_name' => [
                    'asc' => ['counterparty_fl.last_name' => SORT_ASC],
                    'desc' => ['counterparty_fl.last_name' => SORT_DESC],
                    'label' => 'counterparty_name',
                    'default' => SORT_ASC
                ],
                'position_name' => [
                    'asc' => ['position.name' => SORT_ASC],
                    'desc' => ['position.name' => SORT_DESC],
                    'label' => 'position_name',
                    'default' => SORT_ASC
                ],
                'department_name' => [
                    'asc' => ['department.name' => SORT_ASC],
                    'desc' => ['department.name' => SORT_DESC],
                    'label' => 'department_name',
                    'default' => SORT_ASC
                ],
            ]
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'counterparty_id' => $this->counterparty_id,
            'position_id' => $this->position_id,
            'department_id' => $this->department_id,
            'division_id' => $this->division_id,
            'document_date' => $this->document_date,
            'start_work' => $this->start_work,
            'end_work' => $this->end_work,
            'worker.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'document', $this->document])
            ->andFilterWhere(['OR',
                ['like', 'counterparty_fl.last_name', $this->counterparty_name],
                ['like', 'counterparty_fl.first_name', $this->counterparty_name],
                ['like', 'counterparty_fl.middle_name', $this->counterparty_name],
            ])
            ->andFilterWhere(['like', 'position.name', $this->position_name])
            ->andFilterWhere(['like', 'department.name', $this->department_name]);

        return $dataProvider;
    }
}
