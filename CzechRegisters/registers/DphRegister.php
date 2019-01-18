<?php
namespace CzechRegisters;
/**
 * DPH = Registr plátců daně z přidané hodnoty <br>
 * Register of value added tax payers (VAT = DPH) <br>
 * search form: http://adisreg.mfcr.cz/cgi-bin/adis/idph/int_dp_prij.cgi?ZPRAC=FDPHI1&poc_dic=2
 */
class DphRegister
{
    
    private $form_url = 'http://adisreg.mfcr.cz/cgi-bin/adis/idph/int_dp_prij.cgi?ZPRAC=FDPHI1&poc_dic=2';
    
    private $action_url;
            
    /**
     * Checks whether the subject is VAT payer in CZ. If yes, return if it's reliable or unreliable.
     * @param string ICO
     * @return false|array FALSE if subject isn't DPH payer, else ARRAY with information
     * @throws RegInvalidArgumentException ICO has invalid format.
     */    
    public function getDphPayer($ico)
    {
        RegisterUtils::checkIco($ico);
        // create query for form
        $html = new \simple_html_dom();
        $query = $this->createQuery($html,$ico);
        // sleep for 2 seconds - needed, otherwise server returns 302
        sleep(2); 
        // send request and get response
        $html->load($this->sendRequest($query));
        // is it VAT payer?
        $result = $html->find('.tabulka_result');
        if (count($result) == 0) {
            return false;
        }
        // is it unreliable VAT payer?
        $unreliable = $html->find('.tabulka_result',2)->find('.data',0)->innertext;
        $data = array();
        if ($unreliable == 'ANO') {
            $data['unreliable'] = true; 
        }
        else {
            $data['unreliable'] = false; 
        }
        return $data;
    }
    
    private function createQuery($html,$ico)
    {
        // get form info
        $html->load_file($this->form_url);
        $form = $html->find('#form',0);
        $this->action_url = 'http://adisreg.mfcr.cz'.$form->action;
        $javax_state = $form->find('input[id=javax.faces.ViewState]',0)->value;
        // prepare data for POST
        $data = array(
            'autoScroll' => '',
            'form:_idJsp31' => '0',
            'form:_idJsp38' => '2',
            'form:_idcl' => '',
            'form:__link_hidden_' => '',
            'form:dt:0:inputDic' => $ico,
            'form:dt:1:inputDic' => '',
            'form:hledej' => 'Hledej',
            'form_SUBMIT' => '1',
            'javax.faces.ViewState' => $javax_state
        );
        // build and return query 
        return http_build_query($data);
    }
    
    private function sendRequest($query)
    {
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
