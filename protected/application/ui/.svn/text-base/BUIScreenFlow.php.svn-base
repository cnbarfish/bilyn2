<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUIScreenFlow
 *
 * @author jianfeng
 */
class BUIScreenFlow extends BUINode implements Iterator {

    protected $flow = null;
    protected $index = 0;
    protected $screens = array();
    protected $nextIndex = null;
    protected $previousIndex = null;
    protected $firstIndex = 0;
    protected $lastIndex = null;
    protected $name = null;
    protected $menus = null;
    protected $currentScreen = null;
    protected $uiNode = null;    

    public function __construct($name, $parent = NULL) {
        $path = "application.application.ui.screenflow." . $name;
        $this->flow = require(Yii::getPathOfAlias($path) . ".php");
        $this->parseScreenFlow($this->flow);
//        $this->gotoFirst(NULL, $style);
    }
    
    public function setUINode($uiNode)
    {
        $this->uiNode = $uiNode;
    }
    
    public function getUINode()
    {
        return $this->uiNode;
    }   

    protected function parseScreenFlow($flow) {
        $this->screens = $flow['screens'];
        $this->lastIndex = count($this->screens) - 1;
        $this->name = $flow['name'];
        $this->menus = $flow['menus'];
    }

    public function renderMenu($config = null, $style = null) {
        foreach ($this->menus as $menuname => $menu) {
            if (isset($menu['visible']) && $menu['visible']) {
                $this->showMenu($menuname, $menu, $config, $style);
            }
        }
    }

    protected function showMenu($menuName, $menu = null, $menuConfig = null) {
        $percent = round(($this->index + 1) / ($this->lastIndex + 1) * 100);
        $viewName = 'screenflow_' . $menuName;
        $viewName = strtolower($viewName);
        $controller = yii::app()->getController();
        $controller->renderPartial($viewName, array('percent' => $percent));
    }

    public function renderContent($config) {
        if (!is_array($config))
            $config = array();

        $config['renderType'] = 'renderPartial';

        $this->currentScreen->render($config);
    }

    public function render($config = null) {
        $this->gotoScreenByIndex($this->index, $config);
    }

    public function gotoScreenByIndex($index = 0, $config = null) {

        $this->index = $index;
        $this->currentScreen = $this->getScreenByIndex($this->index);

        $controller = Yii::app()->getController();
        $controller->render('screenflow', array('flow' => $this, 'index' => $this->index, 'config' => $config));
    }

    public function gotoNext($config = null) {

        $this->nextIndex = $this->index + 1;

        $this->gotoScreenByIndex($this->nextIndex, $config);
    }

    public function gotoFirst($config = null) {
        $this->gotoScreenByIndex($this->firstIndex, $config);
    }

    public function gotoPrevious($config = null) {

        $this->previousIndex = $this->index - 1;

        $this->gotoScreenByIndex($this->previousIndex, $config);
    }

    public function gotoLast($config = null) {
        $this->gotoScreenByIndex($this->lastIndex, $config);
    }

    public function currentScreen($config = null) {
        $this->gotoScreenByIndex($this->index, $config);
    }

    public function getTitle() {
        
    }

    public function getName() {
        return $this->name;
    }

    public function setIndex($index) {
        $this->index = $index;
    }

    public function getIndex() {
        return $this->index;
    }

    public function getScreenByIndex($index) {
        $screen = null;

        if (isset($this->screens[$index])) {
            $screenConfig = $this->screens[$index];
            if (isset($screenConfig['class']))
                $screenClass = $screenConfig['class'];
            else
                $screenClass = 'BScreen' . $screenConfig['name'];

            $screen = new $screenClass();
            $screen->setParent($this);

            return $screen;
        }

        return FALSE;
    }

    public function setPrevious($index) {
        $this->index = $index + 1;
    }

    public function setNext($index) {
        $this->index = $index - 1;
    }

    public function setFirst($index) {
        $this->firstIndex = $index;
    }

    public function setLast($index) {
        $this->lastIndex = $index;
    }

    public function current() {
        $screen = $this->screens[$this->index];
        $screen->setParent($this);
        return $screen;
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        ++$this->index;
    }

    public function previous() {
        --$this->index;
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return isset($this->screens[$this->index]);
    }

    public function setMenu($name, $style) {
        parent::setMenu($name, $style);
    }

    protected function registerMenus($style = NULL) {
        
    }

}

?>
