<?php

namespace culturePnPsu\visitBooking\models;

use Yii;

/**
 * This is the model class for table "visit_booking_detail".
 *
 * @property int $visit_booking_id
 * @property int $learning_center_id
 * @property string $booking_time
 * @property int $learning_center_range_id
 */
class VisitBookingDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit_booking_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_booking_id', 'learning_center_id', 'booking_time'], 'required'],
            [['visit_booking_id', 'learning_center_id', 'learning_center_range_id'], 'integer'],
            [['booking_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'visit_booking_id' => Yii::t('culture/visit-booking', 'Visit Booking ID'),
            'learning_center_id' => Yii::t('culture/visit-booking', 'Learning Center ID'),
            'booking_time' => Yii::t('culture/visit-booking', 'Booking Time'),
            'learning_center_range_id' => Yii::t('culture/visit-booking', 'Learning Center Range ID'),
        ];
    }
}
