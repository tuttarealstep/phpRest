<?php
/**
 * User: tuttarealstep
 * Date: 19/05/16
 * Time: 19.29
 */

namespace phpRest;

define( 'R_PATH_S', __DIR__ . '/' );

return call_user_func(
    function()
    {
        mb_internal_encoding('UTF-8');
        mb_http_output('UTF-8');

        $_R_PATH = realpath(__DIR__ . '/..');

        require $_R_PATH . '/vendor/autoload.php';

        /* Load configuration file */
        if ( file_exists( $_R_PATH . '/src/App/Configuration/Config.php') ) {
            $config = [];
            require_once($_R_PATH . '/src/App/Configuration/Config.php');
        } else {
            $config = null;
        }

        $Application = new Application(["settings" => $config]);
        return $Application;
    }
);