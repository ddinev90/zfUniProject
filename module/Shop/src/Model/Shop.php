<?php

namespace Shop\Model;

class Shop
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
        $this->Category_Id = !empty($data['Category_Id']) ? $data['Category_Id'] : null;
        $this->Name  = !empty($data['Name']) ? $data['Name'] : null;
        $this->Color  = !empty($data['Color']) ? $data['Color'] : null;
        $this->Price  = !empty($data['Price']) ? $data['Price'] : null;
        $this->Size  = !empty($data['Size']) ? $data['Size'] : null;
    }
}