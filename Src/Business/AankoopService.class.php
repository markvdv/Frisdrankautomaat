<?php

namespace Src\Business;

use Src\DTO\SaldoDTO;
use Src\Exceptions\TeLaagSaldoException;
use Src\Exceptions\GeenGeldException;

class AankoopService {

    /** verkoopDrank
     * 
     * @param array $ingegevengeld associatieve array voor munten; muntwaarden zijn keys en aantallen values
     * @param integer $prijs
     * @param object $obj automaat object
     */
    public function verkoopDrank($oSaldo, $iPrijs, $iDrankid) {
        //saldo munten in geldlade steken
        foreach ($oSaldo->getMunten() as $muntWaarde => $muntAantal) {
            if ($muntAantal > 0) {
                MuntService::steekMuntInGeldLade($muntWaarde, $muntAantal);
            }
        }
        //check of er genoeg geld is ingeven om een drank aan te kopen
        $totaalSaldo = $oSaldo->geefTotaalSaldo();
        if ($totaalSaldo < $iPrijs) {
            throw new TeLaagSaldoException();
        }
        $teruggaveBedrag = $totaalSaldo - $iPrijs;
        $totaalGeld = MuntService::berekenTotaalInGeldLade();
        if ($totaalGeld < $teruggaveBedrag) {
            throw new GeenGeldException();
        }

        //berekenen array van teruggave
        $aTeruggave = array(200 => 0, 100 => 0, 50 => 0, 20 => 0, 10 => 0);
        foreach ($aTeruggave as $key => $value) {
            while ($teruggaveBedrag >= $key) {
                $teruggaveBedrag-=$key;
                $aTeruggave[$key]+=1;
            }
        }
        if ($teruggaveBedrag > 0) {
            throw new GeenGeldException();
        } else {
            foreach ($aTeruggave as $key => $value) {
                MuntService::haalMuntUitGeldLade($key, $value);
            }
        }
        FrisdrankService::geefFrisdrank($iDrankid);
        return $aTeruggave;
    }

}
