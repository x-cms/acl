<?php

namespace Xcms\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
}
