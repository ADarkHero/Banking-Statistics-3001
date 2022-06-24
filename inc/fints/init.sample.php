<?php

/** @noinspection PhpUnhandledExceptionInspection */

/**
 * SAMPLE - Creates a new FinTs instance. This file mainly contains the configuration data for the phpFInTS library.
 */
require 'vendor/autoload.php';

// The configuration options up here are considered static wrt. the library's internal state and its requests.
// That is, even if you persist the FinTs instance, you need to be able to reproduce all this information from some
// application-specific storage (e.g. your database) in order to use the phpFinTS library.
$options = new \Fhp\Options\FinTsOptions();
$options->url = 'https://hbci11.fiducia.de/cgi-bin/hbciservlet'; // HBCI / FinTS Url can be found here: https://www.hbci-zka.de/institute/institut_auswahl.htm (use the PIN/TAN URL)
$options->bankCode = '50031000'; // Your bank code / Bankleitzahl
$options->productName = ''; // The number you receive after registration / FinTS-Registrierungsnummer
$options->productVersion = '1.0'; // Your own Software product version
$credentials = \Fhp\Options\Credentials::create('', ''); // This is NOT the PIN of your bank card!
$fints = \Fhp\FinTs::new($options, $credentials);
//$fints->setLogger(new \Tests\Fhp\CLILogger());

// Usage:
// $fints = require_once 'init.php';
return $fints;
