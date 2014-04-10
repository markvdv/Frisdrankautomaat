<?php

// <editor-fold defaultstate="collapsed" desc="doctrine autoloader">
use Doctrine\Common\ClassLoader;

require_once ('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("Src");
$classLoader->register();
$classLoader->setFileExtension(".class.php"); // </editor-fold>


use Src\Business\FrisdrankService;

FrisdrankService::vulFrisdrankenBij();
header('location:adminlogin.php');
exit(0);