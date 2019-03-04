<?php

namespace User\Model;

class User
{
    public $id;
    public $user_password;
    public $user_role;
    public $user_status;
    public $user_email;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->user_password = !empty($data['user_password']) ? $data['user_password'] : null;
        $this->user_email  = !empty($data['user_email']) ? $data['user_email'] : null;
        $this->user_role  = !empty($data['user_role']) ? $data['user_role'] : null;
        $this->user_status  = !empty($data['user_status']) ? $data['user_status'] : null;
    }
    public function getArrayCopy(){
        return [
            'id' => $this->id,
            'user_email' => $this->user_email,
            'user_role'=> $this->user_role,
            "user_status"=>$this->user_status,
            'user_password'=>$this->user_password
        ];
    }
}