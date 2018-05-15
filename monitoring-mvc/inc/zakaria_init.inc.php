<?php
/*
 * Ik ga ervanuit dat dit script staat op "/mijnprogramma/inc/init.inc.php"
 * APPROOT wordt dan "/mijnprogramma", en noemen we de root van de directory structuur
 * Ik vervang de windows '\' naar een standaard '/' om alles simpel en consistent te maken.
 *
 */
define('APPROOT', str_replace('\\', '/', dirname(__DIR__)));

//Basis setup voor error handling
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Anonieme error handler
 * Deze zet notices en warnings om in Exceptions. Exceptions kun je beter catchen.
 */
set_error_handler(function ($severity, $message, $file, $line) {
	if(!(error_reporting() & $severity)) {
		// This error code is not included in error_reporting
		return;
	}
	throw new ErrorException($message, 0, $severity, $file, $line);
});

/**
 * Anonieme functie als autoloader

 * Deze wordt elke keer aangeroepen als je een class gebruikt die niet bekend is

 */
spl_autoload_register(function ($className) {
	$classRoot = APPROOT . '/classes';
	// als je classes allemaal op '.class.php' eindigen, dit even aanpassen
	$extension = '.classes.php';
	// ik gebruik hier dus niet DIRECTORY_SEPARATOR. PHP werkt prima met forward slash, en in praktijk draaien we toch altijd op Linuix
	$path = $classRoot . '/' . $className . $extension;
	/**
	 * als de file niet bestaat, doen we niks.
	 * We laden de vereiste class dan niet maar geven ook geen foutmelding
	 * Zo kan er eventueel een andere autoloader aan het werk gaan om deze class toch te loaden, of kan het script zelf de fout oplossen
	 */
	if(file_exists($path)) {
		require $path;
	} else {
		echo $path;
	}
});

/**
 * Deze functie wordt aangeroepen wanneer er een exception komt die niet is afgevangen door een 'catch'
 */
set_exception_handler(function($exception) {
	$exception instanceof Exception;

	http_response_code(500);
	//ik ga ervanuit dat we HTML uitvoeren. Dat is niet altijd een geldige aanname
	echo "<pre>\n";
	echo "[[[Fatale uitzondering]]]\n\n";
	echo $exception;
	die();
});
