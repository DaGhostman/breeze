<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 15/09/14
 * Time: 14:25
 */

namespace Breeze\Controller;


use Breeze\Models\ComposerModel;

class InitController
{

    public function update($arguments, $context)
    {
        $config = $context->config;
        $composer = $config->get('composer');

            if ($config->get('standalone')  && !is_file($composer)) {
                exec(sprintf('php -r "readfile(\'https://getcomposer.org/installer\');" | php -- --filename=composer --install-dir=%s',sys_get_temp_dir()));
            }

        exec(sprintf('%s update -o', $composer), $output, $updateStatus);
        if ($updateStatus !== 0) {
            echo "\t[\033[1;33m\033[1m Something went wrong :\033[1;36m $composer update -o \033[0m]\n\r\n\r";
            echo implode(PHP_EOL, $output);
            echo PHP_EOL.PHP_EOL;
            exit(1);
        }
    }

    public function create($arguments, $context)
    {
        $name = $arguments->get('name');
        $config= $context->get('config');

        mkdir(getcwd() . DIRECTORY_SEPARATOR .$config['directories']['application'], 0777);
        mkdir(getcwd() . DIRECTORY_SEPARATOR .$config['directories']['web'], 0777);
        mkdir(getcwd() . DIRECTORY_SEPARATOR .$config['directories']['source'], 0777);
        mkdir(getcwd() . DIRECTORY_SEPARATOR .$config['directories']['modules'], 0777);

        file_put_contents(
            getcwd() . DIRECTORY_SEPARATOR . $config['directories']['web'] . '/index.php',
            file_get_contents(APPLICATION_PATH . '/assets/index_php.template')
        );

        if (!is_file(getcwd() . '/composer.json')) {
            $model = new ComposerModel($name);
            $model->save();
        }

        $this->update($arguments, $context);
    }

    public function depends($arguments, $context)
    {
        $package = implode('/', $arguments->get('package'));
        $version = ($arguments->get('version') ? $arguments->get('version') : '*');

        $config = $context->get('config');

        $command = sprintf('%s require %s:%s', $config->get('composer'), $package, $version);

        exec(sprintf($command), $output, $updateStatus);
        if ($updateStatus !== 0) {
            echo "\t[\033[1;33m\033[1m Something went wrong :\033[1;36m $command \033[0m]\n\r\n\r";
            echo implode(PHP_EOL, $output);
            echo PHP_EOL.PHP_EOL;
            exit(1);
        }
    }

    public function run($arguments, $context)
    {
        $port = $arguments->get('port');
        $config = $context->get('config');

        if (strnatcmp(phpversion(),'5.4.0') < 0) {
            echo "\t\t You need at least PHP version 5.4 to use this command. Please, upgrade and try again.\n\r";
            exit(0);
        }

        echo "\t Starting server 'localhost' @ port $port use [Ctrl]+[C] to stop\n\r";
        sleep(2);
        shell_exec(sprintf(
           'php -S localhost:%d -t %s',
           $port,
           $config['directories']['web']
        ));
    }
} 
