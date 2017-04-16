<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

/**
 * Class Permission
 * @package App
 */
class Permission extends EntrustPermission
{
    protected $table = 'permission';
}