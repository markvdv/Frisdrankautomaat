<?php
namespace Src\Data;
use Src\Entities\Admin;
class AdminDAO extends DAO{
    
    /**
     * 
     * @param type $username= de naam van de admin account
     * @return object Admin|boolean: returnt admin object indien de username in de db staat anders false;
     */
    public static function findAdminByUsername($username) {
        $sql= "SELECT * FROM admin WHERE username=?";
        $args=func_get_args();
        $stmt=parent::execPreppedStmt($sql,$args);
        $result=$stmt->fetch();
        if ($result){
            $admin=Admin::create($result['id'],$result['user'],$result['password']);
            return $admin;
        }
        else{
            return false;
        }
    }

}


