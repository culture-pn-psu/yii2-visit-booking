<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBookingDetail */

$this->title = Yii::t('culture/visit-booking', 'Update {modelClass}: ', [
    'modelClass' => 'Visit Booking Detail',
]) . $model->visit_booking_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-booking', 'Visit Booking Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->visit_booking_id, 'url' => ['view', 'visit_booking_id' => $model->visit_booking_id, 'learning_center_id' => $model->learning_center_id, 'booking_time' => $model->booking_time]];
$this->params['breadcrumbs'][] = Yii::t('culture/visit-booking', 'Update');
?>
<div class="visit-booking-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
