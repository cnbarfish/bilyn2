<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BAuthItem
 *
 * @author jianfeng
 */
class BAuthItem {
    //put your code here
    private $id = null;
    private $name = null;
    private $app = null;
    private $type = null;
    
    public function __construct($id = null)
    {
        if($id != null)
            $this->load($id);
    }
    
    public function load($id = null)
    {
        if($id != null)
        {
            $this->id = $id;
            $mRole = BMApplicationAuthItem::model()->findByPk($id);
            $this->name = $mRole->authname;
            $this->app = BServiceApp::getInstanceById($mRole->app_id);
            $this->type = BMAuthItemType::model()->findByPk($mRole->authtype)->typename;        
        }
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getAuthType()
    {
        return $this->type;
    }
    
    public function getServiceApp()
    {
        return $this->app;
    }
}

?>
