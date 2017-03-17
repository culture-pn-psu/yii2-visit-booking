<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use culturePnPsu\visitBooking\models\Visitor

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\Visitor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visitor-form">

     <?php $form = ActiveForm::begin([
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
