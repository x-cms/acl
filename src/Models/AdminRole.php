<?php

namespace Xcms\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_roles';

    protected $primaryKey = 'id';

    protected $fillable = [];

    /**
     * 模型使用的缓存标签
     *
     * @var string
     */
    protected $tag = 'admin.roles';

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

    /**
     * 获得分配给角色的权限
     *
     * @return array
     */
    public function getPermissions()
    {
        $primaryKey = $this[$this->primaryKey];
        $cacheKey = 'xcms.acl.permissions.' . $primaryKey;
        if (method_exists(app()->make('cache')->getStore(), 'tags')) {
            return app()->make('cache')->tags($this->tag)->remember($cacheKey, 60, function () {
                return $this->permissions()->pluck('slug')->all();
            });
        }
        return $this->permissions()->pluck('slug')->all();
    }

    /**
     * 刷新权限缓存存储库
     *
     * @return void
     */
    public function flushPermissionCache()
    {
        if (method_exists(app()->make('cache')->getStore(), 'tags')) {
            app()->make('cache')->tags($this->tag)->flush();
        }
    }

    /**
     * 检查角色是否具有给定的权限
     *
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->special === 'no-access') {
            return false;
        }
        if ($this->special === 'all-access') {
            return true;
        }
        $permissions = $this->getPermissions();
        if (is_array($permission)) {
            $permissionCount = count($permission);
            $intersection = array_intersect($permissions, $permission);
            $intersectionCount = count($intersection);
            return ($permissionCount == $intersectionCount) ? true : false;
        } else {
            return in_array($permission, $permissions);
        }
    }

    /**
     * 检查角色是否至少有一个给定的权限
     *
     * @param array $permission
     *
     * @return bool
     */
    public function canAtLeast(array $permission = [])
    {
        if ($this->special === 'no-access') {
            return false;
        }
        if ($this->special === 'all-access') {
            return true;
        }
        $permissions = $this->getPermissions();
        $intersection = array_intersect($permissions, $permission);
        $intersectionCount = count($intersection);
        return ($intersectionCount > 0) ? true : false;
    }

    /**
     * 为角色分配给定的权限
     *
     * @param int $permissionId
     *
     * @return void|bool
     */
    public function assignPermission($permissionId = null)
    {
        $permissions = $this->permissions;
        if (!$permissions->contains($permissionId)) {
            $this->flushPermissionCache();
            return $this->permissions()->attach($permissionId);
        }
        return false;
    }

    /**
     * 撤销角色给定的权限
     *
     * @param int|string $permissionId
     * @return bool
     */
    public function revokePermission($permissionId = '')
    {
        $this->flushPermissionCache();
        return $this->permissions()->detach($permissionId);
    }

    /**
     * 同步该角色给定的权限.
     *
     * @param array $permissionIds
     *
     * @return array
     */
    public function syncPermissions(array $permissionIds = [])
    {
        $this->flushPermissionCache();
        return $this->permissions()->sync($permissionIds);
    }

    /**
     * 撤销角色的所有权限
     *
     * @return bool
     */
    public function revokeAllPermissions()
    {
        $this->flushPermissionCache();
        return $this->permissions()->detach();
    }

}
