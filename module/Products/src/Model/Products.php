<?php

namespace Products\Model;

class Products
{
    public $Id;
    public $Category_Id;
    public $Name;
    public $Color;
    public $Price;
    public $Size;

    public function exchangeArray(array $data)
    {
        $this->Id     = !empty($data['Id']) ? $data['Id'] : null;
        $this->Name  = !empty($data['Name']) ? $data['Name'] : null;
        $this->Color  = !empty($data['Color']) ? $data['Color'] : null;
        $this->Price  = !empty($data['Price']) ? $data['Price'] : null;
        $this->Size  = !empty($data['Size']) ? $data['Size'] : null;
    }

    public function getArrayCopy(){
        return [
            'id' => $this->Id,
            'name' => $this->Name,
            'color' => $this->Color,
            'price' => $this->Price,
            'size' => $this->Size
        ];
    }
    public function getId(){
        return $this->Id;
    }
}