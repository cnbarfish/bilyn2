
<div class="form">
<?php
$form = $this->beginWidget('CActiveForm', array(
                                'id' => 'register-form',
                                'enableClientValidation' => true,
            //                    'enableAjaxValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
),
));
?>

	<p class="note">
		Fields with<span class="required">*</span>are required.
	</p>

	<div class="row">
	<?php echo $form->labelEx($modelRegister, 'name'); ?>
	<?php echo $form->textField($modelRegister, 'name'); ?>
	<?php echo $form->error($modelRegister, 'name'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($modelRegister, 'email'); ?>
	<?php echo $form->textField($modelRegister, 'email'); ?>
	<?php echo $form->error($modelRegister, 'email'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($modelRegister, 'password'); ?>
	<?php echo $form->passwordField($modelRegister, 'password'); ?>
	<?php echo $form->error($modelRegister, 'password'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($modelRegister, 'password2'); ?>
	<?php echo $form->passwordField($modelRegister, 'password2'); ?>
	<?php echo $form->error($modelRegister, 'password2'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($modelRegister, 'region'); ?>
	<?php echo $form->textField($modelRegister, 'region'); ?>
	<?php echo $form->error($modelRegister, 'region'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($modelRegister,'birthday'); ?>
	<?php //echo $form->textField($model,'check_in_date');
	$this->widget('zii.widgets.jui.CJuiDatePicker',
	array(
          'model'=>$modelRegister,
          'attribute'=>'birthday',        
          'options'=>array(
          					'dateFormat'=>'yy-mm-dd',
	// 			'altField' => '#Reservation_check_in_date',
	//            'altFormat'=>'d M yy',
                            'showAnim'=>'fold',
	//                'beforeShowDay' => 'js:$.datepicker.noWeekends',
            				'defaultDate'=> '1980-01-01',
	//'minDate'=>'1900-01-01',
	//'maxDate'=>'2011-12-31',
                            'changeMonth'=>true,
                            'changeYear'=>true,
							'yearRange'=>'1910:2011',
	),
           'htmlOptions'=>array(
                            'style'=>'height:20px;'
                            ),
                            ));
                            ?>
                            <?php echo $form->error($modelRegister,'check_in_date'); ?>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($modelRegister, 'profile'); ?>
	<?php echo $form->textField($modelRegister, 'profile'); ?>
	<?php echo $form->error($modelRegister, 'profile'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton('Create new account'); ?>
	</div>

	<?php $this->endWidget(); ?>
</div>
<!-- form -->


