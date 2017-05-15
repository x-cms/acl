<?php

namespace Xcms\Acl\Facades;

use Illuminate\Support\Facades\Facade;

class AclFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'your-module-accessor';
    }
}
