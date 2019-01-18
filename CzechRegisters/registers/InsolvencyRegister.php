<?php
namespace CzechRegisters;
/**
 * IR = Insolvenční rejstřík <br>
 * Insolvency register <br>
 * search form: https://isir.justice.cz/isir/common/index.do
 */
class InsolvencyRegister
{
    
    private $base_url = 'https://isir.justice.cz/isir/ueu/vysledek_lustrace.do?';
        
    /**
     * Checks if the subject has record in the insolvency register. For cases after 1. 1. 2008.
     * @param string "ico" for subject identifier or "rc" for birth number
     * @param string specified ICO or RC, RC can be with or without /  
     * @return false|array FALSE if not, else ARRAY with information
     * @throws RegInvalidArgumentException Type is neither "ico" nor "rc". | ICO has invalid format.
     */
    public function hasInsolventRecord($type, $value)
    {
        // choose params
        if ($type == 'ico') {
            $ico = $value; $rc ='';
            RegisterUtils::checkIco($ico);
        }
        elseif ($type == 'rc') {
            $rc = $value; $ico = '';
        }
        else {
            throw new RegInvalidArgumentException('You must enter "ico" or "rc" into type parameter.');
        }
        $params = "ic=$ico&rc=$rc";
        $params .= '&nazev_osoby=&datum_narozeni=&vyhledat_pouze_podle_zacatku=on&podpora_vyhledat_pouze_podle_zacatku=true&jmeno_osoby=&mesto=&cislo_senatu=&bc_vec=&rocnik=&id_osoby_puvodce=&druh_stav_konkursu=&datum_stav_od=&datum_stav_do=&aktualnost=AKTUALNI_I_UKONCENA&druh_kod_udalost=&datum_akce_od=&datum_akce_do=&nazev_osoby_f=&cislo_senatu_vsns=&druh_vec_vsns=&bc_vec_vsns=&rocnik_vsns=&cislo_senatu_icm=&bc_vec_icm=&rocnik_icm=&rowsAtOnce=50&captcha_answer=&spis_znacky_datum=&spis_znacky_obdobi=14DNI';
        // send request and get response
        $html = new \simple_html_dom();
        $html->load_file($this->base_url.$params);
        // process response
        $debtor_count = $html->find('table.vysledekLustrace',0)->children(3)->children(1)->plaintext;
        // has no record
        if (trim($debtor_count) == 0) {
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
        $detail_link = $html->find('table.vysledekLustrace',1)->find('a',0)->href;
        $data['detail_url'] = 'https://isir.justice.cz/isir/ueu/'.str_replace('&#61;','=', $detail_link);
        // current case state
        $case_state = $html->find('span.vysledekLustrace',-1)->innertext;
        $data['case_state'] = RegisterUtils::winToUtf($case_state);
        // birth number
        $birth_string = $html->find('span.vysledekLustrace',-3)->innertext;
        $birth_string = RegisterUtils::winToUtf($birth_string);
        if (trim($birth_string == '/')) {
            $data['birth_number'] = NULL;
        }
        else {
            preg_match('~^(\d+/\d+)~', $birth_string, $matches);
            $data['birth_number'] = $matches[1];
        }
          
        return $data;
    }
    
   
    
}
