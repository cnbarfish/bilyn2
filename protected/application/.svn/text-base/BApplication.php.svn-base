<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BApplication
 *
 * @author jianfeng
 */
class BApplication {

    //put your code here

    private $currentUser = null;
    private $db = null;
    private $appUi = null;
    private $style = null;

    /**
     *
     * @return BUser
     */
    public function getCurrentUser() {
        if ($this->currentUser == null)
            $this->currentUser = new BUser();

        return $this->currentUser;
    }

    /**
     *
     * @return BAppDb
     */
    public function getAppDb() {
        if ($this->db == null)
            $this->db = new BAppDb ();

        return $this->db;
    }

    /**
     *
     * @return BUIApp
     */
    public function getAppUI() {
        if ($this->appUi == null)
            $this->appUi = new BUIApp ();

        return $this->appUi;
    }
}

?>
