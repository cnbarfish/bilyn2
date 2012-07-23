<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUISCreenCreateService
 *
 * @author jianfeng
 */
class BScreenCreateServiceMeta extends BUIScreen {

    //put your code here

    public function render($config = null, $style = NULL) {

        return $this->renderCreateService($config, $style);
    }

    public function renderCreateService($config = null, $style = NULL) {
        
        if(!is_array($config))
        {
            $config = array();
        }

        $controller = Yii::app()->getController();

        $isRenderInitialView = true;

        $fStyle = null;

        if ($style != NULL)
            $fStyle = $sStyle;

        $form = $this->getFormByMeta('CreateService',  $this, $fStyle);

        if ($form->submitted('next') && $form->validate()) {
            $isRenderInitialView = FALSE;
            $model = $form->getModel();
            $serviceId = $this->createService($model->serviceName, $model->serviceCategory,FALSE);
            $service = new BService($serviceId);            
            $this->setUINode(new BUIService($service));
            $service->setVisible(FALSE);
            //        $url = Blyn::app()->getAppUI()->enUrl($serviceId);
            //        $controller->redirect($url);
            //       $controller->render('showOneForm', array('form' => $addForm));
            if ($this->parent instanceof BUIScreenFlow)
                $this->parent->gotoNext($config, $style);
            else
                $this->gotoScreen('AddServiceApp', $config,$sStyle);
        }
        if ($form->submitted('cancel')) {
            $controller->redirect($this->getHomeUrl());
        }

        if ($isRenderInitialView)
            $this->renderView('showOneForm', array('form' => $form),$config,$style);
    }

    public function addServiceApps() {
        
    }

    public function createServiceMeta() {
        
    }

    public function getServiceTypeData() {
        $data = CHtml::listData(BMServiceType::model()->findAll(), '_id', 'typename');
        return $data;
    }

    public function getServiceCategoryData() {
        $data = CHtml::listData(BMServiceCategory::model()->findAll(), '_id', 'categoryname');
        return $data;
    }

    public function getServiceApps() {
        $sql = "select * from bln_application where showable > 0";
        $data = CHtml::listData(BMApplication::model()->findAllBySql($sql), '_id', 'appname');

        $db = Blyn::app()->getAppDb();

        $typeApps = $db->getVisibleServiceApps(NULL, BService::NORMALSERVICETYPE);

        $data = CHtml::listData($typeApps, '_id', 'appname');
        return $data;
    }

    protected function createService($name, $categoryId, $visible = true,$appId = null) {
        $service = BService::createService(array('ServiceName' => $name, 'ServiceCategoryId' => $categoryId,'Visible'=>$visible));

        if ($appId != null) {
            $app = BServiceApp::getInstanceById($appId);
            $app->addToService($service);
        }

        $this->serviceId = $service->getId();

        return $this->serviceId;
    }

}

?>
