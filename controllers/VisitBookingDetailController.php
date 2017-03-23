<?php

namespace culturePnPsu\visitBooking\controllers;

use Yii;
use culturePnPsu\visitBooking\models\VisitBookingDetail;
use culturePnPsu\visitBooking\models\VisitBookingDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VisitBookingDetailController implements the CRUD actions for VisitBookingDetail model.
 */
class VisitBookingDetailController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all VisitBookingDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitBookingDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VisitBookingDetail model.
     * @param integer $visit_booking_id
     * @param integer $learning_center_id
     * @param string $booking_time
     * @return mixed
     */
    public function actionView($visit_booking_id, $learning_center_id, $booking_time)
    {
        return $this->render('view', [
            'model' => $this->findModel($visit_booking_id, $learning_center_id, $booking_time),
        ]);
    }

    /**
     * Creates a new VisitBookingDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VisitBookingDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'visit_booking_id' => $model->visit_booking_id, 'learning_center_id' => $model->learning_center_id, 'booking_time' => $model->booking_time]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VisitBookingDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $visit_booking_id
     * @param integer $learning_center_id
     * @param string $booking_time
     * @return mixed
     */
    public function actionUpdate($visit_booking_id, $learning_center_id, $booking_time)
    {
        $model = $this->findModel($visit_booking_id, $learning_center_id, $booking_time);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'visit_booking_id' => $model->visit_booking_id, 'learning_center_id' => $model->learning_center_id, 'booking_time' => $model->booking_time]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VisitBookingDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $visit_booking_id
     * @param integer $learning_center_id
     * @param string $booking_time
     * @return mixed
     */
    public function actionDelete($visit_booking_id, $learning_center_id, $booking_time)
    {
        $this->findModel($visit_booking_id, $learning_center_id, $booking_time)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VisitBookingDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $visit_booking_id
     * @param integer $learning_center_id
     * @param string $booking_time
     * @return VisitBookingDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($visit_booking_id, $learning_center_id, $booking_time)
    {
        if (($model = VisitBookingDetail::findOne(['visit_booking_id' => $visit_booking_id, 'learning_center_id' => $learning_center_id, 'booking_time' => $booking_time])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
