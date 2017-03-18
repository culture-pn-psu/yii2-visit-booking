<?php

namespace culturePnPsu\visitBooking\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "visitor".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 */
class Visitor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visitor';
    }
    
    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [ 
          'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['type', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('culture/visitor', 'ID'),
            'title' => Yii::t('culture/visitor', 'Title'),
            'type' => Yii::t('culture/visitor', 'Type'),
            'created_by' => Yii::t('culture', 'Created By'),
            'created_at' => Yii::t('culture', 'Created At'),
            'updated_by' => Yii::t('culture', 'Updated By'),
            'updated_at' => Yii::t('culture', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return VisitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VisitorQuery(get_called_class());
    }
    
    const TYPE_FACULTY = 1;
    const TYPE_DEPARTMENT = 2;
    const TYPE_SCHOOL =3;

    
    public function getItems($key){
        $items = [
            'type'=> [
                self::TYPE_FACULTY => Yii::t('culture/visitor', 'Faculty'),
                self::TYPE_DEPARTMENT => Yii::t('culture/visitor', 'Department'),
                self::TYPE_SCHOOL => Yii::t('culture/visitor', 'School'),
                ]
            ];
        return ArrayHelper::getValue($items,$key);
    }
    
    public function getTypeLabel(){
        return ArrayHelper::getValue(self::getItems('type'),$this->type);
    }
    
    public static function getTypeList(){
        return self::getItems('type');
    }
    
    public static function getDistinctTitle(){
        return ArrayHelper::getColumn(self::find()->distinctTitle(),'title');
    }
    
    public static function getList(){
        return ArrayHelper::map(self::find()->all(),'id', 'title');
    }
    
    
}
