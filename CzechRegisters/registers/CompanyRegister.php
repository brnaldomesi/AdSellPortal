<?php
namespace CzechRegisters;
/**
 * OR = Obchodní rejstřík + další rejstříky (spolkový, nadační, ústavů, o.p.s, s.v.j.) <br>
 * Business register + other organization registers <br>
 * search form: https://or.justice.cz/ias/ui/rejstrik
 */
class CompanyRegister
{
    
    private $base_url = 'https://or.justice.cz/ias/ui/rejstrik-dotaz?';
    
    /**
     * Gets information about certain company (organization).
     * @param string ICO
     * @return false|array FALSE if nothing found, else ARRAY with information
     * @throws RegInvalidArgumentException ICO has invalid format.
     */
    public function getSubjectByIco($ico)
    {
        RegisterUtils::checkIco($ico);
        $params = "dotaz=$ico";
        $html = new \simple_html_dom();
        // send GET request and get response
        //$html->load_file($this->base_url.$params); //<- does not work in my Nette app, I really dunno why
        $string = file_get_contents($this->base_url.$params);
        $html->load($string);
        $result = $html->find('li.result',0);
        if (!$result) {
            return false;
        }
        // process response
        return $this->processItem($result);
    }
    
    /**
     * Gets information about companies (organizations) matching the entered name. 
     * @param string legal name
     * @return boolean|array FALSE if nothing found, else ARRAY with matching companies, each item contains array with information  
     */
    public function getSubjectByName($name)
    {
        $params = 'dotaz='.urlencode($name);
        $html = new \simple_html_dom();
        // send GET request and get response
        $html->load_file($this->base_url.$params);
        $result = $html->find('li.result');
        if (count($result) == 0) {
            return false;
        }
        // process all results
        $items = array();
        foreach ($result as $item) {
            $items[] = $this->processItem($item);
        }
        return $items;
    }
        
    /**
     * Processes part of HTML page containing info about a company.
     * @param string part of the webpage
     * @return array company information
     */
    private function processItem($item)
    {
        $rows = $item->find('tr');
        $data = array();
        $data['legal_name'] = $rows[0]->find('td',0)->find('strong',0)->innertext;  // obchodní firma
        $data['ico'] = $rows[0]->find('td',1)->find('strong',0)->plaintext;         // ICO
        $data['record_mark'] = $rows[1]->find('td',0)->plaintext;                   // spisová značka 
        $data['origin_date'] = $rows[1]->find('td',1)->innertext;                   // den zápisu
        $data['address_full'] = $rows[2]->find('td',0)->plaintext;                  // sídlo
        // edit data
        $data['legal_name'] = trim($data['legal_name']);
        $data['ico'] = str_replace(' ', '', $data['ico']);
        $data['record_mark'] = trim($data['record_mark']);
        $data['origin_date'] = trim($data['origin_date']);
        $data['address_full'] = trim(str_replace('&nbsp;', ' ', $data['address_full']));
        // link to the complete statement from register
        $links = $item->find('ul[class=result-links noprint]',0);
        $link = $links->find('a',0)->href;
        $url = str_replace('&amp;', '&', $link);
        $data['statement_url'] = 'https://or.justice.cz'.$url;  // kompletní výpis z rejstříku 
        
        return $data;
    }
    
    
    
}
