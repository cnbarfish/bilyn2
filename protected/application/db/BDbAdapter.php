<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BDbAdapter
 *
 * @author jianfeng
 */
class BDbAdapter {
    
    private $app = null;
    
    public function __construct($app = null) {
        if($app != null)
            $this->app = $app;
    }
    
     public function getOperationById($operationId) {
        $result = array();

        $sql = "select * from bln_application_operation where _id = :OperationId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":OperationId", $operationId, PDO::PARAM_INT);

        $dataReader = $command->query();

        foreach ($dataReader as $row) {
            $result['AppId'] = $row['app_id'];
            $result['OperationName'] = $row['operationname'];
            $result['FunctionName'] = $row['functionname'];
            $result['Description'] = $row['description'];
            $result['OperationData'] = $row['operationdata'];
        }

        return $result;
    }

    public function getRoleId($appId, $roleName) {

        $sql = "select _id from bln_application_authitem where app_id = :appId 
                and authname = :authName";

        $mRole = BMApplicationAuthItem::model()->findBySql($sql, array(':appId' => $appId,
            'authName' => $roleName));

        if ($mRole == null)
            return -1;
        else
            return $mRole->_id;
    }

    public function addServiceApp($serviceId, $appId) {
        //add serviceapp to new service
        $newService_serviceApp = new BMServiceApplication();
        $newService_serviceApp->app_id = $appId;
        $newService_serviceApp->service_id = $serviceId;

        $newService_serviceApp->save();
    }

    public function getServiceAppClass($appId) {

        $sql = "select classname from bln_application where _id = :AppId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":AppId", $appId, PDO::PARAM_INT);

        $appClass = $command->queryScalar();

        return $appClass;
    }

    public function getServiceAppId($classname) {

        $app = null;

        $sql = "select * from bln_application where classname = :ClassName";

        $app = BMServiceApplication::model()->findBySql($sql, array(":ClassName" => $classname));

        if ($app == null)
            return FALSE;
        else {
            $id = $app->_id;
            return $id;
        }
    }

    public function registerServiceApp($meta) {
        $appshowable = true;

        $appname = $meta['appname'];
        $appclass = $meta['appclass'];

        if (isset($meta['showable']))
            $appshowable = $meta['showable'];

        $description = $meta['description'];

        $sql = "insert bln_application(appname,classname,showable,description)values(
            :AppName,:ClassName,:Showable,:Description)";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":AppName", $appname, PDO::PARAM_STR);
        $command->bindParam(":ClassName", $appclass, PDO::PARAM_STR);
        $command->bindParam(":Showable", $appshowable, PDO::PARAM_BOOL);
        $command->bindParam(":Description", $description, PDO::PARAM_STR);

        $retcode = $command->execute();

        $appId = $this->getServiceAppId($appclass);

        if (isset($meta['visible'])) {
            
            $config = $meta['visible'];

            $aId = array('appId' => $appId);

            $config['appId'] = $appId;

            $this->registerVisibility($config, $db);
        }
        return $appId;
    }

    public function getServiceScopeTypeId($scopename) {
        $sql = "select _id from bln_service_scopetype where scopename = :ScopeName";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ScopeName", $scopename, PDO::PARAM_STR);

        return $command->queryScalar();
    }

    public function registerVisibility($config, $conn = null) {
        $sql = "insert bln_service_application_visible(app_id,service_scopetype_id,service_scope_id,apply_rule)
            values(:AppId,:ScopeTypeId,:ScopeId,:ApplyRule)";

        //by default, applyRule = 'exclude'
        $applyRule = 'exclude';

        $appId = $config['appId'];
        $scopeTypeId = $this->getServiceScopeTypeId($config['scopeType']);
        $scopeId = $this->getScopeId($config['scopeType'], $config['scope']);
        $applyRule = $config['applyRule'];

        if ($conn == null)
            $db = Yii::app()->getDb();
        else
            $db = $conn;

        $command = $db->createCommand($sql);

        $command->bindParam(":AppId", $appId, PDO::PARAM_INT);
        $command->bindParam(":ScopeTypeId", $scopeTypeId, PDO::PARAM_INT);
        $command->bindParam(":ScopeId", $scopeId, PDO::PARAM_INT);
        $command->bindParam(":ApplyRule", $applyRule, PDO::PARAM_STR);

        return $command->execute();
    }

    public function getScopeId($scopeType, $scope) {

        if ($scopeType == BServiceApp::SERVICESCOPETYPE) {
            return $scope;
        }

        if ($scopeType == BServiceApp::SERVICETYPESCOPETYPE) {
            return $this->getServiceTypeId($scope);
        }
    }

    public function getServiceTypeId($typeName) {
        return BMServiceType::model()->find("typename=:typeName", array(":typeName" => $typeName))->_id;
    }
    
    public function getServiceCategoryId($categoryName)
    {
        return BMServiceCategory::model()->find("categoryname=:cateName",array(":cateName"=>$categoryName))->_id;
    }

    public function isVisible($serviceId = null,$serviceTypeId = null,$serviceCategoryId = null) {           
     
        $sql = "select t.scopename,service_scope_id,apply_rule 
            from bln_service_application_visible v, bln_service_scopetype t  
                    where v.service_scopetype_id = t._id and 
                    app_id = :AppId and 
                    v.apply_rule = :ApplyRule";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);
        
        $appId = $this->app->getId();
        $applyRule = BServiceApp::INCLUDEAPPLYRULE;

        $command->bindParam(":AppId", $appId, PDO::PARAM_INT);
        $command->bindParam(":ApplyRule", $applyRule, PDO::PARAM_STR);

        $include_rows = $command->query();

        //if have include setting, other in list will be invisible
        //include will work first before exclude
        if ($include_rows != null) {          
            foreach ($include_rows as $row) {
                if ($row['scopename'] == BServiceApp::SERVICETYPESCOPETYPE) {
                    if ($serviceTypeId == $row['service_scope_id']) {
                        return TRUE;
                    }
                }

                if ($row['scopename'] == BServiceApp::SERVICESCOPETYPE) {
                    if ($serviceId == $row['service_scope_id'])
                        return TRUE;
                }
                
                 if ($row['scopename'] == BServiceApp::SERVICECATEGORYSCOPETYPE) {
                    if ($serviceCategoryId == $row['service_scope_id'])
                        return TRUE;
                }
            }
            return FALSE;
        }

        $command->bindParam(":ApplyRule", BServiceApp::EXCLUDEAPPLYRULE, PDO::PARAM_STR);

        $exclude_rows = $command->query();

        //if exist exclude list, other will be visible
        //if have include, exclude do not work
        if ($exclude_rows != null) {

            foreach ($exclude_rows as $row) {
                if ($row['scopename'] == BServiceApp::SERVICETYPESCOPETYPE) {
                    if ($serviceTypeId == $row['service_scope_id'])
                        return FALSE;
                }

                if ($row['scopename'] == BServiceApp::SERVICESCOPETYPE) {
                    if ($serviceId == $row['service_scope_id'])
                        return FALSE;
                }
                
                 if ($row['scopename'] == BServiceApp::SERVICECATEGORYSCOPETYPE) {
                    if ($serviceCategoryId == $row['service_scope_id'])
                        return FALSE;
                }
            }
        }

        //by default, return true
        return TRUE;
    }    
    
    

}

?>
