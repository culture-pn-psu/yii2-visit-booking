<?php
use yii\helpers\Html;

// print_r($model);
// exit();
$date = array_keys($model);
?>    


<div class="box box-solid ">
    
    <div class="box-header with-border bg-teal-gradient">
        <i class="fa fa-calendar"></i>
        <h3 class="box-title">
            <?=Yii::$app->formatter->asDate($date[0])?>
        </h3>
    </div>
    
    <div class="box-body">
      
        <?php foreach($model as $key => $value):?>
            <?php foreach($value as $k => $visitBooking):?>
                <div class="row">
                    <div class="col-sm-10">
                        <?=Html::beginTag('h4');?>
                            &nbsp;&nbsp;&nbsp;
                            <?=Html::a('<i class="fa fa-user-secret"></i> '.$visitBooking->visitor->title
                        ,['view','id'=>$visitBooking->id]);?>
                        <?=Html::endTag('h4');?>
                    </div>
                </div>
                <?php foreach($visitBooking->visitBookingDetails as $detail): ?>
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-1">
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
                <?php if(isset($value[$k+1])):?>
                <hr style="margin:5px;"/>
                <?php endif;?>
            <?php endforeach;?>
        <?php endforeach;?>
    </div>
    
</div>