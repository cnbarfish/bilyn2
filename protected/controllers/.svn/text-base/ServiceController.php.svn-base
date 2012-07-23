<?php

class ServiceController extends Controller {

	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array(
		// captcha action renders the CAPTCHA image displayed on the contact page
		 
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		 
		//    	$serviceModel = new BService();
		//    	$serviceteamModel = new BServiceteam();
		$this->render('index_service');

	}
    
    /*
     * 1.选择service名称，选择类型（个人服务还是商业服务），选择service分类（选择分类，将会创建相应功能）
		2,service工作圈设置，设置权限（权限将会根据分类提供模板）
		3.service对象圈设置，设置权限
		4.选择service的功能（功能将会根据分类提供模板）
		5.最终创建服务
		
     * */
    public function actionCreateService(){
    	
    	$this->render('createService');    
      
    }
}