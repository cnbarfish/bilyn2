
                    <div class="form">
                    <?php
                        $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'login-form',
                                    'enableClientValidation' => true,
                //                    'enableAjaxValidation' => true,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                    ),
                                ));
                    ?>

                        <p class="note">Fields with<span class="required">*</span>are required.</p>

                        <div class="row">
                        <?php echo $form->labelEx($modelLogin, 'email'); ?>
                        <?php echo $form->textField($modelLogin, 'email'); ?>
                        <?php echo $form->error($modelLogin, 'email'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($modelLogin, 'password'); ?>
                        <?php echo $form->passwordField($modelLogin, 'password'); ?>
                        <?php echo $form->error($modelLogin, 'password'); ?>
                    </div>

                    <div class="row rememberMe">
                        <?php echo $form->checkBox($modelLogin, 'rememberMe'); ?>
                        <?php echo $form->label($modelLogin, 'rememberMe'); ?>
                        <?php echo $form->error($modelLogin, 'rememberMe'); ?>
                    </div>

                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Login'); ?>
                    </div>

                    <?php $this->endWidget(); ?>
                </div><!-- form -->

