<?php
namespace CzechRegisters;
/**
 * CEU = Centrální Evidence Úpadců <br>
 * Central bancrupt register <br>
 * search form: http://www.justice.cz/cgi-bin/sqw1250.cgi/upkuk/s_i8.sqw
 */
class CeuRegister
{
   
    private $base_url = 'http://www.justice.cz/cgi-bin/sqw1250.cgi/upkuk/s_i6.sqw';
        
    /**
     * Checks if the subject has bancrupt record. For cases before 1. 1. 2008.
     * @param string ICO
     * @return false|array FALSE if not, else ARRAY with information 
     * @throws RegInvalidArgumentException ICO has invalid format.
     */
    public function hasBancruptRecord($ico)
    {
        RegisterUtils::checkIco($ico);
        $params = '?vyber=0&nazev=&ico='.$ico.'&obec=&senat=&ktyp=&znacka=&rok=&soud=&MAXPOC=50&TYP_SORT=0&stav=&od=&do=&akce=&aod=&ado=&fprijmeni=&frc=&prijmeni=';
        $url = $this->base_url.$params;
        $html = new \simple_html_dom();
        // send request and get response
        $html->load_file($url);
        // process response
        $company_count = $html->find('center',1)->plaintext;
        $company_count = substr(trim($company_count),0,1);
        // has no record
        if ($company_count == 0) {
            return false;
        }
        // has a record
        else {
            return $this->processDebtor($html);
        } 
        
    }
    
    private function processDebtor($html)
    {
        $data = array();
        $data['has_record'] = true;
        // detail URL 
        $detail_link = $html->find('table',0)->find('a',0)->href;
        $data['detail_url'] = 'http://www.justice.cz/cgi-bin/sqw1250.cgi/upkuk/'.$detail_link;
        // current case state
        $case_state = $html->find('table',1)->children(4)->children(1)->plaintext;
        $data['case_state'] = RegisterUtils::winToUtf($case_state);
        // bancrupt date
        $bancrupt_date = $html->find('table',1)->children(5)->children(1)->plaintext;
        $data['bancrupt_date'] = RegisterUtils::winToUtf($bancrupt_date);
            
        return $data;
    }
        
}

