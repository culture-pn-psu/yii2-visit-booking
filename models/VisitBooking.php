<?php

namespace culturePnPsu\visitBooking\models;

use Yii;

/**
 * This is the model class for table "visit_booking".
 *
 * @property int $id
 * @property int $visitor_id
 * @property string $visit_date
 * @property int $visit_number
 * @property int $status
 * @property int $receiver_by
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 */
class VisitBooking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit_booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visitor_id', 'visit_date', 'visit_number', 'receiver_by'], 'required'],
            [['visitor_id', 'visit_number', 'status', 'receiver_by', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['visit_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('culture/visit-booking', 'ID'),
            'visitor_id' => Yii::t('culture/visit-booking', 'Visitor ID'),
            'visitor_title' => Yii::t('culture/visit-booking', 'Visitor Title'),
            'visit_date' => Yii::t('culture/visit-booking', 'Visit Date'),
            'visit_number' => Yii::t('culture/visit-booking', 'Visit Number'),
            'status' => Yii::t('culture/visit-booking', 'Status'),
            'receiver_by' => Yii::t('culture/visit-booking', 'Receiver By'),
            'created_by' => Yii::t('culture', 'Created By'),
            'created_at' => Yii::t('culture', 'Created At'),
            'updated_by' => Yii::t('culture', 'Updated By'),
            'updated_at' => Yii::t('culture', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return VisitBookingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VisitBookingQuery(get_called_class());
    }
    
    public $visitor_title;
    
    public function getVisitor()
   {
       return $this->hasOne(Visitor::className(), ['id' => 'visitor_id']);
   }
}
