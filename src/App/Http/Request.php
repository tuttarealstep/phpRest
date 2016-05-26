<?php
/**
 * User: tuttarealstep
 * Date: 20/05/16
 * Time: 12.07
 */

namespace phpRest\App\Http;

class Request
{
    private $Method;
    private $Request;
    private $Server;

    private $ContentType;
    private $ResponseCode;

    function __construct()
    {
        $this->initialize();
    }

    private function initialize()
    {
        $this->setMethod();

        $this->setRequest();

        $this->setResponseContentType();

        $this->setResponseCode();

        $this->setServer();

    }

    private function setMethod()
    {
        $this->Method = $_SERVER['REQUEST_METHOD'];
    }

    private function setRequest(bool $json_decode = true)
    {
        if($json_decode)
        {
            $this->Request = json_decode(file_get_contents('php://input'), true);
        } else {
            $this->Request = file_get_contents('php://input');
        }
    }

    public function setResponseContentType(string $ContentType = '')
    {
        if(!empty($ContentType))
        {
            $this->ContentType = $ContentType;
        } else {
            $this->ContentType = 'application/json';
        }
    }

    public function setResponseCode(int $ResponseCode = 200)
    {
        if($ResponseCode != 200)
        {
            $this->ResponseCode = $ResponseCode;
        } else {
            $this->ResponseCode = 200;
        }
    }

    private function setServer()
    {
        $this->Server = $_SERVER;
    }

    public function sendResponse()
    {
        http_response_code($this->ResponseCode);
        header('Content-Type: ' . $this->ContentType);
    }

    public function isGET()
    {
        if($this->Method === "GET")
        {
            return true;
        }

        return false;
    }

    public function isPOST()
    {
        if($this->Method === "POST")
        {
            return true;
        }

        return false;
    }

    public function isPUT()
    {
        if($this->Method === "PUT")
        {
            return true;
        }

        return false;
    }

    public function isDELETE()
    {
        if($this->Method === "DELETE")
        {
            return true;
        }

        return false;
    }

    function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest")
        {
            return true;
        }

        return false;
    }

    function getServer(string $variable = '')
    {
        if(!empty($variable))
        {
            return $this->Server[$variable];
        } else {
            return $this->Server;
        }
    }

    public function getMethod()
    {
        return $this->Method;
    }

    public function getRequest()
    {
        return $this->Request;
    }


}