<?php


namespace Products\Form;

use Zend\Form\Form;

class ProductsForm extends Form {
    function __construct($name = null){
        parent::__construct('post');
        $this->setAttribute('method','POST');
        $this->add([
            'name'=> 'Id',
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
            'name'=> 'title',
            'type'=>'text',
            'options'=> [
                'label' => 'Title'
            ]
        ]);
        $this->add([
            'name'=> 'Size',
            'type'=>'text',
            'options'=> [
                'label' => 'Size'
            ]
        ]);
        $this->add([
            'name'=> 'Color',
            'type'=>'text',
            'options'=> [
                'label' => 'Color'
            ]
        ]);
        $this->add([
            'name'=> 'Price',
            'type'=>'text',
            'options'=> [
                'label' => 'Price'
            ]
        ]);
        $this->add([
            'name'=> 'Category',
            'type'=>'text',
            'options'=> [
                'label' => 'Product Category'
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