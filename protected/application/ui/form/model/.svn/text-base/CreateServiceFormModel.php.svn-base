<?php

/**
 * CreateServiceForm class.
 * CreateForm is the data structure for keeping
 * createservice form data. It is used by the 'login' action of 'SiteController'.
 */
class CreateServiceFormModel extends CFormModel {

    public $serviceId;
    public $serviceName;
    public $serviceCategory;
    public $serviceApps;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('serviceName, serviceCategory', 'required', 'on' => 'CreateService'),
            array('serviceApps', 'required', 'on' => 'AddServiceApplication'),
                // array('serviceApps', 'required'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'serviceName' => 'Service Name',
            'serviceCategory' => 'Service Category',
            'serviceApps' => 'Service Applications',
        );
    }

}
