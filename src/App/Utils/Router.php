<?php
/**
 * User: tuttarealstep
 * Date: 19/05/16
 * Time: 20.53
 */

namespace phpRest\App\Utils;

use \phpRest\Application;

class Router
{
    private $Application;
    private $urlFound;

    function __construct(Application $Application)
    {
        $this->Application = $Application;
        $this->urlFound = $this->getURL();
    }

    /**
     * Return the url of the visited page in an array
     *
     * @return array
     */
    public function getURL(){

        header('Cache-Control: no-cache');
        header('Pragma: no-cache');
        header("Access-Control-Allow-Origin: *");

        $url_complete = explode('/', $_SERVER['REQUEST_URI']);
        $script_complete = explode('/', $_SERVER['SCRIPT_NAME']);

        for($i = 0; $i < count($script_complete);){
            if (@$url_complete[$i] == @$script_complete[$i]){
                unset($url_complete[$i]);
            }
            $i++;
        }

        @$url_value = array_values($url_complete);

        for($i_count = 1; $i_count <= count($url_value) - 1; $i_count++){

            if(strpos($url_value[ $i_count ], "?")  !== false ) {
                @$url_get_value = explode("?", $url_value[ $i_count ]);
                $url_value[ $i_count ] = $url_get_value[0];
                unset($url_get_value[0]);
                array_splice( $url_value, $i_count + 1, 0, $url_get_value );
               // @$url_value[] = implode("&", $url_get_value);
            }

            /*if(strpos($url_value[ count($url_value) - 1 ], "?")  !== false ){

                //Found ( "?" )
                @$url_get_value = explode("?", $url_value[ count($url_value) - 1 ]);
                $url_value[ count($url_value) - 1 ] = $url_get_value[0];
                unset($url_get_value[0]);
                @$url_value[] = implode("&", $url_get_value);
            }*/

        }

        return $url_value;
    }
}