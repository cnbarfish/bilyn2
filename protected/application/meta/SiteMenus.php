<?php
return array(
	'mainMenu'=>array(
		'items'=>array(
		array('label'=>'My Space','url'=>array('site/index')),
		array('label'=>'Service Map','url'=>array('site/serviceMap')),
		array('label'=>'logout('.Yii::app()->user->name.')',
		  			'url'=>array('/site/logout')))
	),
	'leftMenu'=>array(
		'items'=>array(		
		array('label'=>'My Space'),
		array('label'=>'My Message','url'=>array('#')),
		array('label'=>'My Circle','url'=>array('#')),
		array('label'=>'My Working Service'),
		array('label'=>'新建服务','url'=>array('service/createService')),
		array('label'=>'The Dew','url'=>array('#')),
		array('label'=>'Hot Restuarant','url'=>array('#')),
		array('label'=>'My Intrest Service'),
		array('label'=>'The travel Agent','url'=>array('#')),
		array('label'=>'GoGo play','url'=>array('#')),
	))
);