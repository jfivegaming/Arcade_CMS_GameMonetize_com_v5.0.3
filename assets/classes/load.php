<?php

function classes_load($className) {
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
    	$namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);

        if ($namespace == "GameMonetizeTrait") {
	    	$fileName = dirname(dirname(dirname( __FILE__ )))."/assets/classes/traits/";
	    } else {
            $fileName = dirname(dirname(dirname( __FILE__ )))."/assets/classes/";
        }
    }

    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className);

    if ($namespace == "GameMonetize") {
    	$fileName .= ".class.php";
    } elseif ($namespace == "GameMonetizeTrait") {
    	$fileName .= ".trait.php";
    }

    require $fileName;
}

spl_autoload_register('classes_load');