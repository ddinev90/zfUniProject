<?php
namespace Users\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UsersTable
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

    public function getUser($Id)
    {
        $Id = (int) $Id;
        $rowset = $this->tableGateway->select(['Id' => $Id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with Identifier %d',
                $Id
            ));
        }

        return $row;
    }

    public function saveUser($user)
    {
        $data = [
            'RoleId'  =>(int)$user->RoleId,
            'Name'  => $user->Name,
            'Password'  => $user->Password,
            'Telephone' => $user->Telephone,
            'Email' => $user->Email,
        ];

        $Id = (int) $user->Id;

        if ($Id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getUser($Id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update user with Identifier %d; does not exist',
                $Id
            ));
        }

        $this->tableGateway->update($data, ['Id' => $Id]);
    }

    public function deleteUser($Id)
    {
        $this->tableGateway->delete(['Id' => (int) $Id]);
    }
}