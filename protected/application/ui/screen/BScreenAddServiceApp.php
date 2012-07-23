<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BScreenAddServiceApp
 *
 * @author jianfeng
 */
class BScreenAddServiceApp extends BUIScreen {

    //put your code here

    public function render($config = null, $style = NULL) {
        //    $controller = Yii::app()->getController();
        //$controller->render('addServiceApp');     
        //$service = $this->getUINode()->getActiveService();        

        $isRenderInitialView = true;

        $fStyle = null;

        if ($style != NULL)
            $fStyle = $sStyle;

        //   $form = $this->getFormByMeta('AddServiceApplication', $fStyle);
        $addForm = $this->getFormByMeta('AddServiceApplication', $fStyle, array('model' => 'CreateServiceFormModel'));

        if ($isRenderInitialView)
            $this->renderView('showOneForm', array('form' => $addForm), $config, $style);
    }

    public function getServiceAppsData() {

        $service = $this->getUINode()->getActiveService();

        $db = $service->getServiceEngine()->getDbAdapter();

        $apps = $db->getServiceApps($service->getId());

        $data = array();

        foreach ($apps as $app) {
            $data[$app->getId()] = $app->getName();
        }
        return $data;
    }

}

?>
