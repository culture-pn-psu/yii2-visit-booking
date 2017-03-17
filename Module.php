<?php

namespace culturePnPsu\visitBooking;

/**
 * visitBooking module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'culturePnPsu\visitBooking\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = 'main';
        parent::init();

        // custom initialization code goes here
    }
}
