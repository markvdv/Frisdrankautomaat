<?php

namespace Src\DTO;

/* * SaldoDTO: class om het saldo bij te houden, wordt ook gebruikt voor de teruggave door te spelen aan de view
 * 
 */

class SaldoDTO {

    private $munten;

    // <editor-fold defaultstate="collapsed" desc="construct">
    /** __construct: maakt nieuw saldo object aan
     * 
     */
    function __construct() {
        $this->munten = array();
        $this->munten[200] = 0;
        $this->munten[100] = 0;
        $this->munten[50] = 0;
        $this->munten[20] = 0;
        $this->munten[10] = 0;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="getter en setter">
    /*     * getMunten: haalt de ingestoken munten op van het saldo object
     * 
     * @return array
     */
    public function getMunten() {
        return $this->munten;
    }

    public function setMunten($munten) {
        $this->munten = $munten;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="hulpfuncties">
    /*     * steekMuntInSaldo:vermeerdert het aantal van een munt in het saldo object op basis van waarde
     * 
     * @param integer $waarde
     */
    public function steekMuntInSaldo($waarde) {
        $this->munten[$waarde]+=1;
    }

    /*     * haalMuntUitSaldo:vermindert het aantal van een munt in het saldo object op basis van waarde
     * 
     * @param integer $waarde
     */

    public function haalMuntUitSaldo($waarde) {
        $this->munten[$waarde]-=1;
    }

    /*     * geefTotaalSaldo: berekent het totaal ingestoken saldo;
     * 
     * @return integer
     */

    public function geefTotaalSaldo() {
        $totaalSaldo = 0;
        foreach ($this->munten as $waarde => $aantal) {
            $totaalSaldo+=$waarde * $aantal;
        }
        return $totaalSaldo;
    }
    public function leegSaldo() {
        $this->__construct();
    }
// </editor-fold>
}
