<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBooking */

$this->title = Yii::t('culture/visit-booking', 'Create Visit Booking');
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-booking', 'Visit Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-booking-create">


    <?= $this->render('_form', [
        'model' => $model,
        'modelBookingDetail' => $modelBookingDetail,
        'modelVisitor' => $modelVisitor,
    ]) ?>

</div>
