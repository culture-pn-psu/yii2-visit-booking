<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
use dmstr\widgets\Menu;
//use firdows\menu\models\Navigate;
//use culturePnPsu\material\components\Navigate;
use mdm\admin\components\Helper;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
$user = Yii::$app->user->identity->profile->resultInfo;
$module = $this->context->module->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class='box'>
    <div class='box-header with-border'>
        <h3 class='box-title'><?= Yii::t('culture/visit-booking', 'Visit Bookings') ?></h3>
    </div><!--box-header -->

    <div class='box-body'>
        <div class="nav-tabs-custom">
      <?php
    $menuItems = [];
    
    $menuItems[] =  [
           'label' => Yii::t('culture/visit-booking', 'Manage Visit Bookings'),
           //'options'=>['class'=>'pull-left header'],
            'url' => ["/{$module}/default/"],
            'icon' => 'fa fa-sitemap',
     ];
     
     $menuItems[] =  [
            'label' => Yii::t('culture/visitor',  'Visitors'),
            'url' => ["/{$module}/visitor/"],
            'icon' => 'fa fa-sitemap',
     ];
     
    $menuItems = Helper::filter($menuItems);
    $newMenu = [];
    foreach($menuItems as $k=>$menu){
      $newMenu[$k]=$menu;
      $newMenu[$k]['url'][0] = rtrim($menu['url'][0], "/");
    }
    $menuItems=$newMenu;
    //print_r($menuItems);
    //$nav = new Navigate();
    echo Menu::widget([
        'options' => ['class' => 'nav nav-tabs'],
        'encodeLabels' => false,
        //'activateParents' => true,
        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
        'items' => $menuItems,
    ]);
    ?>
      
    

        <div class='tab-content'>
        
            <?= $content ?>
        </div>
    </div>
</div>


<?php $this->endContent(); ?>
