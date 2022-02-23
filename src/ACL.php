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

        $modeArr = str_split(str_pad($modeStr, 4, STR_PAD_LEFT));

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

    public function getPermissionNum(array $permissionArr): int
    {
        $permissionNum = 0;
        
        if ($permissionArr['create']) {
            $permissionNum += self::CREATE;
        }

        if ($permissionArr['read']) {
            $permissionNum += self::READ;
        }

        if ($permissionArr['write']) {
            $permissionNum += self::WRITE;
        }

        if ($permissionArr['delete']) {
            $permissionNum += self::DELETE;
        }

        return $permissionNum;
    }
}