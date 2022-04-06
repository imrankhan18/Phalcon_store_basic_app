<?php
require_once'./vendor/autoload.php';


use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Escaper;
use Phalcon\Session;
use Phalcon\Http\Response\Cookies;
use Phalcon\Logger;
use Phalcon\Events\Manager as ev;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Session\Adapter\Stream;
use App\Locale\Locale;
use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Session\Manager;
use Phalcon\Config\ConfigFactory;



$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
        
    ]
);
$loader->registerNameSpaces(
    [
        
        'App\Handle'=> APP_PATH . "/handle",
        'App\Listener'=> APP_PATH . "/listener",
        'App\Locale'=> APP_PATH . "/locale"
    ]
);
$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);



//-----------------------------------------------------url
$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);
$container->set(
    "session",
    function()
    {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;


    }
);
$application = new Application($container);

$eventsManager = new EventsManager();

$eventsManager->attach('Handle', new \App\Handle\Handle());

$eventsManager->attach(
    'application:beforeHandleRequest',
    new \App\Listener\NotificationListener()
);
$application->setEventsManager($eventsManager);
$container->set(
    'EventsManager',
    $eventsManager
);
$eventsManager->fire("event:default", new \App\Handle\Handle );


$container->set('locale', (new Locale())->getTranslator());

$container->set(
    'cache',
    function() {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);
        
        $options = [

            'lifetime'          => 7200
        ];
        
        $adapter = $adapterFactory->newInstance('apcu', $options);
        
        $cache = new Cache($adapter);
        return $cache;
    }
);

//---------------------------------------------------------------------config-------------------------------------------------
// $application = new Application($container);
$filename ='../app/config/index.php';
$factory = new ConfigFactory();
$config = $factory->newInstance("php", $filename);
$container->set(
    "config",
    $config,
    true
);
//----------------------------------------------------------------db container-----------------------------------------------------
$container->set(
    'db',
    function () {
        global $config;
        return new Mysql(
            [
                'host'=>$config->db->host,
                'username'=>$config->db->username,
                'password'=>$config->db->password,
                'dbname'=>$config->db->dbname
            ]
        );
        
    }
);

//-------------------------------------------session and coookies part start--------------------------------------------------------------------------------------


$container->set(
    "cookies",
    function()
    {
        
        $cookies=new Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    }
);



//---------------------------------------------------session and cookies part end-----------------------------------------------------------

//--------------------------------------------------escaper-------------------------------
$container = new Di();
$container->set(
    'escaper',
    function ()
    {
        return new Escaper();
    }
);
//-----------------------------------------------logger------------------------------------------------

//----------------------------------------------------------url----------------------------------------------------------------------------------------
try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
