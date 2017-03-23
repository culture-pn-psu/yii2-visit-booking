<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
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

            <?= $form->field($searchModel, 'start')->hiddenInput()->label(false) ?>
            <?= $form->field($searchModel, 'end')->hiddenInput()->label(false) ?>
            <?php
            
            if($searchModel->start && $searchModel->end){
                echo Html::beginTag('h4',['class'=>'text-center']);
                    echo Yii::$app->formatter->asDate($searchModel->start);
                    echo ' - ';
                    $searchModel->end = date('Y-m-d',strtotime($searchModel->end . "-1 days"));
                    echo Yii::$app->formatter->asDate($searchModel->end);
                echo Html::endTag('h4');
            }
            ?>
            <?php ActiveForm::end(); ?>
            
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'itemView' => '_list_item',
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
$this->registerJs(implode("\n", $js));