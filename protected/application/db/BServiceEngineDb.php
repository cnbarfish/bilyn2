<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BDb
 *
 * @author jianfeng
 */
class BServiceEngineDb extends BDbAdapter {

    public function getServiceType($serviceId) {
        $sql = "select typename from bln_servicetype t,bln_service_servicetype s
             where t._id = s.servicetype_id and s.service_id = :ServiceId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);

        $typename = $command->queryScalar();

        return $typename;
    }

    public function getServiceCategory($serviceId) {
        $sql = "select categoryname from bln_servicecategory c,bln_service_servicecategory s
             where c._id = s.servicecategory_id and s.service_id = :ServiceId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);

        $categoryname = $command->queryScalar();

        return $categoryname;
    }

    public function getServiceApps($serviceId) {
        $apps = array();

        $sql = "select app_id from bln_service_application where service_id = :ServiceId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $appClass = $this->getServiceAppClass($row['app_id']);
            // $app = new $appClass;
            // $app->load($row['app_id']);
            $apps[$row['app_id']] = new $appClass;
        }

        return $apps;
    }

    public function setServiceVisible($serviceId, $visible = TRUE) {
        $sql1 = "select visible from bln_service_visible where service_id = :ServiceId";
        $sql2 = "insert bln_service_visible(service_id,visible)values(:ServiceId,:Visible)";
        $sql3 = "update bln_service_visible set visible=:Visible where service_id = :ServiceId";
        
        if($visible != FALSE)
            $visible = TRUE;

        $db = Yii::app()->getDb();

        $command1 = $db->createCommand($sql1);
        $command1->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);

        $command2 = $db->createCommand($sql2);
        $command2->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        $command2->bindParam(":Visible", $visible, PDO::PARAM_BOOL);

        $command3 = $db->createCommand($sql3);
        $command3->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        $command3->bindParam(":Visible", $visible, PDO::PARAM_BOOL);

        if ($serviceId != NULL) {
            if (!$command1->queryRow()) {
                //insert
                $command2->execute();
            } else {
                //update
                $command3->execute();
            }
        }
    }
    
    public function getServiceVisible($serviceId)
    {
        $sql1 = "select visible from bln_service_visible where service_id = :ServiceId";
        
        $db = Yii::app()->getDb();

        $command1 = $db->createCommand($sql1);
        $command1->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        
        if(!$command1->queryRow())
            return TRUE;
        
        return $command1->queryScalar();        
    }
}

?>