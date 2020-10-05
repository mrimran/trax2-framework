<?php

namespace Trax\XapiStore\Permissions;

use Trax\Auth\Permissions\Permission;

class StateMineAccessPermission extends Permission
{
    /**
     * The permission lang key: you MUST override this property.
     *
     * @var string
     */
    protected $langKey = 'trax-xapi-store::permissions.state_mine_access';

    /**
     * The permission capabilities: you MUST override this property.
     *
     * @var array
     */
    protected $capabilities = [
        'state.read.access', 'state.write.access', 'state.delete.access',
    ];

    /**
     * Is the permission for users: you SHOULD override this property.
     *
     * @var array
     */
    protected $supportedConsumerTypes = ['app'];
}
