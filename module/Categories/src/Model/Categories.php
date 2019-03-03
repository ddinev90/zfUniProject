<?php

namespace Categories\Model;



class Categories 
{
    public $id;
    public $categoryName;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->categoryName  = !empty($data['categoryName']) ? $data['categoryName'] : null;
    }
    public function getArrayCopy(){
        return [
            'id' => $this->id,
            'categoryName' => $this->categoryName
        ];
    }
}