<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 20/09/14
 * Time: 00:15
 */

namespace Breeze\Models;


class PolicyModel
{
    protected $permissions = array();
    protected $parent = null;
    public function __construct($directory)
    {
        if (!is_dir(getcwd() . DIRECTORY_SEPARATOR .$directory)) {
            fputs(STDOUT, sprintf("\n\r\tSupplied directory '%s' is not a valid directory\n\r", $directory));
        }
        $this->directory = $directory;
    }

    public function addPermission($id)
    {
        fputs(STDOUT, sprintf("\t Pushing permission '%s'\n\r", $id));
        array_push($this->permissions, $id);
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function save($filename)
    {
        $string = json_encode(array('permissions' => $this->permissions, 'extends' => $this->parent));
        $fp = fopen(sprintf('%s/%s/%s.json', getcwd(), $this->directory, $filename), 'w+b');
        flock($fp, LOCK_EX | LOCK_NB);
        fwrite($fp, $string, strlen($string));
        flock($fp, LOCK_UN);
        fclose($fp);
    }
} 
