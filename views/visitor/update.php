<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\Visitor */

$this->title = Yii::t('culture/visitor', 'Update {modelClass}: ', [
    'modelClass' => 'Visitor',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visitor', 'Visitors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('culture/visitor', 'Update');
?>
<div class="visitor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
