<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 15/09/14
 * Time: 17:37
 */

namespace Breeze\Models;

class ComposerModel
{
    private $name = null;
    private $json = array();

    public function __construct($name){
        $this->name =$name;
        $this->json = array(
            "name" => sprintf('%s/%s', $name, $name),
            "description" => "Wave Framework application",
            "minimal-stability" => 'stable',
            "require" => array(
                "wave/wave" => ">=2.0"
            ),
            "autoload" => array(
                "psr-0" => array(
                    $name.'\\' => 'src\\',
                    'Ext\\' => 'src\\'
                )
            )
        );
    }

    public function save()
    {
        $fp = fopen(getcwd() . '/composer.json', 'a+');
        flock($fp, LOCK_EX);
        fwrite($fp, json_encode($this->json));
        flock($fp, LOCK_UN);
        fclose($fp);
    }
} 
