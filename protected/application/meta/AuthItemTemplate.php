<?php

return array(
    'CoreServiceApp' => array(
        'admin' => array(
            'workTeamAdmin' => array(
                'operations'=>'all'
            ),
            'servedTeamAdmin' => array(
                'operations'=>'all'
            )
        ),
        'member' => array(
            'operations' => array(
                'loadService' => "loadService",
            ),
            'workTeamMember' => array(
                'operations' => array(),
                'authItemsForManageService' => array(
                    'operation' => array()
                )
            ),
            'servedTeamMember' => array(
                'operations' => array()
            )
    )));
?>
