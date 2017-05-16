<?php

namespace Xcms\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class AdminPermission extends Model
{
    use NestableTrait;

    protected $table = 'admin_permissions';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $parent = 'parent_id';

    /**
     * 权限可以属于许多角色
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_permission_role', 'permission_id', 'role_id');
    }
}
