<?php
namespace CzechRegisters;
/**
 * RES = Registr ekonomických subjektů <br>
 * Economic subjects register <br>
 * The main method is sometimes very slow (due to the remote server), so the class is not always usable. <br>
 * search form: http://apl.czso.cz/irsw
 */
class ResRegister
{
    
    private $action_url = 'http://registry.czso.cz/irsw/hledat.jsp';
    
    private $html = NULL;
    
    public function __construct() {
        $this->html = new \simple_html_dom();
    }
    
    /**
     * Finds subject in the register and returns information about it.
     * @param string ICO
     * @return false|array FALSE if subject not found, ELSE array with information
     * @throws RegInvalidArgumentException ICO has invalid format.
     */
    public function getSubjectByIco($ico)
    {       
        RegisterUtils::checkIco($ico);
        $response = $this->getResultsPage($ico);
        $link = $this->processResultsPage($response); 
        if (!$link) {
            return false;
        }
        return $this->processSubjectPage($link);        
    }
    
    // helpers
    private function processSubjectPage($link)
    {
        $url = 'http://registry.czso.cz/irsw/'.$link;
        $this->html->load_file($url);
        $data = array();
        $properties = $this->html->find('table[summary=atributy]',0);
        
        // size category of the subject based on the number of employees
        $employees = $properties->last_child()->find('td',2)->innertext;
        if ($employees == 'Neuvedeno') {
            $data['employees_cat'] = NULL;
        }
        else {
            $data['employees_cat'] = trim(strstr($employees,'z',TRUE));
        }       
        return $data;
    }
    
    private function processResultsPage($response)
    {
        $this->html = new \simple_html_dom();
        $this->html->load($response);
        $results = $this->html->find('.tablist table',0);
        if (count($results->children()) <= 1) {
            return false;
        }
        return $results->find('a',0)->href;
    }
    
    private function getResultsPage($ico)
    {
        // prepare data for POST request
        $data = array(
            'forma' => '',
            'ico' => $ico,
            'nazev' => '', 
            'okres' => '', 'run_rswquery' => 'Hledej', 'texttype' => '0',
            'zanik' => 0
        );
        $query = http_build_query($data);
        //// Send POST request to server
        $ch = curl_init();
        // set parameters
        curl_setopt($ch, CURLOPT_URL, $this->action_url);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // execute post
        $response = curl_exec($ch);
        // close connection
        curl_close($ch);
        
        return $response;
    }
    
}
