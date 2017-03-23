<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBookingDetail */

$this->title = $model->visit_booking_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-booking', 'Visit Booking Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-booking-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('culture/visit-booking', 'Update'), ['update', 'visit_booking_id' => $model->visit_booking_id, 'learning_center_id' => $model->learning_center_id, 'booking_time' => $model->booking_time], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('culture/visit-booking', 'Delete'), ['delete', 'visit_booking_id' => $model->visit_booking_id, 'learning_center_id' => $model->learning_center_id, 'booking_time' => $model->booking_time], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('culture/visit-booking', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'visit_booking_id',
            'learning_center_id',
            'booking_time',
            'learning_center_range_id',
        ],
    ]) ?>

</div>
