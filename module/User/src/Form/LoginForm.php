<?php
namespace User\Form;
 
use Zend\Form\Form;
 
class LoginForm extends Form
{
    function __construct($name = null){
        parent::__construct('post');
        $this->setAttribute('method','POST');
        
        $this->add([
            'name'=> 'user_email',
            'type'=>'text',
            'options'=> [
                'label' => 'Email'
            ]
        ]);
        $this->add([
            'name'=> 'user_role',
            'type'=>'text',
            'options'=> [
                'label' => 'Role'
            ]
        ]);
        $this->add([
            'name'=> 'user_status',
            'type'=>'text',
            'options'=> [
                'label' => 'Status'
            ]
        ]);
        $this->add([
            'name'=> 'user_password',
            'type'=>'text',
            'options'=> [
                'label' => 'Password'
            ]
        ]);
        $this->add([
            'name'=>'submit',
            'type'=>'submit',
             'attributes'=>[
                 'value' => 'Save',
                 'id' => 'buttonSave'
             ]
        ]);
    }
}