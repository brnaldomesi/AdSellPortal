<?php
require('../core.php');
use \CzechRegisters as CR;

$ceu = new CR\CeuRegister();
//var_dump($ceu->hasBancruptRecord('00000868'));

$dph = new CR\DphRegister();
//var_dump($dph->getDphPayer('27074358'));

$ir = new CR\InsolvencyRegister();
//var_dump($ir->hasInsolventRecord('ico', '02063212'));
//var_dump($ir->hasInsolventRecord('rc', '760430/4015'));

$or = new CR\CompanyRegister();
//var_dump($or->getSubjectByIco('27074358'));
//var_dump($or->getSubjectByName('asseco'));

$res = new CR\ResRegister();
//var_dump($res->getSubjectByIco('27074358'));

$ruian = new CR\AddressRegister();
$input = array('town_name' => 'Brno', 'street_name'=>'Kubíčkova', 'orientational_number'=>6);
//$input = array('town_name' => 'Brno', 'house_number'=>129);
try {
    //var_dump($ruian->isAddressValid($input));
} catch (CR\RegInvalidArgumentException $ex) {
    echo $ex->getMessage();
}

$vies = new CR\ViesRegister();
//var_dump($vies->isVatPayer('CZ', '27074358'));

$rzp = new CR\TradeRegister();
//$data = $rzp->getSubjectByIco('27074358');
//var_dump($data);
//var_dump($rzp->getSubjectDetail($data['id']));
//var_dump($rzp->getSubjectByName('asseco'));

$ares = new CR\AresRegister();
//var_dump($ares->getSubjectByIco('26587840'));
//var_dump($ares->getSubjectByName('asseco'));

$cr = new CR\CzechRegisters();
//var_dump($cr->getSubjectByIco('27074358'));
//var_dump($cr->getSubjectByName('asseco'));
//var_dump($cr->isAddressValid($input));
//var_dump($cr->getDphPayer('27074358'));
//var_dump($cr->isVatPayer('CZ','27074358'));
//var_dump($cr->hasInsolventRecord('27526631'));











