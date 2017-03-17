<?php


use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Typeahead;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use culturePnPsu\visitBooking\models\Visitor;
use culturePnPsu\learningCenter\models\LearningCenter;
use culturePnPsu\person\models\Person;


//print_r(Visitor::getDistinctTitle());
$distinctTitle = Visitor::getDistinctTitle();
/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBooking */
/* @var $form yii\widgets\ActiveForm */


$template['template'] = "{label}\n{hint}\n{beginWrapper}\n{input}\n{endWrapper}\n{error}";
$template['horizontalCssClasses'] = [
                    'label' => false,
                    'offset' => false,
                    'wrapper' => 'col-sm-12',
                    'error' => false,
                    'hint' => false,
                ];
$templateRange['horizontalCssClasses'] = [
    'label' => false,
    'offset' => false,
    'wrapper' => 'col-sm-3',
    'error' => '',
    'hint' => '',
];
$model->receiver_by=empty($model->receiver_by)?Yii::$app->user->id:$model->receiver_by;
?>

<div class="visit-booking-form">

    <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}\n{error}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-6',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]); ?>
    <?= Html::errorSummary($model,['class'=>'alert alert-error alert-dismissible']);?>   
    

    <?php #= $form->field($model, 'visitor_id')->textInput()?>
        
    <?= $form->field($modelVisitor, 'title')->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'Filter as you type ...'],
        'pluginOptions' => ['highlight'=>true],
        'defaultSuggestions' => $distinctTitle,
        'dataset' => [
            [
                'local' => $distinctTitle,
                'limit' => 10
            ]
        ]
    ]); ?>

    
    
    <?php
     $templateModel['horizontalCssClasses'] = [
        'label' => 'col-sm-3',
        'offset' => 'col-sm-offset-4',
        'wrapper' => 'col-sm-4',
        'error' => '',
        'hint' => '',
    ];
    echo $form->field($model, 'visit_date',$templateModel)->widget(DateTimePicker::className(),[
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii',
            'todayHighlight' => true,
            'todayBtn' => true,
        ]
    ]);
    
    $templateModel['horizontalCssClasses'] = [
        'label' => 'col-sm-3',
        'offset' => 'col-sm-offset-4',
        'wrapper' => 'col-sm-2',
        'error' => '',
        'hint' => '',
    ];
    echo $form->field($model, 'visit_number',$templateModel)->textInput(['type'=>'number','step'=>10]); ?>
    
    
    <?= $form->field($model, 'receiver_by')->dropDownList(Person::getList(),['prompt'=>Yii::t('culture','Select')]) ?>
    
    
    <?php #= $form->field($modelBookingDetail, 'learning_center_id')->checkBoxList(LearningCenter::getList()) ?>
    
    
     <div class="form-group field-visitbookingdetail-learning_center_id required">
       <?php /* <div class="col-sm-3 text-right">
            <?=$form->field($modelBookingDetail, 'learning_center_id',$template)->hiddenInput()->error(false)?>
            <?php #=Html::label($modelBookingDetail->getAttributeLabel('learning_center_id'),'',['class'=>'field-visitbookingdetail-learning_center_id required has-error'])?>
        </div>*/?>
        <?=Html::activeLabel($modelBookingDetail,'learning_center_id',['class'=>'control-label col-sm-3'])?>
     
        <div class="col-sm-6">
            <?php
            echo Html::errorSummary($modelBookingDetail,['class'=>'alert alert-error alert-dismissible']);
            
            foreach(LearningCenter::find()->all() as $learning):
                ?>
                <div class='box box-warning box-solid'>
                    <div class='box-header with-border'>
                   <?php 
                   echo Html::beginTag('h4',['class'=>'box-title']);
                       echo Html::beginTag('label');
                           echo  Html::activeCheckBox($modelBookingDetail, "learning_center_id[{$learning->id}]",['label'=>false,'value'=>$learning->id,'id'=>'learning_center_id-'.$learning->id]);
                           echo '&nbsp;'.$learning->title;
                       echo Html::endTag('label');
                   echo Html::endTag('h4');     
                    //   echo  $form->field($modelBookingDetail, 'learning_center_id[]',$template)
                    //   ->checkBox(['value'=>$learning->id,'id'=>'learning_center_id-'.$learning->id])
                    //   ->error(false)
                    //   ->hint(false)
                    //   ->label($learning->title);
                   ?>
                   </div>
                   <div class='box-body'>
                       <div class='row'>
                            <?php foreach($learning->learningCenterRange as $range):?>
                                 <?php 
                                 echo Html::beginTag('label',['class'=>'col-sm-3']);
                                 echo Html::activeCheckBox($modelBookingDetail,"learning_center_id[{$learning->id}][booking_time][{$range->time}]",['label'=>false]);
                                 echo ' &nbsp;'.Html::tag('b',$range->title.' <br/>'
                                        .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                        .Yii::$app->formatter->asTime($range->time,'php:H:i')).' น.';
                                 echo Html::endTag('label');
                                //  echo  $form->field($modelBookingDetail, 'learning_center_range_id[]',$templateRange)
                                //  ->inline()
                                //   ->checkBox(['value'=>$range->time])
                                //   ->label($range->title);
                               ?>
                            <?php endforeach;?>
                       
                   </div>
               </div>
               </div>
            <?php
            endforeach;
            ?>
        </div>
        </div>
    </div>
 

    <div class="form-group ">
        <div class="col-sm-offset-3">
            <?= Html::submitButton(Yii::t('culture', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>