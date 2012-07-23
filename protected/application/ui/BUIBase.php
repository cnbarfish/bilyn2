<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUIBase
 *
 * @author ID59C
 */
abstract class BUIBase {

    const BOOTSTRAPSTYLE = "bootstrap";

    public function getHomeUrl() {
        return $this->buildUrl();
    }

    public function buildUrl($serviceId = null, $appId = null, $operationId = null, $data = null) {

        $params = array();

        if ($serviceId == 'index' || $serviceId == 'home') {
            return array('site/index');
        }

        $bn = null;

        if ($serviceId != null) {
            //$serviceId = $service->getId();
            $serviceId = (($serviceId + 99) * 2 + 2) * 3;
            $bn = $serviceId;
        }

        if ($appId != null) {
            //$appId = $app->getId();
            $appId = (($appId + 99) * 3 + 2) * 2;
            $bn = $bn . "_" . $appId;
        }

        if ($operationId != null) {
            //$opId = $operation->getId();
            $opId = (($operationId + 99) * 2 + 2) * 3;
            $bn = $bn . "_" . $opId;
        }

        if ($bn != NULL)
            $params['bn'] = $bn;

        if ($data != null) {
            foreach ($data as $key => $value) {
                if ($key != 'bn')
                    $params[$key] = $value;
            }
        }

        $url = array('site/index');

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $url[$key] = $value;
            }
        }

        return $url;
    }

    public function deUrl() {

        if (isset($_GET['bn'])) {

            $bnString = $_GET['bn'];

            $t = explode("#", $bnString);

            $url = trim($t[0], "_");

            $s = explode("_", $url);

            $config = array();

            if (isset($s[0])) {
                $sId = intval($s[0]);
                $config['ServiceId'] = ($sId / 3 - 2) / 2 - 99;
            }

            if (isset($s[1])) {
                $aId = intval($s[1]);
                $config['AppId'] = ($aId / 2 - 2) / 3 - 99;
            }

            if (isset($s[2])) {
                $oId = intval($s[2]);
                $config['OperationId'] = ($oId / 3 - 2) / 2 - 99;
            }

            return $config;
        }
    }

    //put your code here
    public function getFormByMeta($formName, $parentScreen = null, $config = NULL) {

        $form = null;
        $formMeta = null;
        $formModel = null;

        if ($config != NULL) {
            if (isset($config['meta']))
                $formMeta = $config['meta'];

            if (isset($config['model']))
                $formModel = $config['model'];
        }

        if ($formMeta == NULL)
            $formMeta = $this->getFormMeta($formName . 'FormMeta');

        if ($formModel == NULL) {
            $modelName = $formName . 'FormModel';
            $formModel = new $modelName;
        }
        else
            $formModel = new $formModel;

        $formModel->setScenario($formName);

        $form = new BForm($parentScreen, $formMeta, $formModel);

        return $form;
    }

    protected function getFormMeta($name) {

        $lname = lcfirst($name);

        if (!isset($this->$lname)) {
            $meta = require(Yii::getPathOfAlias('application.application.ui.form.meta.' . $name) . '.php');
        }
        else
            $meta = $this->$lname;

        return $meta;
    }

    public function getScreen($name) {
        $screenClassName = 'BScreen' . ucfirst($name);
        $screen = new $screenClassName();
        $screen->setParent($this);
        return $screen;
    }

    /**
     * 
     */
    public function getScreenFlow($name) {
        $scnFlow = new BUIScreenFlow($name);
        $scnFlow->setUINode($this);
        return $scnFlow;
    }

    public function gotoScreen($name, $config = null) {
        $screen = $this->getScreen($name);
        $screen->render($config);
    }

    public function gotoScreenFlow($name, $config = null) {
        //  $flowIndex = isset($_POST['bilyn_screenflow_index']) ? $_POST['bilyn_screenflow_index'] : '0';
        $scnFlow = $this->getScreenFlow($name);
        if (!isset($_POST['bilyn_screenflow_index'])) {
            $scnFlow->rewind();
            $scnFlow->render($config);
        } else {
            $index = $_POST['bilyn_screenflow_index'];
            $screen = $scnFlow->getScreenByIndex($index);
            $screen->render($config);
        }
    }

    /**
     *
     * @param type $style
     * @return BMenuBootStrap 
     */
    protected function getMenuManager($style = null) {
        if ($style == NULL)
            $style = BUIApp::BOOTSTRAPSTYLE;

        if ($style == BUIApp::BOOTSTRAPSTYLE) {
            if ($this->bootStrapMenu == null) {
                $this->bootStrapMenu = new BMenuBootStrap ();
                $this->menuManager = $this->bootStrapMenu;
            }

            return $this->bootStrapMenu;
        }
    }

    public function getMenu($name, $style = null) {

        if ($style == NULL)
            $style = BUIApp::BOOTSTRAPSTYLE;

        $menuManager = $this->getMenuManager($style);

        $menus = $menuManager->menus;

        if (!isset($menus[$name])) {
            $this->registerMenus($style);
        }

        return $menuManager->getMenu($name);
    }

    public function addMenuItem(&$menu, $menuItem, $style = NULL) {
        $menuManager = $this->getMenuManager($style);
        $menuManager->addMenuItem($menu, $menuItem);
    }

    public function addMenu($name, $menu, $style = NULL) {
        $menuManager = $this->getMenuManager($style);
        $menuManager->addMenu($name, $menu);
    }

    protected abstract function registerMenus($style = NULL);

    public function getViewPath($pathAlias = NULL, $style = NULL) {

        if ($style == NULL)
            $style = Blyn::app()->getAppUI()->getStyle();

        $defaultPath = yii::getPathOfAlias('application.application.ui.view.' . $style);

        if ($pathAlias != NULL) {
            $path = yii::getPathOfAlias($pathAlias);
            if (is_dir($path))
                return $path;
        }
        $path = $defaultPath;

        if ($path != NULL) {
            return $path;
        }

        return FALSE;
    }

}

?>
