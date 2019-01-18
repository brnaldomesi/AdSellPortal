<?php
// zdroj: www.nabito.net/autoload-v-php/
// DS - oddelovac pro adresare
define ('DS', DIRECTORY_SEPARATOR);

// absolutní cesta k tomuto souboru
define ('ABSPATH', __DIR__.DS);

// nastavíme do include path potřebné cesty ke všem třídám
set_include_path (
    ABSPATH.'libs'.DS.PATH_SEPARATOR.       // knihovny
    ABSPATH.'registers'.DS.PATH_SEPARATOR.  // třídy registrů
    ABSPATH.'helpers'.DS.PATH_SEPARATOR.    // pomocné třídy
    get_include_path()
);

// autoload "magická" funkce
function __autoload($class_name)
{
    if (!class_exists($class_name, false) OR !interface_exists($class_name, false))
    {
        // obsahuje název třídy namespace?
        $slashPos = strrpos($class_name, '\\');
        if ($slashPos) {
            $class_name = substr($class_name, $slashPos+1);
        }
        require_once ($class_name.'.php');
    } 
}



