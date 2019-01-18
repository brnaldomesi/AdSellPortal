<?php
require('../core.php');
use \CzechRegisters as CR;
$scriptName = 'show-test.php';

function showData($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

$formValues = array(
    'ico' => '27074358',
    'name' => 'asseco',
    // eu vat payer
    'country_code' => 'CZ',
    'company_number' => '27074358',
    // valid address
    'street_name' => 'Kubíčkova',
    'house_number' => '',
    'orientational_number' => '6',
    'town_district' => '',
    'town_name' => 'Brno',
    'zip_code' => ''
);

if (!empty($_POST)) {
    foreach($formValues as $key => $value) {
        if (array_key_exists($key, $_POST)) {
            $formValues[$key] = $_POST[$key];
        }
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>CzechRegisters - test page</title>
</head>
<body>
<h1>CzechRegisters - test page</h1>
<a href="<?php echo $scriptName;?>">reset page</a>   
<h2>Subject info</h2>
<form method="post">
    <input type="hidden" name="subjectMethods" value="1">
    <label for="fieldIco"><b>IČO:</b> </label>
    <input id="fieldIco" type="text" name="ico" value="<?php echo $formValues['ico'];?>" length="8">
    <label for="fieldName"><b>Legal name:</b> </label>
    <input id="fieldName" type="text" name="name" value="<?php echo $formValues['name'];?>"> only for "Subject by name"
    <br/><br/>
    <input type="submit" name="getSubjectByIco" value="Subject by ICO"> 
    <input type="submit" name="getSubjectByName" value="Subject by name">
    <input type="submit" name="getDphPayer" value="Get DPH payer">
    <input type="submit" name="hasInsolventRecord" value="Insolvent record">    
</form>

<h2>Other methods</h2>
<h3>EU VAT payer</h3>
<form method="post">
    <label for="fieldCountryCode"><b>Country code:</b> </label>
    <input id="fieldCountryCode" type="text" name="country_code" value="<?php echo $formValues['country_code'];?>" length="2" size="5">
    <label for="fieldCompanyNumber"><b>Company number:</b> </label>
    <input id="fieldCompanyNumber" type="text" name="company_number" value="<?php echo $formValues['company_number'];?>">
    <br><br>
    <input type="submit" name="isVatPayer" value="Get EU VAT payer">
</form>

<h3>Valid address</h3>
<form method="post">
    <label for="fieldStreetName"><b>Street name:</b> </label>
    <input id="fieldStreetName" type="text" name="street_name" value="<?php echo $formValues['street_name'];?>">
    <b>House/orient. num.</b>
    <input type="text" name="house_number" value="<?php echo $formValues['house_number'];?>" size="5">/
    <input type="text" name="orientational_number" value="<?php echo $formValues['orientational_number'];?>" size="5"><br><br>
    <b>Town name:</b> <input type="text" name="town_name" value="<?php echo $formValues['town_name'];?>"> 
    <b>Town district:</b> <input type="text" name="town_district" value="<?php echo $formValues['town_district'];?>"><br><br>
    <b>ZIP code:</b> <input type="text" name="zip_code" value="<?php echo $formValues['zip_code'];?>">
    <br><br>
    <input type="submit" name="isAddressValid" value="Is address valid">
</form>


<h2>Results</h2>
<?php
$cr = new CR\CzechRegisters();

if (isset($_POST['subjectMethods']))
{
    $data = false;
    $ico = $_POST['ico']; $name = $_POST['name'];
    try {
        // methods
        if(isset($_POST['getSubjectByIco'])) {
            $data = $cr->getSubjectByIco($ico);
        }
        if(isset($_POST['getSubjectByName'])) {
            $data = $cr->getSubjectByName($name);
        }
        if(isset($_POST['getDphPayer'])) {
            $data = $cr->getDphPayer($ico);
        }
        if(isset($_POST['hasInsolventRecord'])) {
            $data = $cr->hasInsolventRecord($ico);
        }
        // show result
        showData($data);
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    
}

if (isset($_POST['isVatPayer']))
{
    $code = $_POST['country_code'];
    $number = $_POST['company_number'];
    try {
        $data = $cr->isVatPayer($code,$number);
        showData($data);
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

if (isset($_POST['isAddressValid']))
{
    $input = array(
        'street_name' => $_POST['street_name'],
        'house_number' => $_POST['house_number'],
        'orientational_number' => $_POST['orientational_number'],
        'town_district' => $_POST['town_district'],
        'town_name' => $_POST['town_name'],
        'zip_code' => $_POST['zip_code']
    );
    try {
        $data = $cr->isAddressValid($input);
        showData($data);
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}


?>

</body>
</html>