<?php

namespace culturePnPsu\visitBooking\controllers;

use Yii;
use culturePnPsu\visitBooking\models\Visitor;
use culturePnPsu\visitBooking\models\VisitBooking;
use culturePnPsu\visitBooking\models\VisitBookingDetail;
use culturePnPsu\visitBooking\models\VisitBookingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use culturePnPsu\learningCenter\models\LearningCenter;

/**
 * DefaultController implements the CRUD actions for VisitBooking model.
 */
class DefaultController extends Controller
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
     * Lists all VisitBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VisitBooking model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VisitBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VisitBooking();
        $modelBookingDetail = new VisitBookingDetail();
        $modelVisitor = new Visitor();

        if ($model->load(Yii::$app->request->post())){
            
            $post = Yii::$app->request->post();
            // echo "<pre>";
            // print_r($post);
            $valid = false;
            
            if (isset($post['VisitBookingDetail']['learning_center_id'])) {
                foreach ($post['VisitBookingDetail']['learning_center_id'] as $key => $detail) {
                    foreach ($detail['booking_time'] as $time => $select) {
                        echo $time .' '. $select."<br/>";
                        if($valid = $select !== 0){
                            break;
                        }
                    }
                }
            }
            if($valid === false){
                $modelBookingDetail->addError('booking_time','กรุณาเลือกเวลา');
            }
            // echo $valid;
            // exit();
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                         if (isset($post['VisitBookingDetail']['learning_center_id'])) {
                            foreach ($post['VisitBookingDetail']['learning_center_id'] as $key => $detail) {
                                foreach ($detail['booking_time'] as $time => $select) {
                                    if($select){
                                        $modelDetail = new VisitBookingDetail();
                                        $modelDetail->visit_booking_id = $model->id;
                                        $modelDetail->learning_center_id = $key;
                                        $modelDetail->booking_time = $time;
                                        if (!($flag = $modelDetail->save(false))) {
                                            break;
                                        }
                                    }
                                }
                            }
                         }
                         
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                        print_r($model->getErrors());
                        print_r($modelBookingDetail->getErrors());
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            
            
            
        } 
            return $this->render('create', [
                'model' => $model,
                'modelBookingDetail' => $modelBookingDetail,
                'modelVisitor' => $modelVisitor,
            ]);
        
    }

    /**
     * Updates an existing VisitBooking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VisitBooking model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VisitBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VisitBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VisitBooking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
