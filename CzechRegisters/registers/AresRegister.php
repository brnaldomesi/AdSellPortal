<?php
namespace CzechRegisters;
/**
 * ARES = Administrativní registr ekonomických subjektů <br>
 * Administrative register of economics subjects <br>
 * Contains database filled with data from main public registers. But it's slow. <br>
 * search form: http://wwwinfo.mfcr.cz/ares/ares_es.html.cz
 */
class AresRegister
{
       
    private $url_std = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi';
    
    /**
     * Gets basic subject info based on ICO. 
     * @param string ICO
     * @return false|array FALSE if nothing found, else ARRAY with information
     * @throws RegInvalidArgumentException ICO has invalid format.
     */
    public function getSubjectByIco($ico)
    {
        RegisterUtils::checkIco($ico);
        $url = $this->url_std.'?ico='.$ico;
        // send GET request to server and get response
        $xml_result = file_get_contents($url);
        // create XML document
        $doc = new \DOMDocument('1.0','utf-8');
        $doc->loadXML($xml_result);
        // get first result node
        $result = $doc->getElementsByTagName('Zaznam')->item(0);
        // Was subject found?
        if ($result == null) {
            return false;
        }
        // get basic data
        return $this->processResultNode($result); 
    }
    
    /**
     * Searches subject by name. Returns list of matching subjects with basic info.
     * @param string legal name
     * @return false|array FALSE if nothing found, else ARRAY with arrays of information
     */
    public function getSubjectByName($name)
    {
        $url = $this->url_std.'?obchodni_firma='.urlencode($name);
        // send GET request to server and get response
        $xml_result = file_get_contents($url);
        // create XML document
        $doc = new \DOMDocument('1.0','utf-8');
        $doc->loadXML($xml_result);
        // get result nodes
        $results = $doc->getElementsByTagName('Zaznam');
        // Was subject found?
        if ($results->length == 0) {
            return false;
        }
        // save all subjects
        $subjects = array();
        foreach ($results as $res) {
            $subjects[] = $this->processResultNode($res); 
        }
        return $subjects;
    }
    
    private function processResultNode($result)
    {
        $data = array();
        // basic data
        $data['legal_name'] = $result->getElementsByTagName('Obchodni_firma')->item(0)->nodeValue;
        $data['ico'] = $result->getElementsByTagName('ICO')->item(0)->nodeValue;
        $data['origin_date'] = $result->getElementsByTagName('Datum_vzniku')->item(0)->nodeValue;
        $data['legal_form_code'] = $result->getElementsByTagName('Kod_PF')->item(0)->nodeValue;
        $data['register_type'] = $result->getElementsByTagName('Typ_registru')->item(0)->childNodes->item(3)->nodeValue;
        // address
        $addr_arr = array(); 
        $addr_node = $result->getElementsByTagName('Adresa_ARES')->item(0);
        $addr_arr['county_name'] = $addr_node->getElementsByTagName('Nazev_okresu')->item(0)->nodeValue;
        $addr_arr['town_name'] = $addr_node->getElementsByTagName('Nazev_obce')->item(0)->nodeValue;
        $addr_arr['town_district_name'] = $addr_node->getElementsByTagName('Nazev_casti_obce')->item(0)->nodeValue;
        $addr_arr['street_name'] = $addr_node->getElementsByTagName('Nazev_ulice')->item(0)->nodeValue;
        $addr_arr['house_number'] = $addr_node->getElementsByTagName('Cislo_domovni')->item(0)->nodeValue;
        $addr_arr['orientational_number'] = $addr_node->getElementsByTagName('Cislo_orientacni')->item(0)->nodeValue;
        $addr_arr['zip_code'] = $addr_node->getElementsByTagName('PSC')->item(0)->nodeValue;
        $data['address_items'] = $addr_arr;
        $data['address_full'] = 
                $addr_arr['street_name'].' '.$addr_arr['house_number'].'/'.$addr_arr['orientational_number'].', '.
                $addr_arr['town_district_name'].', '.$addr_arr['zip_code'].' '.$addr_arr['town_name'];
        
        return $data;
    }
    
   
    
}
