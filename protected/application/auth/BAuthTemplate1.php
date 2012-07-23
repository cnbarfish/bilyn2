<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BAuthTemplate1
 *
 * @author jianfeng
 */
class BAuthTemplate1 {
    //put your code here

    const WORKTEAMADMIN = "workteam_admin";
    const SERVEDTEAMADMIN = 'servedteam_admin';
    const WORKTEAMMEMBER = 'workteam_member';
    const SERVEDTEAMMEMBER = 'servedteam_member';
    const APPADMIN = "app_admin";
    const APPMEMBER = "app_member";
    const APPSUPER = "app_super";

    public $appAdmin = null;
    public $workTeamAdmin = null;
    public $servedTeamAdmin = null;
    public $appMember = null;
    public $workTeamMember = null;
    public $servedTeamMember = null;
    public $appSuper = null;

    public function __construct() {
        $this->workTeamAdmin = array(
            'name' => self::WORKTEAMADMIN,
            'type' => BAuthManager::WORKTEAMADMINROLE            
        );
        $this->servedTeamAdmin = array(
            'name' => self::SERVEDTEAMADMIN,
            'type' => BAuthManager::SERVEDTEAMADMINROLE
        );

        $this->workTeamMember = array(
            'name' => self::WORKTEAMMEMBER,
            'type' => BAuthManager::WORKTEAMMEMBERROLE            
        );
        
        $this->servedTeamMember = array(
            'name' => self::SERVEDTEAMMEMBER,
            'type' => BAuthManager::SERVEDTEAMMEMBERROLE
        );

        $this->appMember = array(
            'name' => self::APPMEMBER,
            'type' => BAuthManager::MIXEDTYPEOFROLE,
            self::WORKTEAMMEMBER => $this->workTeamMember,
            self::SERVEDTEAMMEMBER => $this->servedTeamMember
        );

        $this->appAdmin = array(
            'name' => self::APPADMIN,
            'type' => BAuthManager::MIXEDTYPEOFROLE,
            self::WORKTEAMADMIN => $this->workTeamAdmin,
            self::SERVEDTEAMADMIN => $this->servedTeamAdmin
        );

        $this->appSuper = array(
            'name' => self::APPSUPER,
            'type' => BAuthManager::MIXEDTYPEOFROLE,
            self::WORKTEAMADMIN => $this->workTeamAdmin,
            self::SERVEDTEAMADMIN => $this->servedTeamAdmin,
            self::WORKTEAMMEMBER => $this->workTeamMember,
            self::SERVEDTEAMMEMBER => $this->servedTeamMember
        );
    }

}

?>
