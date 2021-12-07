<?php

namespace Trax\XapiStore\Permissions;

use Trax\Auth\Permissions\Permission;

class DataManagerPermission extends Permission
{
    /**
     * The permission lang key: you MUST override this property.
     *
     * @var string
     */
    protected $langKey = 'trax-xapi-store::permissions.manage';

    /**
     * The permission capabilities: you MUST override this property.
     *
     * @var array
     */
    protected $capabilities = [
        'statement.read.entity', 'statement.write.entity', 'statement.delete.entity',
        'state.read.owner', 'state.write.owner', 'state.delete.owner',
        'activity_profile.read.owner', 'activity_profile.write.owner', 'activity_profile.delete.owner',
        'agent_profile.read.owner', 'agent_profile.write.owner', 'agent_profile.delete.owner',
        'attachment.read.entity', 'attachment.write.entity', 'attachment.delete.entity',
        'activity.read.owner', 'activity.write.owner', 'activity.delete.owner',
        'agent.read.owner', 'agent.write.owner', 'agent.delete.owner',
        'person.read.owner', 'person.write.owner', 'person.delete.owner',
        'verb.read.owner', 'verb.write.owner', 'verb.delete.owner',
        'activity_type.read.owner', 'activity_type.write.owner', 'activity_type.delete.owner',
        'statement_category.read.owner', 'statement_category.write.owner', 'statement_category.delete.owner',
        'log.read.owner', 'log.write.owner', 'log.delete.owner',

        'entity.read.owner',    // For filtering
        'client.read.owner',    // For filtering
    ];

    /**
     * Is the permission for users: you SHOULD override this property.
     *
     * @var array
     */
    protected $supportedConsumerTypes = ['user', 'app'];
}
