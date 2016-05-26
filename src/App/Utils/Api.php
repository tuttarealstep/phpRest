<?php
/**
 * User: tuttarealstep
 * Date: 19/05/16
 * Time: 21.15
 */

namespace phpRest\App\Utils;

use \phpRest\Application;

class Api
{
    private $Application;
    private $ApiPath = 'API', $ApiType = '';
    private $Request = [], $RequestData = [];

    function __construct(Application $Application)
    {
        $this->Application = $Application;
    }

    public function manageRequest()
    {
        $this->getRequest();
        $this->loadRequest();
        $this->sendRequest();
    }

    private function getRequest()
    {
        $router_url = $this->Application->getRouter()->getURL();
        //print_r($router_url);

        if(count($router_url) > 1) {
            if ($router_url[0] == 'test') {
                $this->ApiType = 'testAPI';
            } elseif($router_url[0] == $this->Application->getConfiguration('settings')['default_api_url'])
            {
                $this->ApiType = 'defaultAPI';
            }

            if(!empty($this->ApiType))
            {
                unset($router_url[0]);
                $router_url[1] = 'API_'.$router_url[1];
                $this->Request = $router_url;
            }
        }

        //print_r($router_url);
        //print_r($this->API_type);
    }

    private function loadRequest()
    {
        if($this->ApiType == 'defaultAPI'):
            $this->Load( 'App/API/defaultAPI/' , $this->Request);
        elseif($this->ApiType == 'testAPI'):
            if($this->Application->getConfiguration('settings')['enable_testAPI'])
            {
                $this->Load( 'App/API/testAPI/' , $this->Request);
            }
        endif;
    }

    function Load($path = 'App/API/defaultAPI/', $request_array = [])
    {
        $array_count = count($request_array);
        $find_path = $path;
        $array = [];

        for($i = 1; $i <= $array_count; $i++) {
            if (is_dir(R_PATH_S . $find_path . $request_array[$i])) {
                $find_path = $find_path . $request_array[$i] . '/';
            } else {
                if (is_file(R_PATH_S . $find_path . $request_array[$i] . '.php')) {
                    if ($i < $array_count) {
                        for ($i_a = $i; $i_a <= $array_count; $i_a++){
                            array_push($array, $request_array[$i_a]);
                        }
                        unset($array[0]);
                        $this->Request_Param = serialize($array);
                    }
                    $this->Request_Data =  '\\' . $this->Application->getConfiguration('settings')['project_namespace'] . '\\' . str_replace('/', '\\', $find_path . $request_array[$i]);
                    break;
                }

            }
        }
    }

    private function sendRequest($return = false)
    {
        try {
            if (!empty($this->Request_Data)):
                $sendResponse = new $this->Request_Data($this->Application);
                if(!empty($this->Request_Param)){
                    if($return)
                        return $sendResponse->api_function($this->Request_Param);
                    else
                        echo $sendResponse->api_function($this->Request_Param);
                } else {
                    if($return)
                        return $sendResponse->api_function();
                    else
                        echo $sendResponse->api_function();
                }
            endif;
        } catch (\Exception $e) {
            //todo logger
        }

        return false;
    }

    function __destruct()
    {
        $this->Request = null;
        $this->RequestData = null;
    }
}