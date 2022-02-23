<?php
namespace Mas\Acl;

use Mas\Acl\Exceptions\InvalidModeInput;

class ACL 
{
    const CREATE = 8;
    const READ = 4;
    const WRITE = 2;
    const DELETE = 1;

    const MAPPING_STATE = [
        self::CREATE => 'create',
        self::READ => 'read',
        self::WRITE => 'write',
        self::DELETE => 'delete',
    ];

    public static function getState(?int $mode): array
    {
        if ($mode > 15 || is_null($mode)) {
            throw new InvalidModeInput($mode);
        }

        $modeStr = decbin($mode);
        $permissions = [];

        $modeArr = str_split(str_pad($modeStr, 4, 0, STR_PAD_LEFT));

        array_walk($modeArr, function ($it, $key) use (&$permissions){
            if ($it) {
                switch ($key) {
                    case 0:
                        $permissions[] = 'create';
                        break;
                    case 1:
                        $permissions[] = 'read';
                        break;
                    case 2:
                        $permissions[] = 'write';
                        break;
                    case 3:
                        $permissions[] = 'delete';
                        break;
                }
            }
        });

        return $permissions;
    }

    public static function getPermissionNum(string ...$permissions): int
    {
        $permissionNum = 0;
        
        $permissionNum += in_array(
            self::MAPPING_STATE[self::CREATE], $permissions
        ) ? self::CREATE : 0;
        
        $permissionNum += in_array(
            self::MAPPING_STATE[self::READ], $permissions
        ) ? self::READ : 0;

        $permissionNum += in_array(
            self::MAPPING_STATE[self::WRITE], $permissions
        ) ? self::WRITE : 0;

        $permissionNum += in_array(
            self::MAPPING_STATE[self::DELETE], $permissions
        ) ? self::DELETE : 0;


        return $permissionNum;
    }
}