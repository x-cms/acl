<?php

namespace Xcms\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_roles';

    protected $primaryKey = 'id';

    protected $guarded = [];

    /**
     * 角色可以属于许多用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(AdminUser::class, 'admin_role_user', 'role_id', 'user_id');
    }

    /**
     * 角色可以拥有许多权限
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_permission_role', 'role_id', 'permission_id');
    }

}
