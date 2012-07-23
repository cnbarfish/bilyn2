<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BOperation
 *
 * @author jianfeng
 */
class BOperation {
    //put your code here
    private $name = null;
    private $functionName = null;
    private $id = null;
    private $appId = null;
    private $description = null;
    private $operationData = null;
    
    public function __construct($operationId = null)
    {
        if($operationId != null)
            $this->load($operationId);
    }
    
    public function getOperationName()
    {        
        return $this->name;
    }
    
    /**
     *load will get data from db
     * @param type $operationId 
     */
    public function load($operationId)
    {
        $db = new BDbAdapter();
        
        $result = $db->getOperationById($operationId);
        
        $this->appId = $result['AppId'];
        $this->id = $operationId;
        $this->name = $result['OperationName'];
        $this->functionName = $result['FunctionName'];
        $this->description = $reult['Description'];
        $this->operationData = $result['OperationData'];
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getApp()
    {
        return new BService($this->appId);
    }
    
    public function getFunctionName()
    {
        return $this->functionName;
    }
}

?>
