<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\visitBooking\models\VisitBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('culture/visit-booking', 'Visit Bookings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-booking-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('culture/visit-booking', 'Create Visit Booking'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'visitor_id',
            'visit_date',
            'visit_number',
            'status',
            // 'receiver_by',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
