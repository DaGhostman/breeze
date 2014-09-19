<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 15/09/14
 * Time: 23:32
 */

namespace Breeze\Models;


use Wave\Framework\Storage\Registry;

class ConfigurationModel extends Registry
{
    private $defaults = array(
        'standalone' => false,
        'directories' => array(
            'application' => 'application/',
            'web' => 'web/',
            'source' => 'src/',
            'modules' => 'application/modules/'
        ),
        'composer' => 'composer'
    );


    public function __construct()
    {
        $this->mutable = true;
        $this->replace = true;

        if (!is_file('.breeze.json')) {
            touch('.breeze.json');
            $this->storage = $this->defaults;
        } else {
            $this->storage = json_decode(file_get_contents('.breeze.json'), true);
        }
    }

    public function __destruct()
    {
        if (is_file('.breeze.json')) {
            unlink('.breeze.json');
        }

        touch('.breeze.json');
        file_put_contents('.breeze.json', json_encode($this->storage));
    }
} 
