<?php

namespace Framework;

class Authorization
{
    /**
     * Check if current logged in user owns the a resource
     *
     * @param int $resourceId
     * @return bool
     */
    public static function isOwner($resourceId)
    {
        $sessionUser = Session::get('user');

        if (!empty($sessionUser) && isset($sessionUser['id'])) {
            $sessionUserId = (int)$sessionUser['id'];
            return $sessionUserId === $resourceId;
        }
        return false;
    }
}
