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
        $aTeruggave = new SaldoDTO();
        $munten = MuntService::getMunten();
         echo "<pre>eerste ophaling van mlunten";
        print_r($munten);
        echo "</pre>";
        echo __LINE__ . "<br>" . __FILE__ . "<br>";
        $revMunten = array_reverse($munten);
        //berekenen van teruggave en daarna saldo gebruike om aantal munten te verminderen
        //hang  bij nul nog fixe
        foreach ($revMunten as $munt) {
            foreach ($oSaldo->getMunten() as $key => $value) {
                if ($munt->getAantal() > 0) {
                    while ($teruggaveBedrag >= $key) {
                        //verminderen van teruggavebedrag
                        $teruggaveBedrag-=$key;
                        //insteken in teruggave array
                        $aTeruggave->steekMuntInSaldo($key);
                    }
                }
            }
        }
        if ($teruggaveBedrag > 0) {
            throw new GeenGeldException();
        }
        $munten = MuntService::getMunten();
        echo "<pre>munten voor uitgeldla";
        print_r($munten);
        echo "</pre>";
        echo __LINE__ . "<br>" . __FILE__ . "<br>";

        foreach ($aTeruggave->getMunten() as $key => $value) {
            MuntService::haalMuntUitGeldLade($key, $value);
        }
        $munten = MuntService::getMunten();
        echo "<pre>munten na uit geldla";
        print_r($munten);
        echo "</pre>";
        echo __LINE__ . "<br>" . __FILE__ . "<br>";
        FrisdrankService::geefFrisdrank($iDrankid);
        foreach ($oSaldo->getMunten() as $key => $value) {
            MuntService::steekMuntInGeldLade($key, $value);
        }
        return $aTeruggave;
    }

}
