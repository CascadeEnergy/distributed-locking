<?php

namespace CascadeEnergy\DistributedLocking;

interface ILockSessionProvider
{
    /**
     * This function should return the currently active session.
     *
     * If the underlying session provider requires sessions to be destroyed, this method SHOULD NOT create a new
     * session if one does not already exist.
     *
     * @return string The current session ID
     */
    public function getSessionId();

    /**
     * Refreshes the current session.
     *
     * If the underlying session provider does not support session expiration, this method SHOULD always succeed.
     *
     * If the underlying session provider expires sessions and does not allow their TTL to be refreshed, this method
     * SHOULD always fail.
     *
     * @return bool True if the session refresh succeeded, false otherwise
     */
    public function heartbeat();
}
