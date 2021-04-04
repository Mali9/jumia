<?php

namespace App\Helpers;

use App\Permission;
use App\UserTypePermission;

class Helper
{
    // test
    public static function upload_user_image($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $ImagePath = base_path('/uploads/users');
        $image->move($ImagePath, $imageName);
        return asset('uploads/users/') . '/' . $imageName;
    }


    public static function checkPermissions($user_type_id)
    {
        $permissions = Permission::whereHas('userTypes', function ($query) use ($user_type_id) {
            return $query->where('user_type_id', $user_type_id);
        })->pluck('permission')->toArray();
        return $permissions;
    }
}
