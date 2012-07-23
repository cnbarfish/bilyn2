<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />      

        <link rel="stylesheet" type="text/css"
              href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css"
              href="<?php echo Yii::app()->request->baseUrl; ?>/css/bilyn.css" />
        <link rel="stylesheet" type="text/css"
              href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div id="page">
            <div id="header" class="container">
                <div class="span3">
                    <pt1> <?php echo CHtml::encode(Yii::app()->name); ?></pt1>
                </div>
                <div class="span4">
                    <pt2>海内存知己，天涯若比邻</pt2>
                </div>

            </div>

            <!-- header -->
            <div style="margin-left: 0px; margin-top: 0">

                <?php if (!Yii::app()->user->isGuest): ?>
                    <?php
                    //$topMenu = Yii::app()->getController()->menu;
                    //    $menuManager = Yii::app()->getController()->menuManager;
                    $mainMenu = Blyn::util()->getMenuManager()->getBootStrapMenu('mainMenu');
                    //	$menuManager->setMenuItemAttributes($mainMenu,array('url'=>'site/serviceMap'),array('active'=>true));
                    /*
                      $this->widget('bootstrap.widgets.BootMenu', array(
                      'band'=>'bilyn.com',
                      'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
                      'stacked'=>false, // whether this is a stacked menu
                      'items'=>$mainMenu['items']));
                     */
                    ?>
                    <!-- mainmenu -->

                    <?php
                    $this->widget('bootstrap.widgets.BootNavbar', array(
                        'fixed' => false,
                        'brand' => 'bilyn.com',
                        'brandUrl' => '#',
                        'items' => array(array(
                                'class' => 'bootstrap.widgets.BootMenu',
                                'type' => 'pills', // '', 'tabs', 'pills' (or 'list')
                                'stacked' => false, // whether this is a stacked menu
                                'items' => $mainMenu['items']))));
                    ?>
                    <!-- mainmenu -->
                <?php endif ?>
            </div>

            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?>
                <!-- breadcrumbs -->
            <?php endif ?>


            <?php echo $content; ?>

            <div id="footer">
                Copyright &copy;
                <?php echo date('Y'); ?>
                by Bilyn.<br /> All Rights Reserved.<br />

            </div>
            <!-- footer -->

        </div>
        <!-- page -->

    </body>
</html>
