<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BAppUI
 *
 * @author ID59C
 */
class BUIApp extends BUINode {

    const LEFTMENU = "leftmenu";
    const MAINMENU = 'mainmenu';
    const PC_BOOTSTRAPE = 'pc_bootstrap';
    const MOBILE_BOOTSTRAPE = 'm_bootstrap';
    const TABLET_BOOTSTRAPE = 't_bootstrap';
    const DEVICE_IPHONE = 'iphone';
    const DEVICE_IPAD = "ipad";
    const DEVICE_ANDROID_TABLET = 'android_tablet';
    const DEVICE_MOBILE_GENERAL = "mobile_general";
    const DEVICE_TABLET_GENERAL = "tablet_general";
    const DEVICE_ANDROID = 'android';

    protected $style = null;

    public function setStyle($style) {
        $this->style = $style;
    }

    public function getStyle() {
        return $this->style;
    }

    public function renderLogin() {
        $controller = Yii::app()->getController();
        $homeUrl = Blyn::app()->getAppUI()->buildUrl();
        $form = $this->getFormByMeta("Login");
        $signForm = $this->getFormByMeta("Signup");

        $loginModel = null;
        $renderLogin = true;

        if ($form->submitted("login") && $form->validate()) {
            $loginModel = $form->getModel();
            $loginModel->login();
            $controller->redirect($homeUrl);
        }

        if ($form->submitted("signup")) {
            //  $controller->redirect(array("site/signup"));
            $renderLogin = FALSE;
            $controller->layout = "//layouts/column1";
            $controller->render("showOneForm", array('form' => $signForm));
        }

        if ($signForm->submitted("signup")) {
            $renderLogin = FALSE;
            if ($signForm->validate()) {

                $model = $signForm->getModel();

                if ($model->signUp()) {
                    $loginModel = new LoginFormModel();
                    if ($loginModel->login($model->email, $model->password)) {
                        $controller->redirect($homeUrl);
                    }
                }
            }
            $controller->layout = "//layouts/column1";
            $controller->render("showOneForm", array('form' => $signForm));
        }

        if ($renderLogin) {
            $controller->layout = "//layouts/column1";
            $controller->render('showOneForm', array('form' => $form));
        }
    }

    public function render($config = null) {
        $this->gotoScreen('index', $config);
    }

    public function renderIndex($config = null) {
        $this->render($config);
    }

    public function registerMenus($style = NULL) {

        $menuManager = $this->getMenuManager($style);

        $mainMenu = array(
            'items' => array(
                array('label' => 'My Space', 'url' => array('site/index')),
                array('label' => 'Service Map', 'url' => array('site/serviceMap')),
                array('label' => 'logout(' . Yii::app()->user->name . ')',
                    'url' => array('/site/logout'))));

        $menuManager->addMenu(self::MAINMENU, $mainMenu);

        $app = Blyn::app();
        $pService = $app->getCurrentUser()->getPersonalService();
        $psApps = $pService->getServiceEngine()->doOperation(BServiceEngine::GETSERVICEAPPSOPERATION, array('Service' => $pService));

        $leftMenu = array('items' => array());
        $menuManager->addMenuItem($leftMenu, array('label' => 'My Space'));

        foreach ($psApps as $sApp) {
            if ($sApp->isShowAble()) {
                $menuManager->addMenuItem($leftMenu, array('label' => $sApp->getName(),
                    'url' => $this->buildUrl($pService->getId(), $sApp->getId())));
            }
        }

        //render workingteam of services' navigation menu  
        $menuManager->addMenuItem($leftMenu, array('label' => 'My Working Services'));
        $menuManager->addMenuItem($leftMenu, array('label' => 'Create new service',
            'url' => $this->addTeamTypeIntoUrL($this->buildUrl(BService::NEWSERVICE), BService::WORKTEAMTYPE)));

        $menuManager->addMenuItem($leftMenu, array('label' => 'Join working service',
            'url' => $this->addTeamTypeIntoUrL($this->buildUrl(BService::JOINWORKINGSERVICE), BService::WORKTEAMTYPE)));

        $services = array();
        $wadmin_services = $app->getCurrentUser()->getCurrentUserServices(BUser::WORKTEAMADMINROLE);
        $sadmin_services = $app->getCurrentUser()->getCurrentUserServices(BUser::SERVEDTEAMADMINROLE);
        $wmber_services = $app->getCurrentUser()->getCurrentUserServices(BUser::WORKTEAMMEMBERROLE);

        foreach ($wadmin_services as $key => $value) {
            $services[$key] = $value;
        }

        foreach ($wmber_services as $key => $value) {
            $services[$key] = $value;
        }

        foreach ($sadmin_services as $key => $value) {
            $services[$key] = $value;
        }

        foreach ($services as $service) {
            $this->addServiceMenuItem($leftMenu, $service, BService::WORKTEAMTYPE, $style);
        }

        //render servedteams' navigation menu
        $menuManager->addMenuItem($leftMenu, array('label' => 'My Joined Services'));
        $menuManager->addMenuItem($leftMenu, array('label' => 'Join a service',
            'url' => $this->addTeamTypeIntoUrL($this->buildUrl(BService::JOINSERVEDSERVICE), BService::SERVEDTEAMTYPE)));

        $smber_services = $app->getCurrentUser()->getCurrentUserServices(BUser::SERVEDEAMMEMBERROLE);

        foreach ($smber_services as $service) {
            $this->addServiceMenuItem($leftMenu, $service, BService::SERVEDTEAMTYPE, $style);
        }

        $menuManager->addMenu(self::LEFTMENU, $leftMenu);
    }

    protected function addServiceMenuItem(&$menu, $service, $type, $style) {
        $menuManager = $this->getMenuManager($style);
        if ($service->getVisible()) {
            $menuItem = array();
            $menuItem['label'] = $service->getName();
            $menuItem['url'] = $this->buildUrl($service->getId());
            $url = $menuItem['url'];
            $menuItem['url'] = $this->addTeamTypeIntoUrL($url, $type);
            $menuManager->addMenuItem($menu, $menuItem);
        }
    }

    protected function addTeamTypeIntoUrL($url, $type) {
        $bn = $url['bn'];
        $url['bn'] = $bn . "#" . $type;

        return $url;
    }

    public static function detectDevice() {

        $iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
        if (stripos($_SERVER['HTTP_USER_AGENT'], "Android") && stripos($_SERVER['HTTP_USER_AGENT'], "mobile")) {
            $Android = true;
        } else if (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
            $Android = false;
            $AndroidTablet = true;
        } else {
            $Android = false;
            $AndroidTablet = false;
        }
        $webOS = stripos($_SERVER['HTTP_USER_AGENT'], "webOS");
        $BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
        $RimTablet = stripos($_SERVER['HTTP_USER_AGENT'], "RIM Tablet");

        if ($iPhone)
        {
            return BUIApp::DEVICE_IPHONE;
        }

        if ($iPad)
        {
            return BUIApp::DEVICE_IPAD;
        }

        if ($AndroidTablet)
        {
            return BUIApp::DEVICE_ANDROID_TABLET;
        }

        if ($Android)
            return BUIApp::DEVICE_ANDROID;

        if ($iPod || $BlackBerry || $Android || $webOS) {
            return BUIApp::DEVICE_MOBILE_GENERAL;
        }

        if ($RimTablet)
            return BUIApp::DEVICE_TABLET_GENERAL;


        $mobile_browser = '0';

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-');

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'OperaMini') > 0) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0) {
            $mobile_browser = 0;
        }

        if ($mobile_browser > 0) {
            return BUIApp::DEVICE_MOBILE_GENERAL;
        }
        
        return FALSE;
    }

}

?>
