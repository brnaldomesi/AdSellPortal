<?php
namespace CzechRegisters;
/**
 * RZP = Registr živnostenského podnikání (živnostenský rejstřík)<br>
 * Trade business register <br>
 * search form: http://www.rzp.cz/cgi-bin/aps_cacheWEB.sh?VSS_SERV=ZVWSBJFND
 */
class TradeRegister
{
    
    private $action_url = 'http://www.rzp.cz/cgi-bin/aps_cacheWEB.sh';
    
    private $xml_generator;
    
    public function __construct() {
        $this->xml_generator = new RzpXmlGenerator();
    }
    
    /**
     * Gets basic information about registered subject.
     * @param string ICO
     * @return false|array FALSE if subject was not found, else ARRAY of information
     * @throws RegInvalidArgumentException ICO has invalid format.
     */
    public function getSubjectByIco($ico)
    {
        RegisterUtils::checkIco($ico);
        $xml_string = $this->xml_generator->createBasicQuery($ico);
        $filepath = $this->createTemporaryFile($xml_string);
        $response = $this->sendQueryFile($filepath);
        return $this->processBasicResponse($response);
    }
    
    /**
     * Searches register by legal name and returns all matching subjects.
     * @param string legal name
     * @return boolean|array FALSE if nothing found, else ARRAY containing arrays with information
     */
    public function getSubjectByName($name)
    {
        $xml_string = $this->xml_generator->createSearchQuery($name);
        $filepath = $this->createTemporaryFile($xml_string);
        $response = $this->sendQueryFile($filepath);
        return $this->processSearchResponse($response);
    }
    
    /**
     * Gets detailed information about subject. (only some fields implemented)
     * @param string subject ID, which you must get from array with information about the subject
     * @return false|array FALSE if subject ID is invalid, else ARRAY with information
     */
    public function getSubjectDetail($id)
    {        
        $xml_string = $this->xml_generator->createTraderDetailQuery($id);
        $filepath = $this->createTemporaryFile($xml_string);
        $response = $this->sendQueryFile($filepath);
        return $this->processTraderDetailResponse($response);
    }
    
    // processing responses
    
    private function processBasicResponse($response)
    {
        // create XML document
        $doc = new \DOMDocument('1.0','iso-8859-2');
        $doc->loadXML($response);
        // get trader node
        $trader = $doc->getElementsByTagName('PodnikatelSeznam')->item(0);
        // Trader was not found
        if ($trader == null) {
            return false;
        }
       return $this->parseTraderNode($trader);
    }

    private function processTraderDetailResponse($response)
    {
        // create XML document
        $doc = new \DOMDocument('1.0','iso-8859-2');
        $doc->loadXML($response);
        // get trader node
        $trader = $doc->getElementsByTagName('PodnikatelDetail')->item(0);
        // was not found
        if ($trader == null) {
            return false;
        }
        $data = array();
        $data['address'] = $trader->getElementsByTagName('TextAdresy')->item(0)->nodeValue;
        $data['origin_date'] = $trader->getElementsByTagName('Vznik')->item(0)->nodeValue; // první živnost v pořadí
        
        return $data;
    }
    
    private function processSearchResponse($response)
    {
        // create XML document
        $doc = new \DOMDocument('1.0','iso-8859-2');
        $doc->loadXML($response);
        // get trader nodes
        $trader_nodes = $doc->getElementsByTagName('PodnikatelSeznam');
        // no trader was found
        if ($trader_nodes->length == 0) {
            return false;
        }
        // save all traders
        $traders = array();
        foreach ($trader_nodes as $node) 
        {
            $traders[] = $this->parseTraderNode($node);
        }
        return $traders;
    }
    
    private function parseTraderNode($trader)
    {
        $data = array();
        $data['id'] = $trader->getElementsByTagName('PodnikatelID')->item(0)->nodeValue;
        $data['legal_name'] = $trader->getElementsByTagName('ObchodniJmenoSeznam')->item(0)->nodeValue;
        $data['ico'] = $trader->getElementsByTagName('IdentifikacniCisloSeznam')->item(0)->nodeValue;
        $data['subject_type'] = $trader->getElementsByTagName('TypPodnikatele')->item(0)->nodeValue;
        $data['address_full'] = $trader->getElementsByTagName('AdresaPodnikaniSeznam')->item(0)->nodeValue;
        $data['registering_authority'] = $trader->getElementsByTagName('EvidujiciUrad')->item(0)->nodeValue;
        return $data;
    }
    
    // helpers
        
    private function sendQueryFile($path)
    {       
        // prepare POST data
        $data = array(
            'VSS_SERV' => 'ZVWSBJXML',
            'filename' => "@$path"
        );
        // open connection
        $ch = curl_init();
        // set parameters
        curl_setopt($ch, CURLOPT_URL, $this->action_url);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // execute post
        $response = curl_exec($ch);
        // close connection
        curl_close($ch);
        // delete file
        unlink($path);
        
        return $response;
    }
        
    private function createTemporaryFile($xmlString)
    {
        $fname = tempnam(RegisterUtils::getTempDir(), 'XML');
        $handle = fopen($fname, "w");
        fwrite($handle, $xmlString);
        fclose($handle);
        return $fname;
    }
    
}
