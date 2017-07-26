<?php

namespace culturePnPsu\visitBooking\controllers;

use Yii;
use culturePnPsu\visitBooking\models\Visitor;
use culturePnPsu\visitBooking\models\VisitBooking;
use culturePnPsu\visitBooking\models\VisitBookingDetail;
use culturePnPsu\visitBooking\models\VisitBookingDetailSearch;
use culturePnPsu\visitBooking\models\VisitBookingSearch;
use culturePnPsu\visitBooking\models\VisitBookingTodaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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
        $searchModel = new VisitBookingTodaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        $dataProvider->sort->defaultOrder = [
            'visit_date'=>SORT_ASC,
            ];
        $dataProvider->pagination = false;
            
        $dataProvider->setModels(yii\helpers\ArrayHelper::index(
            $dataProvider->getModels(),null
            ,[
                function($model){
                    return Yii::$app->formatter->asDate($model->visit_date,"php:Y-m-d");
                },
                function($model){
                    return Yii::$app->formatter->asDate($model->visit_date,"php:Y-m-d");
                }
            ]));

        // echo "<pre>";
        // print_r($dataProvider->getModels());
        // exit();
    
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
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $this->findModel($id),
                        'ajax' => Yii::$app->request->isAjax
            ]);
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
                        'ajax' => Yii::$app->request->isAjax
            ]);
        }
        
    }

    /**
     * Creates a new VisitBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($start = null,$formAction=null,$isAjax = null)
    {
        $model = new VisitBooking();
        $modelBookingDetail = new VisitBookingDetail();
        $modelVisitor = new Visitor();
        
        if(isset($start))
        $model->visit_date = $start.' '.date('H:i:s');
        
        $success = false;
        $result=null;

        if ($model->load(Yii::$app->request->post())){
            
            $post = Yii::$app->request->post();
            $valid = false;
            if (isset($post['VisitBookingDetail']['learning_center_id'])) {
                foreach ($post['VisitBookingDetail']['learning_center_id'] as $key => $detail) {
                    foreach ($detail['booking_time'] as $time => $select) {
                        //echo $time .' '. $select."<br/>";
                        if($valid = $select !== 0){
                            break;
                        }
                    }
                }
            }
            if($valid === false){
                $modelBookingDetail->addError('booking_time','กรุณาเลือกเวลา');
            }
            // echo "<pre>";
            // print_r($post);
            // echo $valid;
            // exit();
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model->visit_date = $model->visit_date.' '.$model->visit_time;
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
                        if (Yii::$app->request->isAjax) {
                           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            
                            $success = true;
                            $result = $model->attributes;
                            return ['success' => $success, 'result' => $result];
                        }else{
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    } else {
                        $transaction->rollBack();
                        // print_r($model->getErrors());
                        // print_r($modelBookingDetail->getErrors());
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            
            
            
        } 
        
        if (isset($isAjax)) {
            return $this->renderPartial('_form', [
                'model' => $model,
                'modelBookingDetail' => $modelBookingDetail,
                'modelVisitor' => $modelVisitor,
                'formAction'=>$formAction
            ]);
        } else {
             return $this->render('create', [
                'model' => $model,
                'modelBookingDetail' => $modelBookingDetail,
                'modelVisitor' => $modelVisitor,
                'formAction'=>$formAction
            ]);
        }
        
    }
    
     public function actionResize($id = null) {
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['id']);
        $json = ["success" => false, $post];
        //print_r($post);
        
        if ($model->load(['VisitBooking'=> $post])) {
            $time = Yii::$app->formatter->asTime($model->visit_date,'php:H:i:s');
            $model->visit_date = $post['start'].' '.$time;
            if ($model->save()) {
                $json = ["success" => true];
            }
        }
        header('Content-type: application/json');
        echo Json::encode($json);
        Yii::$app->end();
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
    
    
    ################################
    
    public function actionJsoncalendar($start = NULL, $end = NULL, $_ = NULL) {
        $activity = VisitBooking::find()->all();
        $events = array();
        foreach ($activity as $act) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $act->id;
            
            //$status=$act->status==0?' ('.$act->statusLabel.')':'';
            $Event->title = $act->visitor->title; 
            
            //$Event->textColor = $act->status?'#fff':'#ff0000';
            //$Event->color = $act->calendar->color;
            // $Event->start = Yii::$app->formatter->asDate($act->visit_date, 'php:Y-m-d h:i:s');
            // $Event->end = Yii::$app->formatter->asDate($act->visit_date, 'php:Y-m-d h:i:s');
            $Event->start = $act->visit_date;
            //$Event->end = Yii::$app->formatter->asDate($act->visitBooking->visit_date, 'php:Y-m-d\TH:i:s\Z');
            $Event->editable = false;
            $Event->allDay = false;
            $Event->durationEditable = true;
            $Event->startEditable = true;
            $events[] = $Event;
        }
        //print_r($events);
        header('Content-type: application/json');
        echo Json::encode($events);
        Yii::$app->end();
    }
}
