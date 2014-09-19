<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 15/09/14
 * Time: 18:36
 */

namespace Breeze\Controller;


class ControllerController
{
    /**
     * @param $arguments \Wave\Framework\Application\Contexts\ArgumentsContext
     * @param $context \Wave\Framework\Storage\Registry
     */
    public function create($arguments, $context)
    {
        $config = $context->get('config');

        $via = $arguments->get('methods');
        list($controller, $method) = explode(';', trim($arguments->get('callback'), '"'));
        $module = $arguments->get('module');

        $pattern = $config['modules'][$module] . implode('/', $arguments->get('pattern'));


        if (!is_null($module) && is_readable(sprintf(getcwd() . '/application/modules/%s.xml', $module))) {

            $xml = new \SimpleXMLElement(sprintf(getcwd() . '/application/modules/%s.xml', $module), null, true);

            /**
             * @var $child \SimpleXMLElement
             */
            foreach ($xml->children() as $child)
            {
                if ($child['pattern'] == $pattern && $child['method'] == $method) {
                    echo sprintf("\t Error route already exists in module '%s'\n\r\n\r", $module);
                    exit(1);
                }
            }

            $route = $xml->addChild('route');
            $route->addAttribute('pattern', $pattern);
            $route->addAttribute('via', $via);
            $route->addAttribute('method', $method);
            $route->addAttribute('controller', $controller);

            $xml->saveXML(sprintf(getcwd() . '/application/modules/%s.xml', $module));
        }
    }
} 
