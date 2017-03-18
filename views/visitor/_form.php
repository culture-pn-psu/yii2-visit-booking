<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use culturePnPsu\visitBooking\models\Visitor;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\Visitor */
/* @var $form yii\widgets\ActiveForm */

  $formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
 
?>

<div class="visitor-form">

     <?php $form = ActiveForm::begin([
            'action' => $formAction,
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-6',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(Visitor::getTypeList(),['prompt'=>Yii::t('culture','Select')]) ?>

    <div class="form-group ">
        <div class="col-sm-offset-3">
            <?= Html::submitButton(Yii::t('culture', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
///Surakit
if($formAction !== null) {
$js[] = <<< JS
$(document).on('submit', '#{$form->id}', function(e){
  e.preventDefault();
  var form = $(this);
  var formData = new FormData(form[0]);
  // alert(form.serialize());
  
  $.ajax({
    url: form.attr('action'),
    type : 'POST',
    data: formData,
    contentType:false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data) {
        console.log(data);
      if(data.success){
        callbackEdoc(data.result);
      }else{
        alert('Fail');
      }
    }
  });
});
JS;
$this->registerJs(implode("\n", $js));
}
?>