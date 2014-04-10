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
use Src\DTO\AutomaatDTO;
use Src\Business\AankoopService;
use Src\Data\MuntDAO;
use Src\Exceptions\TeLaagSaldoException;
use Src\Exceptions\GeenGeldException; // </editor-fold>





// <editor-fold defaultstate="collapsed" desc="setup van de automaat">
//check of de sessie is gezet en indien nodig aanmaken
if (!isset($_SESSION['automaat'])) {
    $automaat = new AutomaatDTO();
    $_SESSION['automaat'] = serialize($automaat);
}
//check voor teruggave
$teruggave = null;
if (isset($_SESSION['teruggave'])) {
    $teruggave = unserialize($_SESSION['teruggave']);
    unset($_SESSION['teruggave']);
}
// toekenning van DTO object aan $automaat;
$automaat = unserialize($_SESSION['automaat']); // </editor-fold>



// <editor-fold defaultstate="collapsed" desc="Gethandler Action">
//handler action get parameter 
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "steekgeldin":
            $automaat->getSaldo()->steekMuntInSaldo($_GET['id']);
            $_SESSION['automaat'] = serialize($automaat);
            break;
        case 'geldterug':
            $automaat->maakSaldoLeeg();
            $_SESSION['automaat'] = serialize($automaat);
            break;
        case 'kopen':
            try {
                $aTeruggave = AankoopService::verkoopDrank($automaat->getSaldo(), $_GET['prijs'], $_GET['id'], $automaat->getMunten(), $automaat->getFrisdranken());
                $_SESSION['teruggave'] = serialize($aTeruggave);
                unset($_SESSION["automaat"]);
                header("location:automaatcontroller.php");
                //redirect naar controller om object in DB te steken
            } catch (TeLaagSaldoException $TLSe) {
                header('location:automaatcontroller.php?error=telaagsaldo');
                exit(0);
            } catch (GeenGeldException $GGe) {
                header('location:automaatcontroller.php?error=geenwisselgeld');
                exit(0);
            }
            break;
    }
}// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="error indien nodig">
//ERRORHANDLING
$error = null;
if (isset($_GET['error'])) {
    $error = $_GET['error'];
}// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="View opbouw en rendering">
//PRESENTATIEPAGINA
$view = $twig->render('automaat.twig', array('frisdranken' => $automaat->getFrisdranken(), 'munten' => $automaat->getMunten(), 'totaalsaldo' => $automaat->getSaldo()->geefTotaalSaldo(), 'teruggave' => $teruggave, 'saldo' => $automaat->getSaldo(), 'error' => $error, 'teruggave' => $teruggave));
echo $view; // </editor-fold>


