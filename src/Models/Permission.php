<?php

namespace Xcms\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
