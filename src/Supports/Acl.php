<?php

namespace Xcms\Acl\Supports;

use Illuminate\Contracts\Auth\Guard;
use Xcms\Acl\Models\AdminRole;

class Acl
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new UserHasPermission instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * 检查用户是否具有给定的权限
     *
     * @param array|string $permissions
     *
     * @return bool
     */
    public function can($permissions)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->can($permissions);
        } else {
            $guest = AdminRole::whereSlug('guest')->first();
            if ($guest) {
                return $guest->can($permissions);
            }
        }
        return false;
    }

    /**
     * 检查用户是否具有给定的权限
     *
     * @param array $permissions
     *
     * @return bool
     */
    public function canAtLeast($permissions)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->canAtLeast($permissions);
        } else {
            $guest = AdminRole::whereSlug('guest')->first();
            if ($guest) {
                return $guest->canAtLeast($permissions);
            }
        }
        return false;
    }

    /**
     * 检查用户是否被分配了给定的角色
     *
     * @param $role
     * @return bool
     * @internal param string $slug
     *
     */
    public function isRole($role)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->isRole($role);
        } else {
            if ($role === 'guest') {
                return true;
            }
        }
        return false;
    }
}
