<?php


use Breeze\Controller\InformationController;
use Breeze\Models\ConfigurationModel;
use Wave\Framework\Application\Core;
use Wave\Framework\Application\Module;
use Wave\Framework\Http\Request;


require '../vendor/autoload.php';

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', __DIR__ . '/..');
}

$config = new ConfigurationModel();

if (in_array('--self-contained', $argv) &&
    ($key = array_search('--self-contained', $argv))) {

    $config->set('standalone', true);
    $config->set('composer', sys_get_temp_dir() . '/composer');
    unset($argv[$key]);
}

if ($key = array_search('--global', $argv)) {
    $config->set('standalone', false);
    $config->set('composer', 'composer');
    unset($argv[$key]);
}

if (in_array('create', $argv) || in_array('update', $argv)) {

    if (in_array('--application-root', $argv)) {
        $key = array_search('--application-root', $argv);
        $dirs = $config->get('directories');
        $dirs['application'] = $argv[$key+1];
        $config->set('directories', $dirs);

        unset($argv[$key]);
        unset($argv[$key+1]);
    }

    if (in_array('--web-root', $argv)) {
        $key = array_search('--webs-root', $argv);
        $dirs = $config->get('directories');
        $dirs['web'] = $argv[$key+1];
        $config->set('directories', $dirs);

        unset($argv[$key]);
        unset($argv[$key+1]);
    }

    if (in_array('--modules-root', $argv)) {
        $key = array_search('--modules-root', $argv);
        $dirs = $config->get('directories');
        $dirs['modules'] = $argv[$key+1];
        $config->set('directories', $dirs);

        unset($argv[$key]);
        unset($argv[$key+1]);
    }

    if (in_array('--source-root', $argv)) {
        $key = array_search('--source-root', $argv);
        $dirs = $config->get('directories');
        $dirs['application'] = $argv[$key+1];
        $config->set('directories', $dirs);

        unset($argv[$key]);
        unset($argv[$key+1]);
    }
}



array_shift($argv);
$path = implode('/', $argv);

$server = array(
    'REQUEST_URI' => '/'.$path,
    'REQUEST_METHOD' => 'CLI'
);

$app = new Core();

$app->notFound('/404', function() {
    $ctrl = new InformationController();
    $ctrl->mainHelp();
});

$app->controller('/', 'CLI', function () {
    echo "\t\tBreeze - A command-line client for Wave Framework version >= 2.1\n\r";
    $ctrl = new \Breeze\Controller\InformationController();
    $ctrl->mainHelp();
});


new Module($app, 'module', APPLICATION_PATH . '/application/modules', '/module'); // Creation of modules
new Module($app, 'controller', APPLICATION_PATH . '/application/modules', '/controller'); // Creation of controllers
new Module($app, 'application', APPLICATION_PATH . '/application/modules', '/application'); // Project instantiation
new Module($app, 'policy', APPLICATION_PATH . '/application/modules', '/policy'); // Project instantiation

$app->run(new Request($server), null, array(
   'config' => $config
));




