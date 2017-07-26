<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBooking */
?>


<div class="row">
    <div class="col-sm-10">
        <h2><i class="fa fa-user-secret"></i> <?= Html::encode($model->visitor->title) ?></h2>
        <h4>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i> เข้ามาในวันเวลา <?= Yii::$app->formatter->asDateTime($model->visit_date,'php:d M Y H:i') ?>
        </h4>
        <h4>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user-o"></i>  <?= Yii::t('culture/visit-booking','Count').' '.$model->visit_number.' '.Yii::t('culture/visit-booking','Human')?>
        </h4>
        <hr/>
    </div>
</div>

<div class="row">
    <div class="col-sm-10 ">
        <div class="row">
            <div class="col-sm-2">
                <?=Html::beginTag('b');?>
                เวลา
                <?=Html::endTag('b');?>
            </div>
            <div class="col-sm-4">
                เข้าชม
            </div>
        </div>
        <?php foreach($model->visitBookingDetails as $detail):?>
           <div class="row">
                    <div class="col-sm-2">
                        <?=Html::beginTag('b');?>
                        <i class="fa fa-clock-o"></i> 
                        <?=Yii::$app->formatter->asTime($detail->booking_time,"php:H:i");?>
                        <?=Html::endTag('b');?>
                    </div>
                    <div class="col-sm-4">
                        <?=$detail->learningCenter->title?>
                    </div>
                </div>
        <?php endforeach;?>
        <hr/>
    </div>
</div>
<?php /*= DetailView::widget([
    'model' => $model,
    'attributes' => [
        //'id',
        //'visitor_id',
        'visit_date:datetime',
        [
            ],
        'visit_number',
        'status',
        'receiver_by',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ],
]) */?>
    