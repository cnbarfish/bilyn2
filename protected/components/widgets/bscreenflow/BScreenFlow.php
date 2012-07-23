<?php
class BScreenFlowWidget extends CWidget
{
	
	/*Use this widget to organize screens into flow by ajax,if no ajax
	 * it support normal request*/

	/* screens contain all screens used in screen flow
	 * examples of screens:
	 * 'screens'=>array(
	 *           	'screenId1'=>array(	 *
	 *                      'title'=>'title of screen',
	 *                      'linkText'=>'text used for showing current screen',
	 *                      'view'=>'view file of screen',
	 *                      'Data'='data used in screen, such as form',
	 *                      'htmlOption'=>'html option apply to screen div',
	 *                      'cssFiles'=>array('urls'=>array(),'cssFiles'=>array()),
	 *                      'jsFiles'=>array()
	 *                      ),
	 *           	'screenId2'=>array(...),
	 *           'htmlOption'=>'',
	 *           'defaultView'=>'default screen view',
	 *           'defaultViewData'=>'default screen view data',
	 *           'screenSequence=>'sequence of screenId',
	 *           'containerId'=>'div id of container',
	 *           'cssFiles'=>array('urls'=>array(),'cssFiles'=>array()),
	 *           'jsFiles'=>array(),
	 *           'pathOfAlias'=>'alias of current screenflow'
	 *           )
	 *           */
	/*
	 * example of screens:
	 * $screens = array(
	 * 				'screen1'=>
	 * 					array(
	 * 						'linkText'=>'linkText used by link',
	 * 						'view"=>'view of screen',
	 * 						'data'=>'data of view')
	 * 				....
	 * */
	public $screens;
	/*
	 * if not specify nextscreen, use screensequence for order,if not specify
	 * screensequence, use order in screens
	 * */
	public $screenSequence = array();
	private $currentScreenId;
	public $defaultView;
	private $previousScreenId = false;
	private $nextScreenId = false;
	//public $containerId;
	//public $pathOfAlias;
	//public $cssFiles;
	//public $jsFiles;
	//public $pathOfAlias;
	public $htmlOptions;
	private $sfid;
	private $isAjaxScreenFlow = false;
	public $useAjaxScreenFlow = true;
	private $screenFlowAjaxKey;


	/**
	 * Default CSS class for the tab container
	 */
	const CSS_CLASS='bScreenFlow';

	public function init()
	{
		$sfid = $this->getId();
		$screenFlowAjaxKey = $sfid."isAjax";
		$isAjaxScreenFlow= isset($_GET[$screenFlowAjaxKey])? $_GET[$screenFlowAjaxKey]:'false';

		//$urlManager = Yii::app()->getUrlManager();

		foreach ($screens as $id=>$screen) {

			if(!isset($screen['content']) && !isset($screen['view']))
			$screen['view'] = $this->defaultView;

			$sLinkText = 'undefined';
			$sLinkText = isset($screen->title)?$screen->title:$id;
			$sLinkText = isset($screen->linkText)?$screen->linkText:$id;
			$screen['linkText']=$sLinkText;

			//$screen['link']=$this->gotoScreenAjaxLink($sLinkText, $id, $this->containerId);
			$screenId = $id;
			$screen['link']=getScreenUrl($sfid.$screenId);

			//$link = $screen->link;

			if(isset($_GET['sid']) && $_GET['sid'] == $sfid.$screenId)
			$currentScreenId = $screenId;
			else
			{
				reset($screens);
				$currentScreenId = empty($screenSequence)?key($screens):$screenSequence[0];				
			}
		}

		//first enter is not ajax link
		if(!$isAjaxScreenFlow == 'enable')
		{
			$htmlOptions=$this->htmlOptions;
			$htmlOptions['id']=$this->getId();
			if(!isset($htmlOptions['class']))
			$htmlOptions['class']=self::CSS_CLASS;
			echo CHtml::openTag('div',$htmlOptions)."\n";
		}

		if($currentScreenId != false)
		{					
			$screen = $screens[$currentScreenId];
			$screen->htmlOptions['id'] = $sfid.$currentScreenId;
			echo CHtml::openTag('div',$screen->htmlOptions['id'])."\n";
			$this->getController()->renderPartial($screen['view'], $screen['data']);
			echo CHtml::closeTag('div');			
		}
		else
		$this->renderNullScreen();

			
		//	$urlManager->rules['<controller:\w+>/<action:\w+>/<sid:\w+>']='<controller>/<action>';
		//$currentScreenId = isset($_GET['nsid'])?$_GET['nsid']:$screens->$items[0]->screenId;

		/*csid means currentScreenId, actually it set always in ajax request in screen
		 * if screen show in order of screensequence, do not set 'nsid'( means nextscreenid)
		 * otherwise should set nsid in ajax request
		 * */
		/*
		 * if(isset($_GET['fsid'])) //fsid means 'from screen id'
		 {
			$previousScreenId =$_GET['fsid'];
			if(isset($_GET['nsid'])) //nsid means 'next screen id'
			{
			$currentScreenId = $_GET['nsid'];
			}
			else
			{
			$currentScreenId = false;//if previous screen is last in sequence or screens, return false
			if(!empty($screenSequence))
			{
			for ($i = 0; $i < $count = $screenSequence.count()-1; $i++) {
			if($screenSequence[i]==$previousScreenId)
			{
			$currentScreenId = $screenSequence[i+1];
			}
			}
			}
			else{ //if not set sequence, use screens to find current screen
			foreach ($screens as $id=>$screen) {
			if ($previousScreenId == $id) {
			break;
			};
			}
			if(next($screens))
			$currentScreenId = key($screens);
			reset($screens);
			}
			}
			}
			else //if not get fsid, means it is the first enter of screenflow
			{
			reset($screens);
			$currentScreenId = empty($screenSequence)?key($screens):$screenSequence[0];
			}*/


	}

	//const CSS_CLASS='bilynScreenFlow';

	/**
	 * Runs the widget.
	 */
	public function run()
	{

		/*

		if(empty($this->screens)||$this->currentScreenId == false)
		return  emptyText();

		if($this->currentScreenId===null || !isset($this->screens[$this->currentScreenId]))
		{
		reset($this->screens);
		list($this->currentScreenId, )=each($this->screens);
		}

		$this->registerClientScript();
		$this->renderHeader();
		$this->renderScreen();
		*/

		if(!$isAjaxScreenFlow == 'true')
		{
			echo CHtml::closeTag('div');
		}
	}

	/**
	 * Registers the needed CSS and JavaScript.
	 */
	protected  function registerClientScript()
	{
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('yiitab');

		$cs=Yii::app()->getClientScript();
		//	$cs->registerCoreScript('treeview');
		$assetsFolder=Yii::app()->assetManager->publish(
		Yii::getPathOfAlias('application.components.widgets.bscreenflow.assets'));
		//always register bscreenflow.js file
		$cs->registerScriptFile($assetsFolder.'/bilyn.bscreenflow.js');
		//always register bscreenflow.css file
		$cs->registerCssFile($assetsFolder.'/bscreenflow.css');

		$id=$this->getId();


		//get path of current component path
		$assetsFolder=Yii::app()->assetManager->publish(
		Yii::getPathOfAlias($this->pathOfAlias.'assets'));

		if(!empty($this->clientJsFiles))
		{
			$jsFiles = $this->clientJsFiles;
			foreach ($jsFiles as $file) {
				$cs->registerScriptFile($assetsFolder.$file);
			}
		}

		if(!empty($this->cssFiles)){
			if(!empty($this->cssFiles['urls']))
			{
				$urls = $this->cssFiles['urls'];
				foreach ($urls as $url) {
					self::registerCssFile($url);
				}
			}
			if(!empty($this->cssFile['files']))
			{
				$files = $this->cssFile['files'];
				foreach ($files as $file) {
					self::registerCssFile($assetsFolder.$file);
				}
			}
		}

		$cs->registerScript('Bilyn.BScreenFlow#'.$id,"jQuery(\"#{$id}\").bilynscreenflow({$options});");

		foreach ($screens as $screenId=>$screen) {
			if(isset($screen->jsFiles)){
				$jsFiles = $screen->jsFiles;
				foreach ($jsFiles as $file) {
					$cs->registerScriptFile($assetsFolder.'/'.$file);
				}
				$id = $id.'_'.$screenId;
				$cs->registerScript('Bilyn.BScreenFlow#'.$id,"jQuery(\"#{$id}\").bilynscreen({$options});");
			};
			if(isset($screen->cssFiles)){
				if(!empty($screen->cssFiles['urls']))
				{
					$urls = $screen->cssFiles['urls'];
					foreach ($urls as $url) {
						self::registerCssFile($url);
					}
				}
				if(!empty($screen->cssFile['files']))
				{
					$files = $screen->cssFile['files'];
					foreach ($screen as $file) {
						self::registerCssFile($assetsFolder.'/'.$file);
					}
				}
			}
		}
	}

	/**
	 * Renders the header part.
	 */
	protected function renderHeader()
	{
		$sScreens = array();
		if(!empty($this->screenSequence)){
			foreach ($this->screenSequence as $screenId) {
				$sScreens[$screenId]=$this->screens[$screenId];
			}
		}
		else
		$sScreens = $this->screens;

		echo "<ul class=\"screenshead\">\n";
		foreach($sScreens as $id->$screen)
		{
			$linkText=isset($screens['linkText'])?$screens['linkText']:'undefined';
			$active=$id===$this->currentScreenId?' class="activeScreen"' : '';
			$url= $screen['ajaxLink'];
			echo "<li><a href=\"{$url}\"{$active}>{$linkText}</a></li>\n";
		}
		echo "</ul>\n";
	}


	protected  function renderScreen()
	{
		if(!$this->currentScreenId){
			echo "\n\n\n fail to find content! \n\n\n";
			return;
		}

		$screen = $this->screens[$currentScreenId];

		$htmlOption = isset($screen->htmlOption)?array():$screen->htmlOption;
		$htmlOptions['id']=$this->getId().'_'.$activScreenId;
		if(!isset($htmlOptions['class']))
		$htmlOptions['class']=self::SCREEN_CSS_CLASS;

		echo CHtml::openTag('div',$htmlOption)."\n";

		if(isset($screen['content']))
		echo $screen['content'];
		else if(isset($screen['view']))
		{
			if(isset($screen['data']))
			{
				if(is_array($this->viewData))
				$data=array_merge($this->viewData, $screen['data']);
				else
				$data=$screen['data'];
			}
			else
			$data=$this->viewData;

			//$reqData = array('getData'=>$_GET,'postData'=>$_POST);

			//$data=array_merge($reqData,$data);

			if(!$previousScreenId){
				$data['previousScreen'] = $screens[$previousScreenId];
				$data['previousAjax'] = $this->getPreviousAjaxRequest('previous', $previousScreenId, $this->containerId);
			}

			if(!$this->getNextScreenId($currentScreenId)){
				$data['nextScreen'] = $screens[$this->getNextScreenId($currentScreenId)];
				$data['nextAjax'] = $this->getNextAjaxRequest('next', $this->getNextScreenId($currentScreenId), $this->containerId);
			}

			$this->getController()->renderPartial($screen['view'], $data);
		}

		echo CHtml::closeTag('div');
	}

	protected  function gotoScreenAjaxRequest($linkLabel,$screenId,$updateId)
	{
		foreach ($this->screens as $id=>$screen) {
			if ($screenId == $id) {
				$url = "fsid=".$currentScreenId.";nsid=".$screenId.';';
				return getUpdateAjaxLink($linkLabel,$url,$updateId);
			};
		}

		return false;
	}

	/*public function getScreenAjaxLink($linkLabel,$screenId,$updateId)
	 {
		foreach ($this->screens as $id=>$screen) {
		if ($screenId == $id) {
		$url = "fsid=".$screenId.';';
		return getUpdateAjaxLink($linkLabel,$url,$updateId);
		};
		}

		return false;
		}*/

	protected function getNextAjaxRequest($linkLabel,$nextScreenId,$updateId)
	{
		$nextScreenId = $this->getNextScreenId($currentScreenId);

		if (!$nextScreenId) {
			return false;
		}
		else
		$url = "fsid=".$currentScreenId.";nsid=".$nextScreenId;

		return getUpdateAjaxLink($linkLabel,$url,$updateId);
	}

	protected  function getPreviousAjaxRequest($linkLabel,$previousScreenId,$updateId)
	{
		$previousId = $previousScreenId;

		if (!$previousId) {
			return false;
		}
		else
		$url = "fsid=".$currentScreenId.";nsid=".$previousId;

		return getUpdateAjaxLink($linkLabel,$url,$updateId);
	}

	protected function getNextScreenId($currentScreenId)
	{
		if(!$nextScreenId)
		return $nextScreenId;
		else
		if(!empty($this->screenSequence)){
			reset($this->screenSequence);
			foreach ($this->screenSequence as $id) {
				if($id == $currentScreenId)
				{
					if(next($this->screenSequence))
					return $id;
				}
			}
		}
		else {
			if(!empty($this->screens)){
				reset($this->screens);
				foreach ($screens as $id=>$screen) {
					if ($currentScreenId == $id)
					{
						if(next($this->screens))
						return $id;
					}
				}
			}
		}
		return false;
	}

	protected function getUpdateAjaxLink($linkLabel,$url,$updateId)
	{
		return CHtml::ajaxLink(
		$linkLabel,
		array(
		$url
		),
		array('update'=>'#'.$updateId)
		);
	}

	protected  function renderNullScreen()
	{
		echo "not find page!";
	}

	public function getNextScreenId()
	{
		return $this->getNextScreenId($currentScreenId);
	}
	public function getPreviousScreenId()
	{
		if(!$previousScreenId)
		return $previousScreenId;
		else
		if(!empty($this->screenSequence)){
			reset($this->screenSequence);
			foreach ($this->screenSequence as $id) {
				if($id == $currentScreenId)
				{
					if(prev($this->screenSequence))
					return $id;
				}
			}
		}
		else {
			if(!empty($this->screens)){
				reset($this->screens);
				foreach ($screens as $id=>$screen) {
					if ($currentScreenId == $id)
					{
						if(prev($this->screens))
						return $id;
					}
				}
			}
		}
		return false;
	}
	public function getLastScreenId()
	{
		if(!empty($this->screenSequence)){
			return $this->screenSequence[count($this->screenSequence)-1];
		}
		else {
			end($this->screens);
			return key($this->screens);
		}
		return false;
	}

	public function getFirstScreenId()
	{
		if(!empty($this->screenSequence)){
			return $this->screenSequence[0];
		}
		else {
			reset($this->screens);
			return key($this->screens);
		}
		return false;
	}
	public function getScreenUrl($screenId)
	{
		$urlManager = Yii::app()->getUrlManager();
		$screen = $this->screens[$screenId];
		$ajaxUrl = $urlManager->createUrl(Yii::app()->getController()->getRoute(),array('sid'=>$screenId,$screenFlowAjaxKey=>'enable'));

		if($this->useAjaxScreenFlow)
		{
			return getUpdateAjaxLink($screen->linkText,$ajaxUrl,$this->sfid);
		}
		else
		{
			return $urlManager->createUrl(Yii::app()->getController()->getRoute(),array('sid'=>$screenId));
		}
	}
}