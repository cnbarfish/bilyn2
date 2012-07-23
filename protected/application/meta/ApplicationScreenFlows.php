<?php

return array(
    'createService' => array(
        'screens' => array(
            'serviceDefinition' => array(
                'title' => "服务定义",
                'view' => 'service_definition',
                'data' => 'data used in view'
            ),
            'serviceTeam' => array(
                'title' => "配置服务团队",
                'view' => 'service_application',
                'data' => 'data used in view'
            ),
            'serviceApplication' => array(
                'title' => "配置应用",
                'view' => 'config_application',
                'data' => 'data used in view'
            ),
            'serviceMember' => array(
                'title' => "添加成员",
                'view' => 'complete_application',
                'data' => 'data used in view'
            ),
            'complete' => array(
                'title' => "完成服务创建",
                'view' => 'complete_application',
                'data' => 'data used in view'
            )          
        ),
        'screenSequence' => array('serviceDefinition', 'serviceTeam', 'serviceApplication', 'serviceMember','complete')
    ),
);