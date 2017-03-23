<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBookingDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-booking-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'visit_booking_id') ?>

    <?= $form->field($model, 'learning_center_id') ?>

    <?= $form->field($model, 'booking_time') ?>

    <?= $form->field($model, 'learning_center_range_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('culture/visit-booking', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('culture/visit-booking', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
