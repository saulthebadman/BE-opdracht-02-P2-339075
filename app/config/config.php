<?php
/**
 * De database verbindingsgegevens
 */
define('DB_HOST', 'localhost'); // De host blijft localhost bij gebruik van WAMP
define('DB_NAME', 'opdracht database jamin'); // Naam van je database
define('DB_USER', 'root'); // Standaard gebruiker in WAMP
define('DB_PASS', ''); // Geen wachtwoord standaard bij WAMP

/**
 * De naam van de virtualhost
 */
define('URLROOT', 'http://opdrachtarjan/'); // Nieuwe URL van je site

/**
 * Het pad naar de folder app
 */
define('APPROOT', dirname(dirname(__FILE__)));
