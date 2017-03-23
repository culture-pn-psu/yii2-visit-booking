<?php

namespace culturePnPsu\visitBooking\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use culturePnPsu\visitBooking\models\VisitBookingDetail;

/**
 * VisitBookingDetailSearch represents the model behind the search form of `culturePnPsu\visitBooking\models\VisitBookingDetail`.
 */
class VisitBookingDetailSearch extends VisitBookingDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_booking_id', 'learning_center_id', 'learning_center_range_id'], 'integer'],
            [['booking_time','start','end'], 'safe'],
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
        $query = VisitBookingDetail::find();
        $query->joinWith('visitBooking');

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
            'visit_booking_id' => $this->visit_booking_id,
            'learning_center_id' => $this->learning_center_id,
            'booking_time' => $this->booking_time,
            'learning_center_range_id' => $this->learning_center_range_id,
        ]);
        
        $query->andFilterWhere(['>=','date(visit_booking.visit_date)',$this->start]);
        $query->andFilterWhere(['<=','date(visit_booking.visit_date)',$this->end]);

        return $dataProvider;
    }
}
