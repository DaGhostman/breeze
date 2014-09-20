<?php
/**
 * Created by PhpStorm.
 * User: daghostman
 * Date: 20/09/14
 * Time: 00:13
 */

namespace Breeze\Controller;


use Breeze\Models\PolicyModel;

class ACLController
{
    public function addRole($arguments, $context)
    {
        $config = $context->get('config');

        $model = new PolicyModel($config['directories']['policy'] . '/roles');

        fputs(STDOUT, "Enter permission id or [done]: ");
        while (($permission = rtrim(fgets(STDIN), PHP_EOL)) != 'done') {
            $model->addPermission($permission);
            fputs(STDOUT, "Enter another permission id: ");
        }

        fputs(STDOUT, "Does the role extend another role? [skip]: ");
        if (($parent = rtrim(fgets(STDIN), PHP_EOL)) != 'skip') {
            $model->setParent($parent);
        }

        fputs(STDOUT, sprintf("Saving role %s", $arguments->get('name')));
        $model->save($arguments->get('name'));
    }

    public function addGroup($arguments, $context)
    {
        $config = $context->get('config');

        $model = new PolicyModel($config['directories']['policy'] . '/groups');

        fputs(STDOUT, "Enter permission id or [done]: ");
        while (($permission = rtrim(fgets(STDIN), PHP_EOL)) != 'done') {
            $model->addPermission($permission);
            fputs(STDOUT, "Enter another permission id: ");
        }

        fputs(STDOUT, "Does the role extend another role? [skip]: ");
        if (($parent = rtrim(fgets(STDIN), PHP_EOL)) != 'skip') {
            $model->setParent($parent);
        }

        fputs(STDOUT, sprintf("Saving role %s", $arguments->get('name')));
        $model->save($arguments->get('name'));
    }
} 
