<?php
session_start();
use Src\Business\AdminService;
use Src\Exceptions\incorrectPasswordException;
use Src\Exceptions\userNotFoundException;
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



if (isset($_GET['action']) && $_GET['action'] == 'loguit') {
    //loguit
    unset($_SESSION['adminloggedin']);
    unset($_SESSION['automaat']);
    header('location:automaatcontroller.php');
    exit(0);
}  else if (isset($_POST['user']) && isset($_POST['password'])) {
    //login
    try{
     AdminService::login($_POST['user'], $_POST['password']);
        $_SESSION['adminloggedin'] = true;
        header("location:adminlogin.php");
        exit(0);
    }
    catch (userNotFoundException $uNFE){
        header("location:adminlogin.php?error=usernotfound");
        exit(0);
    }
    catch (incorrectPasswordException $iPE){
        header("location:adminlogin.php?error=incorrectpassword");
        exit(0) ;
    }
} else if (isset($_SESSION['adminloggedin']) && $_SESSION['adminloggedin'] == true) {
    //verwijzing bij succesvolle inlog
  //include('adminpaneelsetup.php');
  $paneel=AdminService::prepAdminPaneel();
   $view =$twig->render("adminpaneel.twig",array('dranken'=>$paneel->dranken,'munten'=>$paneel->munten));
   echo $view;
    
    
}
else if (isset($_GET['error'])) {
    //error handling van login
          $error=$_GET['error'];
          unset($_GET['error']);
        $view= $twig->render('adminloginform.twig',array('error'=>$error));
        echo $view;
  }  
else{
  //  header('location:presentation/adminloginform.php');
    $view= $twig->render('adminloginform.twig');
        echo $view;
}

