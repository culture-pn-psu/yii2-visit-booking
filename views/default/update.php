<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBooking */

$this->title = Yii::t('culture/visit-booking', 'Update {modelClass}: ', [
    'modelClass' => 'Visit Booking',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-booking', 'Visit Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('culture/visit-booking', 'Update');
?>
<div class="visit-booking-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
