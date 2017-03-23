<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBookingDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-booking-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'visit_booking_id')->textInput() ?>

    <?= $form->field($model, 'learning_center_id')->textInput() ?>

    <?= $form->field($model, 'booking_time')->textInput() ?>

    <?= $form->field($model, 'learning_center_range_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('culture/visit-booking', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
