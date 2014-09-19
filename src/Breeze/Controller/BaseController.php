<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 15/09/14
 * Time: 16:10
 */

namespace Breeze\Controller;


class BaseController
{
    public function __construct()
    {
        $composerCommand = 'composer';
        if (is_file('.self')) {
            if (!is_file(sys_get_temp_dir() . '/composer')) {
                exec(sprintf('php -r "readfile(\'https://getcomposer.org/installer\');" | php -- --filename=composer --install-dir=%s',sys_get_temp_dir()));
            }
            $composerCommand = sprintf('%s/composer', sys_get_temp_dir());
        }


        // Execute composer update -o to generate the
        exec(sprintf('%s update -o', $composerCommand), $output, $updateStatus);
        if ($updateStatus !== 0) {
            echo "\t[\033[1;33m\033[1m Something went wrong :\033[1;36m $composerCommand update -o \033[0m]\n\r\n\r";
            echo implode(PHP_EOL, $output);
            echo PHP_EOL.PHP_EOL;
            exit(1);
        }
    }
} 
