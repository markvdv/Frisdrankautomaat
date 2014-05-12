<?php

session_start();

// <editor-fold defaultstate="collapsed" desc="doctrine autoloader">

use Doctrine\Common\ClassLoader;

require_once ('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("Src");
$classLoader->register();
$classLoader->setFileExtension(".class.php"); // </editor-fold>
// <editor-fold defaultstate="collapsed" desc="twig templating engine">
require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("Src/Presentation");

$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug); // </editor-fold>
// <editor-fold defaultstate="collapsed" desc="used classes">

use Src\Business\AankoopService;
use Src\DTO\AutomaatDTO;
use Src\DTO\SaldoDTO;
use Src\Exceptions\GeenGeldException;
use Src\Exceptions\TeLaagSaldoException;

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="setup van de automaat">
if (!isset($_SESSION['automaat']) || !isset($_SESSION['saldo'])) {
    $_SESSION['automaat'] = serialize(new AutomaatDTO());
    $_SESSION['saldo'] = serialize(new SaldoDTO());
}

// toekenning van DTO object aan $automaat;
$automaat = unserialize($_SESSION['automaat']);
$saldo = unserialize($_SESSION['saldo']);
$error = null;
$aTeruggave = null;
if (isset($_SESSION['teruggave'])) {
    $aTeruggave = unserialize($_SESSION['teruggave']);
    unset($_SESSION['teruggave']);
    unset($_SESSION['saldo']);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Gethandler Action">
//handler action get parameter 
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "steekgeldin":
            $saldo->steekMuntInSaldo($_GET['id']);
            $_SESSION['saldo'] = serialize($saldo);
            break;
        case 'geldterug':
            $saldo->leegSaldo();
            $_SESSION['saldo'] = serialize($saldo);
            break;
        case 'kopen':
            try {
                $aTeruggave = AankoopService::verkoopDrank($saldo, $_GET['prijs'], $_GET['id']);
                $saldo->leegSaldo();
                $_SESSION['saldo']=serialize($saldo);
                $automaat= new AutomaatDTO();
                $_SESSION['automaat']=serialize($automaat);
                $gekozenDrank=$_GET['type'];
                $view = $twig->render('automaat.twig', array('frisdranken' => $automaat->getFrisdranken(), 'munten' => $automaat->getMunten(), 'totaalsaldo' => $saldo->geefTotaalSaldo(), 'teruggave' => $aTeruggave, 'error' => $error, 'gekozendrank'=>$gekozenDrank));
                //redirect naar controller om object in DB te steken
            } catch (TeLaagSaldoException $TLSe) {
                $error = 'telaagsaldo';
            } catch (GeenGeldException $GGe) {
                $error = 'geenwisselgeld';
            }
            break;
    }
}
else{
    $aankoop=false;
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="View opbouw en rendering">
//PRESENTATIEPAGINA
if (!isset($view)) {
    $view = $twig->render('automaat.twig', array('frisdranken' => $automaat->getFrisdranken(), 'munten' => $automaat->getMunten(), 'totaalsaldo' => $saldo->geefTotaalSaldo(), 'error' => $error));
}
echo $view; // </editor-fold>


