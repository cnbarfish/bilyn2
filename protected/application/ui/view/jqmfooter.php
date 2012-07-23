<?php
//register css for footer_navbar
$baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.application.ui.view.assets')) . '/jqmobile';
Yii::app()->getClientScript()->registerCssFile($baseUrl . '/jqm.css');
?>
<div data-role="footer"> 
    <div data-role="navbar">
        <ul>
            <li><a href="#">One</a></li>
            <li><a href="#">Two</a></li>
            <li><a href="#">Three</a></li>
        </ul>
    </div><!-- /navbar -->

