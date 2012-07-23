<?php 
$this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs'=>array(
          'Login' =>$this->renderPartial("_formLogin", array('modelLogin' => $modelLogin), $this),
          'Register'=>$this->renderPartial("_formRegister", array('modelRegister' => $modelRegister), $this),
        ),        
        'options'=>array(
            'collapsible'=>true,
        ),
    ));
?>