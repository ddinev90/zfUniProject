<?php
namespace User\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with Identifier %d',
                $id
            ));
        }

        return $row;
    }
    public function setPriviliges($user){
        $email = $user->user_email;
        $password = $user->user_password;

        $rowset = $this->tableGateway->select(['user_email'=>$email]);
        $row = $rowset->current();
        if(!$row){
            throw new RuntimeException(sprintf(
                'User with this email doesnt exist %d',
                $email
            ));
        }
        return $row->user_role;
    }
    public function validateUser($user){
        $email = $user->user_email;
        $password = $user->user_password;

        $rowset = $this->tableGateway->select(['user_email'=>$email]);
        $row = $rowset->current();
        if(!$row){
            throw new RuntimeException(sprintf(
                'User with this email doesnt exist %d',
                $email
            ));
        }
        if($row->user_password == $user->user_password){
            return true;
        }else{
            return false;
        }
    }
    public function saveUser($user)
    {
        $data = [
            'user_role'  =>(int)$user->user_role,
            'user_email'  => $user->user_email,
            'user_password'  => $user->user_password,
            'user_status' => $user->user_status,
        ];

        $id = (int) $user->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getUser($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update user with Identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}