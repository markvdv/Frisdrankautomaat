<?php

/* overkoepelende service die gebruik maakt van de Munt- en Frisdrank Service,
 * deze class houdt het ingegeven geld, gekochte dranken en de geldkas bij 
 */

namespace Src\DTO;

use Src\Business\MuntService;
use Src\Business\FrisdrankService;
use Src\DTO\SaldoDTO;
class AutomaatDTO {

    // <editor-fold defaultstate="collapsed" desc="class variables">
    private $frisdranken;
    private $munten;
    private $saldo; // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="__construct">

    public function __construct() {
        $this->munten = MuntService::getMunten();
        $this->frisdranken = FrisdrankService::haalFrisdrankenOp();
    }

// </editor-fold>

        public static function schrijfGegevensWeg($obj) {
        $drankenlijst = $obj->frisdranken;
        FrisdrankService::UpdateDranken($drankenlijst);
        $muntenlijst = $obj->munten;
        MuntService::UpdateMunten($muntenlijst);
    }

// <editor-fold defaultstate="collapsed" desc="getters">
    public function getFrisdranken() {
        return $this->frisdranken;
    }

    public function getMunten() {
        return $this->munten;
    }
// </editor-fold>

}
