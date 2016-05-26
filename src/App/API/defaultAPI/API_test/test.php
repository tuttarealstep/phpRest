<?php
/* Example and test */

namespace phpRest\App\API\defaultAPI\API_test;

class test
{
    private $Application;
    private $Request;


    function __construct($Application)
    {
        $this->Application = $Application;
        $this->Request = new \phpRest\App\Http\Request();
    }

    function api_function($data = null)
    {
        $this->Request->setResponseContentType("text/html");
        $data = unserialize($data);
        print_r($data);


        print_r($this->Request->getRequest());
    }

}