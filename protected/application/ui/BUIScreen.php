<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUIManager
 *
 * @author jianfeng
 */
abstract class BUIScreen extends BUIBase {

    protected $parent = null;
    protected $uiNode = null;

    public function __construct($parent = NULL) {
        if ($parent != null)
            $this->parent = $parent;
    }

    /**
     *
     * @return BUINode 
     */
    public function getUINode() {
        if ($this->parent instanceof BUIScreenFlow)
            return $this->parent->getUINode();

        return $this->parent;
    }

    /**
     *
     * @param type $uiNode 
     */
    public function setUINode($uiNode) {
        if ($this->parent instanceof BUIScreenFlow)
            $this->parent->setUINode($uiNode);
        else {
            $this->parent = $uiNode;
        }
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function renderView($view = null, $data = NULL, $config = null) {
        $controller = Yii::app()->getController();

        if (isset($config['renderType'])) {
            $rType = strtolower($config['renderType']);
            if ($rType == 'renderpartial') {
                $controller->renderPartial($view, $data);
                return;
            }
        }
        //$controller->render($view, array('screen'=>$this,'data'=>$data));
        $data['screen'] = $this;
        //yii::app()->setViewPath($this->getViewPath());        
        $controller->render('screen', array('view' => $view, 'data' => $data));
    }

    public abstract function render($config = null);

    public function getName() {
        $className = get_class($this);
        $screenName = substr($className, 7);
        return $screenName;
    }

    public function getScreenFlowIndex() {
        if ($this->parent instanceof BUIScreenFlow) {
            return $this->parent->getIndex();
        }

        return 0;
    }

    public function registerMenus($style = NULL) {
        ;
    }

}

?>
