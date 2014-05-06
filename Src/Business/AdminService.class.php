<?php

// MOET NOG PASSWORD HASH & SALT HEBBEN

namespace Src\Business;

use Src\Data\AdminDAO;
use Src\Business\MuntService;
use Src\Business\FrisdrankService;
use Src\Exceptions\incorrectPasswordException;
use Src\Exceptions\userNotFoundException;
class AdminService {

    /**
     * 
     * @param string $username:de username van de admin die inlogt
     * @param string $password:password van admin die inlogt
     * @return $admin:geeft een admin object terug indien gevonden en passwoord match
     * @throws userNotFoundException: foutn indien de username niet gevonden wordt in de db
     * @throws incorrectPasswordException: fout indien de paswoorden niet overeenkomen
     */
    public static function login($username, $password) {
        $admin = AdminDAO::findAdminByUsername($username);
        if (!$admin) {
            throw new userNotFoundException();
        }
        if ($admin->getPassword() == $password) {
            return $admin;
        } else {
            throw new incorrectPasswordException();
        }
    }

    public static function prepAdminPaneel() {
        $paneel = new \stdClass();
        $paneel->munten = MuntService::getMunten();
        $paneel->dranken = FrisdrankService::haalFrisdrankenOp();
        return $paneel;
    }

}
