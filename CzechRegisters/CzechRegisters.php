<?php
namespace CzechRegisters;
/**
 * <b>Main interface</b> for CzechRegisters. Contains the most important methods. <br>
 * You can also use register classes and their methods. <br>
 * @author Jonáš Petrovský <jond@post.cz>
 * @version 1.0
 */
class CzechRegisters
{
    
    private $registers = array();
    
    private $callOrder;
    
    /**
     * Creates class instance. You can specify calling order of the registers for getSubjectByXYZ methods.
     * @param string "default" (no need to enter) or "CompanyAresTrade"
     * @return CzechRegisters
     * @throws \InvalidArgumentException Given call order is not permitted.
     */
    public function __construct($callOrder = 'default')
    {
        if ($callOrder == 'default') {
            $this->callOrder = array('Trade','Company','Ares');
        }
        elseif ($callOrder == 'CompanyAresTrade') {
            $this->callOrder = array('Company','Ares','Trade');
        }
        else {
            throw new \InvalidArgumentException('Given call order is not permitted.');
        }
    }
    
    /**
     * Gets basic subject info based on ICO. Firstly search in Trade register, if nothing found in Company register, and lastly in ARES. You can change the order in constructor. 
     * @param string ICO
     * @return false|array FALSE if nothing found, else ARRAY with information - structure depends on the register.
     * @throws RegInvalidArgumentException ICO has invalid format.
     */
    public function getSubjectByIco($ico)
    {
        foreach ($this->callOrder as $regName)
        {
            $subject = $this->getRegister($regName)->getSubjectByIco($ico);
            if ($subject) {
                $subject['x_source'] = $regName;
                return $subject;
            }
        }
        return false;
    }
    
    /**
     * Searches subject by name. Returns list of matching subjects with basic info. Firstly Trade register, then Company register, lastly ARES. You can change the order in constructor.
     * @param string legal name
     * @return false|array FALSE if nothing found, else ARRAY with arrays of information - structure depends on the register.
     */
    public function getSubjectByName($name)
    {
        foreach ($this->callOrder as $regName)
        {
            $subjects = $this->getRegister($regName)->getSubjectByName($name);
            if ($subjects) {
                return $subjects;
            }
        }
        return false;
    }
    
    /**
     * Checks if address is valid - exists and is unique. If it is, returns all data about the address.
     * @param array address fields and values
     * @return false|array FALSE if address is not valid, else ARRAY with information
     * @throws RegInvalidArgumentException Input array does not contain necessary fields.
     */
    public function isAddressValid($input)
    {
        return $this->getRegister('Address')->isAddressValid($input);
    }
    
    /**
     * Checks whether the subject is VAT payer in CZ. If yes, return if it's reliable or unreliable.
     * @param string ICO
     * @return false|array FALSE if subject isn't DPH payer, else ARRAY with information
     * @throws RegInvalidArgumentException ICO has invalid format.
     */   
    public function getDphPayer($ico)
    {
        return $this->getRegister('Dph')->getDphPayer($ico);
    }
    
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
        return $this->getRegister('Vies')->isVatPayer($country_code,$company_number);
    }
    
    /**
     * Checks if the subject has a record in bancrupt (before 1. 1. 2008) or insolvency (after 1. 1. 2008) register.
     * @param type ICO
     * @return false|array FALSE if not found in neither register. ELSE array with information from one register.
     * @throws RegInvalidArgumentException ICO has invalid format.
     */
    public function hasInsolventRecord($ico)
    {
        $ceu = $this->getRegister('Ceu')->hasBancruptRecord($ico);
        if ($ceu) {
            $ceu['x_source'] = 'ceu';
            return $ceu;
        }
        $ir = $this->getRegister('Insolvency')->hasInsolventRecord('ico',$ico);
        if ($ir) {
            $ir['x_source'] = 'ir';
            return $ir;
        }
        return false;
    }
    
    /**
     * Gets register object - lazy loading. Used in CzechRegisters methods. 
     * @param string register class name (only first word)
     * @return object register object
     */
    private function getRegister($name)
    {
        $name = ucfirst($name);
        if(array_key_exists($name,  $this->registers)) {
            return $this->registers[$name];
        }
        $className = 'CzechRegisters\\'.$name.'Register';
        $this->registers[$name] = new $className();
        return $this->registers[$name];
    }
    
        
    
}
