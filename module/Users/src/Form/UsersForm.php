<?php


namespace Users\Form;

use Zend\Form\Form;

class UsersForm extends Form {
    function __construct($name = null){
        parent::__construct('post');
        $this->setAttribute('method','POST');
        $this->add([
            'name'=> 'id',
            'type'=>'hidden'
        ]);
        $this->add([
            'name'=> 'Name',
            'type'=>'text',
            'options'=> [
                'label' => 'Name'
            ]
        ]);
        $this->add([
            'name'=> 'Telephone',
            'type'=>'text',
            'options'=> [
                'label' => 'Telephone'
            ]
        ]);
        $this->add([
            'name'=> 'Email',
            'type'=>'text',
            'options'=> [
                'label' => 'Email'
            ]
        ]);
        $this->add([
            'name'=> 'Password',
            'type'=>'text',
            'options'=> [
                'label' => 'Password'
            ]
        ]);
        $this->add([
            'name'=> 'RoleId',
            'type'=>'text',
            'options'=> [
                'label' => 'RoleId'
            ]
        ]);
        $this->add([
            'name'=> 'title',
            'type'=>'text',
            'options'=> [
                'label' => 'Title'
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