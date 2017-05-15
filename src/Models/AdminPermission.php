<?php

namespace Xcms\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $table = 'admin_permissions';

    protected $primaryKey = 'id';

    protected $fillable = [];

    /**
     * 权限可以属于许多角色
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_permission_role', 'permission_id', 'role_id');
    }

    /**
     * 将给定的角色分配给权限
     *
     * @param int $roleId
     *
     * @return bool
     */
    public function assignRole($roleId = null)
    {
        $roles = $this->roles;
        if (!$roles->contains($roleId)) {
            return $this->roles()->attach($roleId);
        }
        return false;
    }

    /**
     * 从授权中撤销给定的角色
     *
     * @param int|string $roleId
     * @return bool
     */
    public function revokeRole($roleId = '')
    {
        return $this->roles()->detach($roleId);
    }

    /**
     * 同步通过许可的角色
     *
     * @param array $roleIds
     *
     * @return array
     */
    public function syncRoles(array $roleIds = [])
    {
        return $this->roles()->sync($roleIds);
    }

    /**
     * 从权限撤销所有角色
     *
     * @return bool
     */
    public function revokeAllRoles()
    {
        return $this->roles()->detach();
    }
}
