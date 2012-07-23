<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BCircle
 * BCircle class used to handle tasks like add user, delete user and so on
 * @author jianfeng
 */
class BCircle {

    const NEWCIRCLE = 1001;

    protected $members;

    public function __construct($circleId = null, $config = null) {
        if ($circleId != null) {
            if ($cicleId == self::NEWCIRCLE) {
                $this->createNewCircle($config);
            }
            else
                $this->loadCircle($circleId);
        };
    }

    public function addUser($userId) {
        
    }
    
    public function loadCircle($circleId)
    {
        
    }

    public function createNewCircle($config) {
        $db = Blyn::app()->getAppDb();

        $tran = $config['Transaction'];
        $newCircleId = null;

        $dbconfig = array();
        $dbconfig["CircleName"] = $config["CircleName"];

        $newCircleId = $db->doTransactionItem(BDb::NEWCIRCLE, $dbconfig, $tran);
        
        if($newCircleId > 0)
        {
            return $this->loadCircle($newCircleId);
        }
        
        return false;
    }

}

?>
