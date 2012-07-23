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
class BAppDb {

    public function createUser($username, $email, $password, $birthday, $profile) {
        $mUser = new BMUser();
        return $mUser->register($username, $email, $password, $birthday, $profile);
    }

    public function getPersonalService($userId) {

        $services = $this->fetchUserServices($userId);

        foreach ($services as $service) {
            if ($service->getServiceType() == BService::PERSONALSERVICETYPE)
                return $service;
        }

        return FALSE;
    }

    /**
     *
     * @param type $userId
     * @param type $type, include workteam_admin, workteam_member,servedteam_admin,servedteam_member
     */
    protected function fetchUserServices($userId) {

        $services = array();

        $sql = "select service_id from bln_service_application_authitem_user u, bln_application_authitem a, 
            bln_authitem_type t where 
            user_id = :UserId and u.authitem_id = a._id and a.authtype = t._id and t.typename = :AuthType";

        $sql1 = "select service_id from bln_service_application_authitem_user where user_id = :UserId";
        $sql2 = "select service_id from bln_service_application_circle c, bln_service_application_circle_user u
            where u.user_id = :UserId and c._id = service_application_circle_id";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql1);

        $command->bindParam(":UserId", $userId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $serviceId = intval($row['service_id']);
            $service = new BService($serviceId);
            $services[$serviceId] = $service;
        }

        $command = $db->createCommand($sql2);

        $command->bindParam(":UserId", $userId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $serviceId = intval($row['service_id']);
            $service = new BService($serviceId);
            $services[$serviceId] = $service;
        }

        return $services;
    }

    public function getUserServices($userId, $type) {
        $retServices = array();
        $services = $this->fetchUserServices($userId, $type);

        foreach ($services as $id => $service) {
            if ($service->getServiceType() != BService::PERSONALSERVICETYPE)
                $retServices[$id] = $service;
        }

        return $retServices;
    }

    public function getUserCircles($serviceId, $appId, $userId) {
        $circles = array();

        /*
          $sql = "select c._id from bln_servicecircle c, bln_servicecircle_user u
          where u.user_id = :UserId and c.service_id = :ServiceId";
         */

        $sql = "select ac._id,ac.service_id,ac.app_id from bln_application_circle ac, bln_service_application_circle_user cu 
            where ac._id = cu.application_circle_id and cu.service_id = :ServiceId
            and cu.user_id = :UserId and ac.app_id = :AppId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":UserId", $userId, PDO::PARAM_INT);
        $command->bindParam(":AppId", $appId, PDO::PARAM_INT);
        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);

        $circleRows = $command->queryAll();

        foreach ($circleRows as $circleRow) {

            if ($circleRow[1] == $serviceId && $circleRow[2] == $appId) {

                $circle = new BCircle($circleRow[0]);

                $circles[$circleRow[0]] = $circle;

                $this->getParentCircles($circleId, $circles);
            }
        }

        return $circles;
    }

    protected function getParentCircles($circleId, &$circles) {
        //   $circles = array();

        $sql = "select parent_id from bln_service_application_circle_child where child_id = :ChildId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ChildId", $circleId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {

            $circleId = $row[0];

            if ($circleId != null) {
                $circles[$circleId] = new BCircle($circleId);
                $this->getParentCircle($circleId, $circles);
            }
        }
    }

    public function getChildAuthItems(&$childRoles, $serviceId, $authItemId) {

        $sql = "select child_id from bln_application_authitem_child where 
            parent_id = :ParentId";

        $sql2 = "select  child_authitem_id from bln_service_authitem_child where 
            parent_authitme_id = :ParentId";


        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ParentId", $authItemId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $childRoles[$row[0]] = new BAuthItem($row[0]);
            $this->getChildAuthItems($childRoles, $serviceId, $row[0]);
        }

        $command2 = $db->createCommand($sql2);

        $command2->bindParam(":ParentId", $authItemId, PDO::PARAM_INT);
        $command2->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);


        $dataReader2 = $command2->queryAll();

        foreach ($dataReader2 as $row) {
            $childRoles[$row[0]] = new BAuthItem($row[0]);
            $this->getChildAuthItems($childRoles, $serviceId, $row[0]);
        }
    }

    public function addChildRole($parentId, $childId) {
        $sql = "insert into bln_application_authitem_child(parent_id,child_id)
            values(:ParentId,:ChildId)";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ParentId", $parentId, PDO::PARAM_INT);
        $command->bindParam(":ChildId", $childId, PDO::PARAM_INT);

        return $command->execute();
    }

    public function addOperationToRole($operationId, $roleId) {
        $sql = "insert into bln_application_authitem_operation(authitem_id,operation_id)
            values(:RoleId,:OperationId)";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":RoleId", $roleId, PDO::PARAM_INT);
        $command->bindParam(":OperationId", $operationId, PDO::PARAM_INT);

        return $command->execute();
    }

    public function assignUserRole($serviceId, $userId, $roleId) {
        $sql = "insert into bln_service_application_authitem_user(service_id,authitem_id,user_id)
            values(:ServiceId,:RoleId,:UserId)";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        $command->bindParam(":RoleId", $roleId, PDO::PARAM_INT);
        $command->bindParam(":UserId", $userId, PDO::PARAM_INT);

        return $command->execute();
    }

    public function assignCircleRole($serviceId, $circleId, $roleId) {
        $sql = "insert into bln_service_application_authitem_circle(service_id,authitem_id,circle_id)
            values(:ServiceId,:RoleId,:CircleId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        $command->bindParam(":RoleId", $roleId, PDO::PARAM_INT);
        $command->bindParam(":CircleId", $circleId, PDO::PARAM_INT);

        return $command->execute();
    }

    public function addServiceChildRole($serviceId, $parentRoleId, $childRoleId) {
        $sql = "insert into bln_service_authitem_child(service_id,parent_authitem_id,child_authitem_id)
            values(:ServiceId,:ParentId,:ChildId)";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        $command->bindParam(":ParentId", $parentId, PDO::PARAM_INT);
        $command->bindParam(":ChildId", $childId, PDO::PARAM_INT);

        return $command->execute();
    }

    public function getServiceTypeId($typeName) {
        return BMServiceType::model()->find("typename=:typeName", array(":typeName" => $typeName))->_id;
    }

    public function getServiceIdByName($serviceName) {
        $service = BMService::model()->findBySql("select * from bln_service where servicename=:ServiceName", array(':ServiceName' => $serviceName));

        return $service->_id;
    }

    public function createService($serviceName, $serviceType = BService::NORMALSERVICETYPE, $serviceCategory = BService::UNKNOWNCATEGORY) {

        $typeId = null;
        $categoryId = null;

        $conn = Yii::app()->db;

        $transaction = $conn->beginTransaction();
        try {

            $insertServiceSql = "insert into bln_service(servicename) values(:ServiceName)";
            $insertServiceTypeSql = "insert into bln_service_servicetype(service_id,servicetype_id) values(:ServiceId,:ServiceTypeId)";
            $insertServiceCategorySql = "insert into bln_service_servicecategory(service_id,servicecategory_id) values(:ServiceId,:ServiceCategoryId)";

            //insert service
            $command1 = $conn->createCommand($insertServiceSql);
            $command1->bindParam(":ServiceName", $serviceName, PDO::PARAM_STR);
           
            $command1->execute();

            $sql = 'select _id from bln_service where servicename = :ServiceName';

            $newServiceId = $conn->createCommand($sql)->queryScalar(array(':ServiceName' => $serviceName));

            //insert servicetype

            $sql = "select _id from bln_servicetype where typename = :ServiceType";

            if (is_string($serviceType))
                $typeId = $conn->createCommand($sql)->queryScalar(array(':ServiceType' => $serviceType));

            if (is_numeric($serviceType)) {
                $typeId = $serviceType;
            }
            $command2 = $conn->createCommand($insertServiceTypeSql);

            $command2->bindParam(":ServiceId", $newServiceId, PDO::PARAM_INT);
            $command2->bindParam(":ServiceTypeId", $typeId, PDO::PARAM_INT);

            $command2->execute();

            //insert servicecategory

            $sql = "select _id from bln_servicecategory where categoryname = :ServiceCategory";

            if (is_string($serviceCategory))
                $categoryId = $conn->createCommand($sql)->queryScalar(array(':ServiceCategory' => $serviceCategory));

            if (is_numeric($serviceCategory))
                $categoryId = $serviceCategory;         

            $command3 = $conn->createCommand($insertServiceCategorySql);

            $command3->bindParam(":ServiceId", $newServiceId, PDO::PARAM_INT);
            $command3->bindParam(":ServiceCategoryId", $categoryId, PDO::PARAM_INT);

            $command3->execute();

            //.... other SQL executions
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }

      return $newServiceId;
    }

    public function getServiceType($serviceId) {
        $sql = "select typename from bln_servicetype t,bln_service_servicetype s
             where t._id = s.servicetype_id and s.service_id = :ServiceId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);

        $typename = $command->queryScalar();

        return $typename;
    }

    public function getServiceApps($serviceId) {
        $apps = array();

        $sql = "select app_id from bln_service_application where service_id = :ServiceId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $appClass = $this->getServiceAppClass($row[0]);
            $apps[$row[0]] = new $appClass;
        }

        return $apps;
    }

    public function getServiceAppRoles($appId) {
        $sql = "select * from bln_application_authitem where app_id = :AppId";

        $roles = array();

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":AppId", $appId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $roles[$row[0]] = new BAuthItem($row[0]);
        }

        return $roles;
    }

    public function getUserRoles($userId, $serviceId, $appId) {
        $roles = array();

        $sql = "select * from bln_service_application_authitem_user where app_id = :AppId
             and service_id = :ServiceId and user_id = :UserId";

        $roles = array();

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":AppId", $appId, PDO::PARAM_INT);
        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        $command->bindParam(":UserId", $userId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $roles[$row[0]] = new BAuthItem($row[0]);
        }

        $circles = $this->getUserCircles($serviceId, $appId, $userId);

        foreach ($circles as $circle) {
            array_merge($roles, $this->getCircleRoles($circle->getId(), $serviceId, $appId));
        }

        return $roles;
    }

    public function getCircleRoles($circleId, $serviceId, $appId) {
        $sql = "select a._id from bln_service_application_authitem_circle a, bln_service_application_circle c 
             where c.app_id = :AppId  and c.service_id = :ServiceId and c._id = a.applicationcircle_id 
             and a.applicationcircle_id = :CircleId";

        $roles = array();

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":AppId", $appId, PDO::PARAM_INT);
        $command->bindParam(":ServiceId", $serviceId, PDO::PARAM_INT);
        $command->bindParam(":CircleId", $userId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $roles[$row[0]] = new BAuthItem($row[0]);
        }

        return $roles;
    }

    public function getOperations($role) {
        $operations = array();

        $sql = "select * from bln_application_authitem_operation where 
             authitem_id = :RoleId";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":RoleId", $appId, PDO::PARAM_INT);

        $dataReader = $command->queryAll();

        foreach ($dataReader as $row) {
            $operations[$row[2]] = new BOperation($row[2]);
        }

        return $operations;
    }

    public function getRoleTypeId($typeName) {
        $sql = "select _id from bln_authitem_type where 
             typename = :TypeName";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":TypeName", $typeName, PDO::PARAM_STR);

        return $command->queryScalar();
    }

    public function createRole($appId, $name, $type) {
        $mRole = new BMApplicationAuthItem;

        $typeId = $this->getRoleTypeId($type);

        $mRole->authname = $name;
        $mRole->authtype = $typeId;
        $mRole->app_id = $appId;

        $mRole->save();

        return $mRole->_id;
    }

    public function getServiceScopeTypeId($scopename) {
        $sql = "select _id from bln_service_scopetype where scopename = :ScopeName";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $command->bindParam(":ScopeName", $scopename, PDO::PARAM_STR);

        return $command->queryScalar();
    }

    public function getVisibleServiceApps($service = null, $serviceType = null, $serviceCategory = null) {

        $apps = array();

        $sql = "select _id from bln_application";

        $db = Yii::app()->getDb();

        $command = $db->createCommand($sql);

        $rows = $command->query();

        foreach ($rows as $row) {

            $app = BServiceApp::getInstanceById($row['_id']);

            if ($app->isVisible($service, $serviceType, $serviceCategory))
                array_push($apps, $app);
        }

        return $apps;
    }

}

?>
