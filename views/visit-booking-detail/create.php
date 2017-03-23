<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBookingDetail */

$this->title = Yii::t('culture/visit-booking', 'Create Visit Booking Detail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-booking', 'Visit Booking Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-booking-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
