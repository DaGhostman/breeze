<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 14/09/14
 * Time: 03:44
 */

namespace Breeze\Controller;

class ModuleController
{
    public function create($arguments, $context)
    {

        $name = $arguments->get('name');


        $prefix = implode('/', $arguments->get('prefix'));

        $config = $context->get('config');

        if (is_file(sprintf(
            getcwd() . DIRECTORY_SEPARATOR . $config['directories']['modules'] . '/%s.xml',
            $name
        ))) {
            echo sprintf("\t The module '%s' already exists.\n\r\n\r", $name);
            exit(0);
        }

        $file = file_get_contents(getcwd() . DIRECTORY_SEPARATOR . $config['directories']['web'] . '/index.php');
        $file = str_replace(
            "### NewModule",
            sprintf(
                "new \\Wave\\Framework\\Application\\Module(\$app, \"%s\", \"%s\", \"%s\");\n\r### NewModule",
                $name,
                getcwd() . DIRECTORY_SEPARATOR .$config['directories']['modules'],
                $prefix
            ),
            $file
        );

        unlink(getcwd() . DIRECTORY_SEPARATOR . $config['directories']['web'] . '/index.php');
        file_put_contents(getcwd() . DIRECTORY_SEPARATOR .$config['directories']['web'] . '/index.php', $file);


        touch(sprintf(getcwd() . '/application/modules/%s.xml', $name));
        $xml = new \DOMDocument('1.0', 'utf-8');
        $routes = $xml->createElement('routes');
        $xml->appendChild($routes);
        file_put_contents(sprintf(getcwd() . '/application/modules/%s.xml', $name), $xml->saveXML());
    }
} 
