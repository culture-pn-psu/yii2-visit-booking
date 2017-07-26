<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\visitBooking\models\VisitBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('culture/visit-booking', 'Visit Bookings');
$this->params['breadcrumbs'][] = $this->title;


$modals['add']=Modal::begin([
    'header' => Html::tag('h4', 'Add Event'),
    'id' => 'modalForm',
    'size' => 'modal-lg'
]);
echo Yii::$app->runAction('/visit-booking/default/create', [
    'formAction' => Url::to(['/visit-booking/default/create']),
    'isAjax'=> true,
]);
Modal::end();

$modals['view'] = Modal::begin([
    'header' => Yii::t('culture/visitor', 'View Visit Booking'),
    'id'=>'modal-booking',
    'size' => Modal::SIZE_LARGE
]);     
echo Html::tag('div', '', ['id' => 'modalContent']);
Modal::end();

$urlCreate = Url::to(['create'],true);
$urlView = Url::to(['view'],true);
$urlResize = Url::to(['resize'],true);

$select = <<< JS
    function(start, end) {	
        //alert("Event: " + start+" "+end);
        start = moment(start).format("YYYY-MM-DD");
         $("#{$modals['add']->id}").find("#visitbooking-visit_date").val(start);
            $("#{$modals['add']->id}").modal("show");
            /*
        $.get( "{$urlCreate}",
             {
                "start":moment(start).format("YYYY-MM-DD"),
                "end":moment(end).format("YYYY-MM-DD"),
            },
            function(data){   
            $("#{$modals['add']->id}").find("#visitbooking-visit_date").val(start);
            $("#{$modals['add']->id}").modal("show");
           // console.log(data);
        });            
        */
    }
JS;
            
$eventClick = <<< JS
function(calEvent, jsEvent, view) {
    console.log("Event View: " + calEvent.title);
    var data={                   
        id:calEvent.id,
    }                
    $.ajax({
        url: "{$urlView}",
        data: data,
        type: "GET",
        success: function(data) {                        
            $("#{$modals['view']->id}").find("#modalContent").html(data);
            $("#{$modals['view']->id}").modal("show");
        }
    });
}
JS;

$eventResize = <<< JS
function(event, delta, revertFunc) {
    start = moment(event.start).format("YYYY-MM-DD");
    //end = moment(event.end).format("YYYY-MM-DD");
    var data={
        start:start,
        //end:end,
        id:event.id,
        allday:event.allday
    }
    
    $.ajax({
        url: "{$urlResize}",
        data: data,
        type: "POST",
        dataType:"json",
        success: function(data) {
            if(data.success){
                $("#calendar").fullCalendar("refetchEvents");
                submitDate();
            }
        }
    });
}
JS;
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
                        //'center' => false,
                        'right' => 'month,basicWeek,basicDay'
                    ],
                   
                    'clientOptions' => [
//                        'views' => [
//                            'year' => [
//                                'type' => 'YearView',
//                            ]
//                        ],
                        //'weekends' => false,
                        'weekMode' => 'fixed',
                        'fixedWeekCount' => false,
                        'selectable' => true,
                        'selectHelper' => true,
                        'draggable' => false,
                        'editable' => true,
                        
                        //'drop' => new JsExpression($eventDrop),
                        'select' => new JsExpression($select),
                        'eventClick' => new JsExpression($eventClick),
                        'eventDrop' => new JsExpression($eventResize),
                        //'eventResize' => new JsExpression($eventResize),
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

            <?= $form->field($searchModel, 'start')->hiddenInput()->label(false) ?>
            <?= $form->field($searchModel, 'end')->hiddenInput()->label(false) ?>
            <?php
            if($searchModel->start && $searchModel->end){
                echo Html::beginTag('h4',['class'=>'text-left']);
                    //echo Yii::$app->formatter->asDate($searchModel->start);
                    echo Yii::t('culture','List');
                    echo ' ';
                    echo Yii::t('culture/visit-booking','Today');
                    echo ' - ';
                    $searchModel->end = date('Y-m-d',strtotime($searchModel->end . "-1 days"));
                    echo Yii::$app->formatter->asDate($searchModel->end);
                echo Html::endTag('h4');
            }
            ?>
            <?php ActiveForm::end(); ?>
            
            <?= $listView = ListView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                //'itemView' => '_list_item',
                'itemView' => function ($model, $key, $index, $widget) use ($modals){
                    return $this->render('_list_item',['model' => $model,'modals'=>$modals]);
                },
                'layout' => "{summary}\n{items}",
            ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
    
</div>
<?php
$start = Html::getInputId($searchModel, 'start');
$end = Html::getInputId($searchModel, 'end');
$js[] = <<< JS
/* initialize the external events
-----------------------------------------------------------------*/
$('#calendar .fc-event').each(function() {
    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true // maintain when user navigates (see docs on the renderEvent method)
    });
        // make the event draggable using jQuery UI
    $(this).draggable({
        zIndex: 999,
        revert: true, // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
    });
});
JS;

$js[] = <<< JS
var date_start = '';
var date_end = '';
    $(function(){
       $('button.fc-prev-button,button.fc-next-button').click(function() {
        submitDate();
        }); 
       submitDate();
    });
    
    function submitDate(){
           date_start = GetCalendarDateRange().start;
           date_end = GetCalendarDateRange().end;
         
           console.log(date_start+' '+date_end);
           console.log(GetCalendarDateRange());
           
           $("#{$start}").val(date_start);
           $("#{$end}").val(date_end);
           $("#{$form->id}").submit();
    }
    
    function GetCalendarDateRange() {
        var calendar = $('#calendar').fullCalendar('getCalendar');
        var view = calendar.view;
        var start = view.start.format("YYYY-MM-DD");
        var end = view.end.format("YYYY-MM-DD");
        var dates = { start: start, end: end };
        return dates;
    }
JS;


$js[] = <<< JS
function callbackEvent(){
    $("#calendar").fullCalendar("refetchEvents");
    submitDate();
    $("#{$modals['add']->id}").modal('hide');
}
JS;


$js[] = <<< JS
var urlView = "{$urlView}";
    $(document).on('ready pjax:success', function() {
        $(".update-dialog").click(function(e) {
            e.preventDefault();
             $('#{$modals['view']->id}').modal('show').find('#modalContent')
             .load($(this).attr('href'));
            return false;
        });
    });
JS;


$this->registerJs(implode("\n", $js));

