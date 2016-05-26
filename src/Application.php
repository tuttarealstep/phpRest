<?php
/**
 * User: tuttarealstep
 * Date: 19/05/16
 * Time: 19.29
 */

namespace phpRest;

use \Monolog\Handler\StreamHandler;
use \Monolog\Logger;
use \phpRest\App\Http\Request;
use \phpRest\App\Utils\Router;
use \phpRest\App\Utils\Api;

class Application
{
    private $configuration;
    private $logger;
    private $router;
    private $request;
    private $api;

    function __construct(Array $configuration)
    {
        $this->configuration = $configuration;

        $this->configuration['phpRest_version'] = '1.0';

        /* Initialize */
        $this->initialize();
    }

    private function initialize()
    {

        if($this->getConfiguration('settings')['debugMODE'] === false)
        {
            error_reporting(E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING);
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        /* Initialize Logger */
        $this->init_logger();

        /* Set locale (default_time_zone ...) */
        $this->init_locale();

        /* Initialize Database */
        $this->init_database();

        /* Initialize Router */
        $this->init_router();

        /**
         * Initialize restAPI
         * For load useful functions
         */
        $this->init_restAPI();

        /**
         * Initialize Api
         * For load api file
         */
        $this->init_api();
    }

    /**
     * Return configuration array with all configurations
     * @return array
     */
    public function getConfiguration(string $configuration_layer_name = null)
    {
        if(!empty($configuration_layer_name))
        {
            return $this->configuration[$configuration_layer_name];
        } else {
            return $this->configuration;
        }
    }

    private function init_logger()
    {
        $this->logger = function()
        {
            $logger = new Logger('phpRest');
            $file_handler = new StreamHandler("src/App/Storage/Logs/application.log");
            $logger->pushHandler($file_handler);
            return $logger;
        };
    }

    private function init_locale()
    {
        date_default_timezone_set($this->getConfiguration('settings')['locale']['timezone'] ?: ini_get('date.timezone') ?: 'UTC');
    }

    private function init_database()
    {

    }

    private function init_router()
    {
        $this->router = new Router($this);
    }

    private function init_restAPI()
    {
        $this->request = new Request();
    }

    private function init_api()
    {
        $this->api = new Api($this);
    }

    public function run()
    {
        $this->api->manageRequest();
        $this->request->sendResponse();
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getApi()
    {
        return $this->api;
    }
}