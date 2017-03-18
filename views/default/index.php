<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\visitBooking\models\VisitBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('culture/visit-booking', 'Visit Bookings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-booking-index">

     <p>
        <?= Html::a(Yii::t('culture/visit-booking', 'Create Visit Booking'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
<div class='row'>
<div class='col-sm-6'>
     <?php //$pjaxCal = Pjax::begin(); ?>
    <?=
        \yii2fullcalendar\yii2fullcalendar::widget(
                [
                    //'events' => $events,                    
                    'ajaxEvents' => Url::toRoute(['/visit-booking/default/jsoncalendar']),
                    'options' => ['id' => 'calendar', 'lang' => 'th'],
                    'header' => [
                        'left' => 'prev,next today',
                        'center' => 'title',
                        'right' => 'month,basicWeek,basicDay'
                    ],
                    'clientOptions' => [
//                        'views' => [
//                            'year' => [
//                                'type' => 'YearView',
//                            ]
//                        ],
                        'selectable' => true,
                        'selectHelper' => true,
                        'draggable' => true,
                        'editable' => true,
                        
                        //'drop' => new JsExpression($eventDrop),
                        // 'select' => new JsExpression($select),
                        // 'eventClick' => new JsExpression($eventClick),
                        // 'eventDrop' => new JsExpression($eventResize),
                        // 'eventResize' => new JsExpression($eventResize),
                    ],
                ]
        );
        ?>
        <?php //Pjax::end(); ?>
        </div>
        <div class="col-sm-6">
            <?php $pjaxGrid =Pjax::begin(['enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); 
            
            $form = ActiveForm::begin([
                'action' => ['index'],
                //'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
            ]); ?>

            <?= $form->field($searchModel, 'start') ?>
            <?= $form->field($searchModel, 'end') ?>
    
            <?php ActiveForm::end(); ?>
            
            
            
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'visit_date:date',
                    [
                        'attribute' => 'visitor_id',
                        'value'=>'visitor.title'
                    ],
                    'visit_number',
                    //'status',
                    // 'receiver_by',
                    // 'created_by',
                    // 'created_at',
                    // 'updated_by',
                    // 'updated_at',
        
                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
    
</div>
<?php
$start = Html::getInputId($searchModel, 'start');
$end = Html::getInputId($searchModel, 'end');
$js[] = <<< JS
var date_start = '';
var date_end = '';
    $(function(){
       $('button.fc-prev-button,button.fc-next-button').click(function() {
        //   date_start = $('.fc-row:first-child .fc-content-skeleton .fc-day-top').not('.fc-other-month').attr('data-date');
        //   date_end = $('.fc-row:last-child .fc-content-skeleton .fc-day-top').not('.fc-other-month').select(':last-child').attr('data-date');
           
           date_start = GetCalendarDateRange().start;
           date_end = GetCalendarDateRange().end;
           
           
           console.log(date_start+' '+date_end);
           console.log(GetCalendarDateRange());
           
           
           
           //console.log($('#calender').fullCalendar("getDate"));
           //alert(date_start+' '+date_end);
           //console.log($.fullCalendar);
           //alert($.fullcalendar.elemData);
           //$.pjax.reload({container:"#{$pjaxGrid->id}"});
           $("#{$start}").val(date_start);
           $("#{$end}").val(date_end);
           $("#{$form->id}").submit();
        }); 
        
        // $("#{$pjaxCal->id}").on("pjax:end", function() {
        //     $.pjax.reload({container:"#{$pjaxGrid->id}"});  //Reload GridView
        // });
    });
    
    function GetCalendarDateRange() {
        var calendar = $('#calendar').fullCalendar('getCalendar');
        var view = calendar.view;
        var start = view.start.format("YYYY-MM-DD");
        var end = view.end.format("YYYY-MM-DD");
        var dates = { start: start, end: end };
        return dates;
    }
JS;
$this->registerJs(implode("\n", $js));