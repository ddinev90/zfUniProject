<?php

namespace Users\Model;

class Users
{
    public $Id;
    public $Password;
    public $Name;
    public $RoleId;
    public $Telephone;
    public $Email;

    public function exchangeArray(array $data)
    {
        $this->Id     = !empty($data['Id']) ? $data['Id'] : null;
        $this->Password = !empty($data['Password']) ? $data['Password'] : null;
        $this->Name  = !empty($data['Name']) ? $data['Name'] : null;
        $this->RoleId  = !empty($data['RoleId']) ? $data['RoleId'] : null;
        $this->Telephone  = !empty($data['Telephone']) ? $data['Telephone'] : null;
        $this->Email  = !empty($data['Email']) ? $data['Email'] : null;
    }
    public function getArrayCopy(){
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'RoleId'=> $this->RoleId,
            "Telephone"=>$this->Telephone,
            'Email'=>$this->Email,
            'Password'=>$this->Password
        ];
    }
}