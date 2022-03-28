<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WorkerSearch represents the model behind the search form of `app\models\Worker`.
 */
class WorkerSearch extends Worker
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'counterparty_id', 'position_id', 'department_id', 'division_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['document', 'document_number', 'document_date', 'start_work', 'end_work'], 'safe'],
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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'document', $this->document])
            ->andFilterWhere(['like', 'document_number', $this->document_number]);

        return $dataProvider;
    }
}
