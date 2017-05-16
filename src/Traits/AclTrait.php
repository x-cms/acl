<?php

namespace Xcms\Acl\Traits;

use Xcms\Acl\Models\AdminRole;

trait AclTrait
{
    /**
     * 用户可以有很多角色
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_role_user', 'user_id', 'role_id');
    }

    /**
     * 获取所有用户角色
     *
     * @return array|null
     */
    public function getRoles()
    {
        if (!is_null($this->roles)) {
            return $this->roles->pluck('slug')->all();
        }
    }

    /**
     * 用户是否超级管理员
     */
    public function isSuperAdmin()
    {
        return $this->is_supper;
    }

    /**
     * 检查用户是否具有给定的角色
     *
     * @param string $slug
     *
     * @return bool
     */
    public function hasRole($slug)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $slug = strtolower($slug);
        foreach ($this->roles as $role) {
            if ($role->slug == $slug) {
                return true;
            }
        }
        return false;
    }

    /**
     * 将给定的角色分配给用户
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
     * 撤消用户给定的角色
     *
     * @param int|string $roleId
     * @return bool
     */
    public function revokeRole($roleId = '')
    {
        return $this->roles()->detach($roleId);
    }

    /**
     * 与用户同步给定的角色
     *
     * @param array $roleIds
     *
     * @return array
     */
    public function syncRoles(array $roleIds)
    {
        return $this->roles()->sync($roleIds);
    }

    /**
     * 撤销用户的所有角色
     *
     * @return bool
     */
    public function revokeAllRoles()
    {
        return $this->roles()->detach();
    }

    /**
     * 获取所有用户角色权限
     *
     * @return array|null
     */
    public function getPermissions()
    {
        $permissions = [[], []];
        foreach ($this->roles as $role) {
            $permissions[] = $role->getPermissions();
        }
        return call_user_func_array('array_merge', $permissions);
    }

    /**
     * 检查用户是否有给定的权限
     *
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $can = false;
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                $can = true;
            }
        }
        return $can;
    }

    /**
     * 检查用户是否具有至少一个给定的权限
     *
     * @param array $permissions
     *
     * @return bool
     */
    public function canAtLeast(array $permissions)
    {
        $can = false;
        foreach ($this->roles as $role) {
            if ($role->special === 'no-access') {
                return false;
            }
            if ($role->special === 'all-access') {
                return true;
            }
            if ($role->canAtLeast($permissions)) {
                $can = true;
            }
        }
        return $can;
    }
    /*
    |----------------------------------------------------------------------
    | Magic Methods
    |----------------------------------------------------------------------
    |
    */
    /**
     * Magic __call method to handle dynamic methods.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments = [])
    {
        // Handle isRoleslug() methods
        if (starts_with($method, 'is') and $method !== 'is') {
            $role = substr($method, 2);
            return $this->hasRole($role);
        }
        // Handle canDoSomething() methods
        if (starts_with($method, 'can') and $method !== 'can') {
            $permission = substr($method, 3);
            return $this->can($permission);
        }
        return parent::__call($method, $arguments);
    }
}
