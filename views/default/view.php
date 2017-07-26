<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitBooking\models\VisitBooking */

$this->title = $model->visitor->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-booking', 'Visit Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-booking-view">

    <?= $this->render('viewDetail',['model'=>$model]); ?>
    
    <p>
        <?= Html::a(Yii::t('culture/visit-booking', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('culture', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
