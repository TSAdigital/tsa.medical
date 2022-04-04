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
    public $snils;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'counterparty_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['counterparty_name', 'snils', 'phone', 'extension_phone', 'email'], 'safe'],
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
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        $query->joinWith(['counterparty']);

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
                'snils' => [
                    'asc' => ['counterparty_fl.snils' => SORT_ASC],
                    'desc' => ['counterparty_fl.snils' => SORT_DESC],
                    'label' => 'snils',
                    'default' => SORT_ASC
                ],
                'status',
            ]
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'counterparty_id' => $this->counterparty_id,
            'phone' => $this->phone,
            'extension_phone' => $this->extension_phone,
            'email' => $this->email,
            'worker.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', "CONCAT(counterparty_fl.last_name,' ',counterparty_fl.first_name,' ',counterparty_fl.middle_name)", $this->counterparty_name])
            ->andFilterWhere(['like', 'counterparty_fl.snils', preg_replace('/[^0-9]/ui', '', $this->snils)]);

        return $dataProvider;
    }
}
