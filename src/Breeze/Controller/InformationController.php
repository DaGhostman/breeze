<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 14/09/14
 * Time: 03:44
 */

namespace Breeze\Controller;


class InformationController
{
    public function moduleHelp()
    {
        echo "Documentation @ https://github.com/phpAcorn/wave-framework/wiki/Modules\n\r";
        echo " breeze module [\033[1;33m\033[1m create \033[0m|\033[1;33m\033[1m delete \033[0m] module-name\n\r";
        echo "\t 1. \033[1;36m create \033[0m - Create a module\n\r";
    }

    public function applicationHelp()
    {
        echo " breeze application [\033[1;33m\033[1m create \033[0m|\033[1;33m\033[1m update \033[0m] NAME\n\r";
        echo "\t 1. \033[1;36m create APPLICATION_NAME\033[0m - Creates the default application structure\n\r";
        echo "\t 2. \033[1;36m update \033[0m - Updates the dependencies of the application\n\r";
        echo "\t 3. \033[1;36m run port \033[0m - Starts the build-in web server PHP >= 5.4\n\r";
        echo "\t\t --------\n\r";
        echo "\t These arguments are available only with 'create' and 'update'\n\r\n\r";
        echo "\t\t --------\n\r";
        echo "\t \033[1;36m --application-root \$path\033[0m - Defines application directory.\n\r";
        echo "\t \033[1;36m --web-root \$path\033[0m - Defines web root directory.\n\r";
        echo "\t \033[1;36m --source-root \$path\033[0m - Defines source code root directory.\n\r";
        echo "\t \033[1;36m --modules-root \$path\033[0m - Defines modules root directory.\n\r";
    }

    public function mainHelp()
    {
        echo 'Available arguments:'.PHP_EOL;
        echo "\t \033[1;36m --self-contain \033[0m - Download composer to system's temp dir and use it.\n\r";
        echo "\t \033[1;36m --global \033[0m - Attempt to use the global composer system installation.\n\r";
        echo "\n\r\t-----------------\n\r";
        echo "\t module - Creates and deletes application modules. For information use\033[1;36m breeze \033[1;33m\033[1mmodule\033[0m\n\r";
        echo "\t controller - Creates and deletes controllers. For information use\033[1;36m breeze \033[1;33m\033[1mcontroller\033[0m\n\r";
        echo "\t application - Instantiates new application. For information use\033[1;36m breeze \033[1;33m\033[1mapplication\033[0m\n\r\n\r";
    }

    public function controllerHelp()
    {
        echo "Documentation @ https://github.com/phpAcorn/wave-framework/wiki/Simple-application\n\r";
        echo " breeze controller [\033[1;33m\033[1m create \033[0m] pattern methods \"callback\" module\n\r";
        echo "\t 1. \033[1;36m create \033[0m - Create a controller\n\r";
        echo "\t\t ------ \n\r";
        echo "\t 1. \033[1;36m pattern \033[0m - The URI pattern for the controller\n\r";
        echo "\t 2. \033[1;36m methods \033[0m - Methods for the controller if multiple, delimited by semi-colon. Eg. 'GET;POST'\n\r";
        echo "\t 3. \033[1;36m callback \033[0m - The callback for the controller: \\Some\\Class;method\n\r";
        echo "\t 4. \033[1;36m module \033[0m - Module to which the controller should be attached\n\r";
        echo "\t 5. \033[1;36m handler \033[0m - Optional. Use custom controller handler with the route\n\r";
        echo "\t\t ------ \n\r";
        echo "\t 1. \033[1;36m --with-conditions [Optional]\033[0m - Prepares the controller for conditions definition\n\r";
        echo "\t 2. \033[1;36m --handler [Optional]\033[0m - The class handling the controller\n\r";
    }
} 
