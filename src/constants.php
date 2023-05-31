<?php
// database information
define('dbHost','mysql');
define('dbUsername','root');
define('dbPW','Abc123$');
define('dbDB','OnlineStore');

// the relative path to project
define('__ROOT__', dirname(dirname(__FILE__))); 

/**
 * This is the DEBUG option 
 * 
 * Please be SURE to deactivate it going in prod.
 * It shows more information about everything, including the connection,
 * database, code...
 */
define('__DEBUG__',false);

// absolute link to images in server
define('srvimg', __ROOT__.'/public/img/');