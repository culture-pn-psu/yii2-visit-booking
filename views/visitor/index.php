<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use culturePnPsu\visitBooking\models\Visitor;
/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\visitBooking\models\VisitorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('culture/visitor', 'Visitors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitor-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('culture/visitor', 'Create Visitor'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            [
                'attribute' => 'type',
                'value'=>'typeLabel',
                'filter' => Visitor::getTypeList()
                ],
            'created_by',
            'created_at',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
