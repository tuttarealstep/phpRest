<?php
/**
 * User: tuttarealstep
 * Date: 19/05/16
 * Time: 19.32
 */

/*
* Database Settings
*/
$config['database']['host'] = "localhost";
$config['database']['user'] = "root";
$config['database']['password'] = "";
$config['database']['name'] = "";

/*
 * Locale Settings
 */
$config['locale']['timezone'] = "Europe/Rome";

/*
 *  Security
 */
$config['ShowFullError'] = true; //Warning if true this can return private information like database password or others things! || ---
$config['debugMODE'] = true; //true = on / false = off || ----
$config['enable_testAPI'] = true;

/*
 * EXPERT MODE
 */
$config['project_namespace'] = 'phpRest';
$config['default_api_url'] = 'api';
$config['json_request'] = true;