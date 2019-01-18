<?php
namespace CzechRegisters;
/**
 * Various utility methods
 * 
 */
class RegisterUtils
{
    /**
     * Checks if ICO is valid.
     * @param string ICO
     * @return boolean
     * @throws RegInvalidArgumentException Ico has invalid format.
     */
    public static function checkIco($ico)
    {
        if (preg_match('~^\d{8}$~',$ico) == 0) {
            throw new RegInvalidArgumentException('ICO has invalid format.');
        }
        return true;
    }
                
    /**
     * Converts string from cp-1250 to UTF-8 encoding. 
     * @param string input string
     * @return string encoded string
     */        
    public static function winToUtf($string)
    {
        return iconv('WINDOWS-1250', 'UTF-8//TRANSLIT', trim($string));
    }
    
    /**
     * Gets path to temporary directory.
     * @return string path
     */
    public static function getTempDir()
    {
        return sys_get_temp_dir().DIRECTORY_SEPARATOR.'czechregs';
        //$path = realpath('..'.DIRECTORY_SEPARATOR.'xtemp'.DIRECTORY_SEPARATOR);
    }
    
}
