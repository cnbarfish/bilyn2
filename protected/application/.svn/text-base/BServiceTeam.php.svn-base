<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BServiceTeam
 * this class will handle all operation related to circle inside team
 *
 * @author jianfeng
 */
class BServiceTeam {
    /*
     * $rootCircle is the biggest circle for service team, it is a instance of BCircle
     * $circles is a collection inside serviceteam
     */

    const NEWSERVICETEAM = 'newserviceteam';
    const WORKTEAMTYPE = "workteam";
    const SERVEDTEAMTYPE = "servedteam";

    protected $rootCircle = null;
    protected $circles = null;

    public function __construct($serviceTeamId = null, $config = null) {
        if ($serviceTeamId != null) {
            if ($serviceTeamId == BServiceTeam::NEWSERVICETEAM) {
                $this->createNewTeam($config);
            }
            else
                $this->loadServiceTeam($serviceTeamId);
        };
    }
    
    public function loadServiceTeam($teamId)
    {}

    public function createNewTeam($config) {
        $db = Blyn::app()->getAppDb();

        $tran = $config['Transaction'];
        $service = $config['Service'];
        $teamType = $config['TeamType'];

        $config['CircleName'] = "CircleOf" . $service->name . "_" . $teamType;

        $newCircle = new BCircle(BCircle::NEWCIRCLE, $config);

        if (!$newCircle)
            return false;
        else {

            $this->$rootCircle = $newCircle;

            $dbconfig = array();
            $dbconfig["TeamType"] = $config["TeamType"];
            $dbconfig["ServiceId"] = $config["ServiceId"];
            $dbconfig["CircleId"] = $this->rootCircle->getId();

            $newTeamId = $db->doTransactionItem(BDb::NEWSERVICETEAM, $dbconfig,$tran);
            
            if($newTeamId > 0)
                return $this->loadServiceTeam($newTeamId);
            else
                return false;            
        }
    }

    public function addUser($userId) {
        $this->rootCircle->addUser($userId);
    }

}

?>
