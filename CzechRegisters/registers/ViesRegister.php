<?php
namespace CzechRegisters;
/**
 * VIES - Ověřování DIČ pro účely DPH prostřednictvím systému VIES <br>
 * VIES - VAT validation for EU companies <br>
 * search form: http://ec.europa.eu/taxation_customs/vies/vatRequest.html
 */
class ViesRegister
{
    /**
     * Checks if the  subject is registered for VAT in its country. If yes then return info.
     * @param string two letter country code
     * @param string ICO or similar number, without first letters (not DIC)
     * @return false|array FALSE if subject doesn't pay VAT, else ARRAY with information 
     * @throws RegInvalidArgumentException invalid country code or company number
     * @throws SoapFault VIES server error
     */
    public function isVatPayer($country_code,$company_number)
    {
        $country_code = strtoupper($country_code); 
        // check arguments
        if (preg_match('~^[A-Z][A-Z]$~',$country_code) == 0 OR !is_numeric($company_number))
        {
            throw new RegInvalidArgumentException('You inserted invalid parameters for VAT search.');
        }
        // prepare SOAP client
        $wdslUrl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
        $options = array('user_agent' => 'Czech Registers');
        $soapClient = new \SoapClient($wdslUrl,$options);
        $params = array(
            'countryCode' => $country_code,
            'vatNumber' => $company_number
        );
        // call SOAP client
        try {
            $data = (array) $soapClient->checkVat($params);
            if ($data['valid'] == false) {
                $data = false;
            }
        } catch (\SoapFault $ex) {
            throw new \SoapFault('VIES server error: '.$ex->getMessage());
        }
        return $data;
    }
    
    
    
}
