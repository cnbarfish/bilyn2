<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //by default, set style to pc_bootstrape
        Blyn::app()->getAppUI()->setStyle(BUIApp::PC_BOOTSTRAPE);

        $device = BUIApp::detectDevice();

        if ($device == BUIApp::DEVICE_IPHONE || $device == BUIApp::DEVICE_ANDROID
                || $device == BUIApp::DEVICE_MOBILE_GENERAL)
            yii::app()->setTheme(BUIApp::MOBILE_BOOTSTRAPE);
        // Blyn::app()->getAppUI()->setStyle(BUIApp::MOBILE_BOOTSTRAPE);

        if ($device == BUIApp::DEVICE_IPAD || $device == BUIApp::DEVICE_ANDROID_TABLET
                || $device == BUIApp::DEVICE_TABLET_GENERAL)
            yii::app()->setTheme(BUIApp::TABLET_BOOTSTRAPE);
            //Blyn::app()->getAppUI()->setStyle(BUIApp::TABLET_BOOTSTRAPE);

        if (Yii::app()->user->isGuest)
            $this->actionLogin();
        else {
            $deConfig = Blyn::app()->getAppUI()->deUrl();

            if ($deConfig == null) {
                Blyn::app()->getAppUI()->renderIndex();
                //$this->render('index');
            }

            if (isset($deConfig['OperationId']))
                $this->actionOperation($deConfig['ServiceId'], $deConfig['AppId'], $deConfig['OperationId']);
            else {
                if (isset($deConfig['AppId']))
                    $this->actionApp($deConfig['ServiceId'], $deConfig['AppId']);
                else {
                    if (isset($deConfig['ServiceId']))
                        $this->actionService($deConfig['ServiceId']);
                }
            }
        }
    }

    public function actionService($serviceId) {

        if ($serviceId == BService::NEWSERVICE) {
            $uiManager = new BUIService;
            $uiManager->renderCreateService();
        }

        if ($serviceId == BService::JOINSERVEDSERVICE || $serviceId == BService::JOINWORKINGSERVICE) {
            $uiManager = new BUIService;
            $uiManager->renderJoinService();
        }

        if ($serviceId > 0) {
            $service = new BService($serviceId);
            $service->getUIManager()->render();
        }
    }

    public function actionApp($serviceId, $appId) {
        $service = new BService($serviceId);
        $app = BServiceApp::getInstanceById($appId, $service);
        $app->getUIManager()->render();
    }

    public function actionOperation($serviceId, $appId, $operationId) {

        $service = new BService($serviceId);
        //     $app = BServiceApp::getInstanceById($appId, $service);
        $operation = new BOperation($operationId);
        $operation->setActiveService($service);
        $operation->getUIManager()->render();
    }

    /**
     * This is the action to handle external excepiftions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {

        /* $uiUser = new BUIUser();

          $uiUser->login($this);
         * 
         */

        Blyn::app()->getAppUI()->renderLogin();

        /*
          $modelLogin = new LoginForm;
          $modelRegister = new RegisterForm;
         * *
         */

        // if it is ajax validation request
        /*
          if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
          echo CActiveForm::validate($model);
          Yii::app()->end();
          }
         */

        // collect user input data
        /*
          if (isset($_POST['LoginForm'])) {
          $modelLogin->attributes = $_POST['LoginForm'];
          // validate user input and redirect to the previous page if valid
          if ($modelLogin->validate() && $modelLogin->login())
          $this->redirect(Yii::app()->user->returnUrl);
          //    $this->actionIndex ();
          }
         * *
         */

        // if it is ajax validation request
        /*
          if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
          echo CActiveForm::validate($model2);
          Yii::app()->end();
          }
         */

        // collect user input data
        /*
          if (isset($_POST['RegisterForm'])) {
          $modelRegister->attributes = $_POST['RegisterForm'];
          // validate user input and redirect to the previous page if valid
          //after register, login automatically
          if ($modelRegister->validate() && $modelRegister->register()) {
          $modelLogin->email = $modelRegister->email;
          $modelLogin->password = $modelRegister->password;
          //    	$modelLogin->username = $modelRegister->name;

          if ($modelLogin->login())
          $this->redirect(Yii::app()->user->returnUrl);
          }
          }
         * *
         */


        // display the login form
        //  $this->layout = '//layouts/column1';
        //   $this->render('loginTab', array('modelLogin' => $modelLogin, 'modelRegister' => $modelRegister));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionServiceMap() {

        $this->render('index');
    }

}