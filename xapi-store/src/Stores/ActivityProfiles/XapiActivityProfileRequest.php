<?php

namespace Trax\XapiStore\Stores\ActivityProfiles;

use Trax\XapiStore\Abstracts\XapiDocumentRequest;

class XapiActivityProfileRequest extends XapiDocumentRequest
{
    /**
     * Make a request.
     *
     * @param  array  $params
     * @param  object|array|null  $content
     * @param  string  $method
     * @return void
     */
    public function __construct(array $params, $content = null, string $method = null)
    {
        parent::__construct($params, $content, 'activity_profile', $method);
    }

    /**
     * Return the property name used to identify a document.
     *
     * @return string
     */
    public static function identifier(): string
    {
        return 'profileId';
    }

    /**
     * Get data to be recorded.
     *
     * @return array
     */
    public function data(): array
    {
        return [
            'activity_id' => $this->param('activityId'),
            'profile_id' => $this->param('profileId'),
            'data' => $this->content(),
        ];
    }
}
