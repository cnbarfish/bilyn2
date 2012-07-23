<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BAuthManager
 *
 * @author jianfeng
 */
class BAuthManager {
    //put your code here 

    const WORKTEAMADMINROLE = "workteam_admin";
    const SERVEDTEAMADMINROLE = 'servedteam_admin';
    const WORKTEAMMEMBERROLE = 'workteam_member';
    const SERVEDTEAMMEMBERROLE = 'servedteam_member';
    const MIXEDTYPEOFROLE = "service_mixed";
    const NONEDEFINEDROLE = "service_none";

    private $app = null;
    private $appId = null;

    public function __construct($serviceApp) {
        $this->app = $serviceApp;
        $this->appId = $this->app->getId();
    }

    // public function checkAccess($operation, $userId);   

    public function addChildRole($parent, $child) {

        $parentId = $parent->getId();
        $childId = $child->getId();

        $db = Blyn::app()->getAppDb();

        $db->addChildRole($parentId, $childId);
    }

    public function addOperationToRole($role, $operations) {

        $db = Blyn::app()->getAppDb();

        foreach ($operations as $operation) {

            $db->addOperationtoRole($operation->getId(), $role->getId());
        }
    }

    public function assignUserToRole($service, $user, $role) {

        $db = Blyn::app()->getAppDb();

        $db->assignUserRole($service->getId(), $user->getId(), $role->getId());
    }

    public function assignCircleToRole($service, $circle, $role) {
        $db = Blyn::app()->getAppDb();

        $db->assignCircleRole($service->getId(), $user->getId(), $role->getId());
    }

    public function getRoles($serviceApp) {

        $db = Blyn::app()->getAppDb();

        $roles = $db->getServiceAppRoles($appId);

        return $roles;
    }

    public function getRole($name) {
        $mRole = BMApplicationAuthItem::model()->findBySql("select * from bln_application_authitem 
            where authname = :AuthName", array(":AuthName" => $name));

        $role = new BAuthItem($mRole->_id);
        
        return $role;
    }

    public function createRole($name, $type) {
        
        $db = Blyn::app()->getAppDb();

        $roleId = $db->createRole($this->appId, $name, $type);
        
        return new BAuthItem($roleId);
    }

    public function getUserRoles($user, $service) {

        $userRoles = array();

        $db = Blyn::app()->getAppDb();

        $roles = $db->getUserRoles($user->getId, $service->getId(), $this->appId);

        array_merge($userRoles, $roles);
    }

    public function getUserCircles($user) {
        return Blyn::app()->getAppDb()->getUserCircles($serviceId, $userId);
    }

    public function getCircleRoles($circle, $serviceApp, $service = null) {

        $serviceId = null;

        if ($service != null)
            $serviceId = $service->getId();

        return Blyn::app()->getAppDb()->getCircleRoles($circle->getId(), $serviceId, $serviceApp->getId());
    }

    public function getUserOperations($user, $service, $roleType) {
        $operations = array();

        $roles = $this->getUserRoles($user, $service);

        $db = Blyn::app()->getAppDb();

        foreach ($roles as $role) {
            if ($role->getAuthType == $roleType) {
                array_merge($operations, $this->getRoleOperation($role));
            }

            $childRoles = $this->getChildRoles($service, $role);

            foreach ($childRoles as $role) {
                if ($role->getAuthType == $roleType) {
                    array_merge($operations, $this->getRoleOperation($service, $role));
                }
            }
        }

        return $operations;
    }

    public function addServiceChildRole($service, $parentRole, $childRole) {
        $db = Blyn::app()->getAppDb();

        $db->addServiceChildRole($service->getId(), $parentRole->getId(), $childRole->getId());
    }

    public function createRecursiveRole($role) {
        $roleType = $role['type'];
        $roleName = $role['name'];

        $operations = array();

        if (isset($role['operations'])) {
            $ops = $role['operations'];
            foreach ($ops as $opName => $funcName) {
                $operation = new BMApplicationOperation();
                $operation->operationname = $opName;
                $operation->functionname = $funcName;
                $operation->save();
                array_push($operations, $operation);
            }
        }

        $newRole = $this->createRole($roleName, $roleType);
        $this->addOperationToRole($newRole, $operations);

        foreach ($role as $name => $value) {
            if ($name != 'operations' && is_array($value)) {
                $childRole = $this->getRole($name);
                $this->addChildRole($newRole, $childRole);
            }
        }

        return $newRole;
    }

    private function getRoleOperation($role) {

        $db = Blyn::app()->getAppDb();

        return $db->getOperations($role);
    }

    private function getChildRoles($service, $role) {

        $childRoles = array();

        $db = Blyn::app()->getAppDb();

        return $db->getChildAuthItems($childRoles, $service->getId(), $role->getId());
    }
    
    

}

?>
