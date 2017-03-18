<?php

namespace culturePnPsu\visitBooking\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use culturePnPsu\visitBooking\models\VisitBooking;

/**
 * VisitBookingSearch represents the model behind the search form of `culturePnPsu\visitBooking\models\VisitBooking`.
 */
class VisitBookingSearch extends VisitBooking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'visitor_id', 'visit_number', 'status', 'receiver_by', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['visit_date','start','end'], 'safe'],
        ];
    }
    public $start;
    public $end;

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
        $query = VisitBooking::find();

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
            'visitor_id' => $this->visitor_id,
            'visit_date' => $this->visit_date,
            'visit_number' => $this->visit_number,
            'status' => $this->status,
            'receiver_by' => $this->receiver_by,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['>=','date(visit_date)',$this->start]);
        $query->andFilterWhere(['<=','date(visit_date)',$this->end]);

        return $dataProvider;
    }
}
