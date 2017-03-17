<?php

namespace culturePnPsu\visitBooking\models;

/**
 * This is the ActiveQuery class for [[VisitBooking]].
 *
 * @see VisitBooking
 */
class VisitBookingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VisitBooking[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VisitBooking|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    

}
