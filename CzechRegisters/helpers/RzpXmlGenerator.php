<?php
namespace CzechRegisters;
/**
 * Generator of XML files (strings) for TradeRegister
 * 
 */
class RzpXmlGenerator
{
    
    /**
     * caller: getSubjectByIco($ico)
     * @param string ICO
     * @return string XML string
     */
    public function createBasicQuery($ico)
    {
        // create XML document 
        $doc = new \DOMDocument('1.0','iso-8859-2');
        $rootNode = $doc->createElementNS("urn:cz:isvs:rzp:schemas:VerejnaCast:v1", "VerejnyWebDotaz");  
        $doc->appendChild($rootNode);
        $rootNode->setAttribute("version", "2.5");
        // search conditions
        $conditionsNode = $doc->createElement('Kriteria');
        $rootNode->appendChild($conditionsNode);
        // subject number
        $conditionsNode->appendChild($doc->createElement('IdentifikacniCislo', $ico));
        // record validity: 1 - actual, 2 - also historical
        $conditionsNode->appendChild($doc->createElement('PlatnostZaznamu', 1));
        // generate string
        return  $doc->saveXML();
    }
    
    /**
     * caller: getSubjectByName($name)
     * @param string subject name
     * @return string XML string
     */
    public function createSearchQuery($subject_name)
    {
        // create XML document 
        $doc = new \DOMDocument('1.0','iso-8859-2');
        $rootNode = $doc->createElementNS("urn:cz:isvs:rzp:schemas:VerejnaCast:v1", "VerejnyWebDotaz");  
        $doc->appendChild($rootNode);
        $rootNode->setAttribute("version", "2.5");
        // search conditions
        $conditionsNode = $doc->createElement('Kriteria');
        $rootNode->appendChild($conditionsNode);
        // trade name
        $conditionsNode->appendChild($doc->createElement('ObchodniJmeno', $subject_name));
        // partial search: 1 - beginning, 0 - exact match - seems not matter
        $conditionsNode->appendChild($doc->createElement('CastecneDohledani', 0));
        // record validity: 1 - actual, 2 - also historical
        $conditionsNode->appendChild($doc->createElement('PlatnostZaznamu', 1));
        // generate string
        return  $doc->saveXML();
    }
    
    /**
     * caller: getSubjectDetail($id)
     * @param string subject ID
     * @return string XML string
     */
    public function createTraderDetailQuery($trader_id)
    {
        // create XML document 
        $doc = new \DOMDocument('1.0','iso-8859-2');
        $rootNode = $doc->createElementNS("urn:cz:isvs:rzp:schemas:VerejnaCast:v1", "VerejnyWebDotaz");  
        $doc->appendChild($rootNode);
        $rootNode->setAttribute("version", "2.5");
        // search conditions
        $rootNode->appendChild($doc->createElement('PodnikatelID', $trader_id));
        $rootNode->appendChild($doc->createElement('Historie', '0'));
        $rootNode->appendChild($doc->createElement('DruhVypisu', 'XML'));
        // generate string
        return $doc->saveXML();
    }
    
}
