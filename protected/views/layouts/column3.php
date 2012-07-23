<?php $this->beginContent('/layouts/main2'); ?>
<div class="container" style="min-height: 500px;">
    <div class="span2">
        <div id="leftbar" style="min-height: 500px;">	

            <?php
            $leftMenu = Blyn::app()->getAppUI()->getMenu(BUIApp::LEFTMENU);
            //$leftMenu = Blyn::app()->getAppUI()->getMenu('leftMenu');
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type' => 'list',
                'items' => $leftMenu['items']))
            ?>

        </div>
        <!-- sidebar -->
    </div>
    <div class="span7">
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="span2">
        <div id="sidebar">side bar</div>
        <!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>