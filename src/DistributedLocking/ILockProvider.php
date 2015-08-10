<?php

namespace CascadeEnergy\DistributedLocking;

interface ILockProvider
{
    /**
     * @param string $lockName The name of the lock to acquire
     *
     * @return mixed An opaque handle for the lock, or false if the lock could not be acquired
     */
    public function lock($lockName);

    /**
     * Note that the `$lockHandle` parameter is opaque and implementation specific
     *
     * @param mixed $lockHandle The opaque handle of the lock to be released
     *
     * @return void
     */
    public function release($lockHandle);

    /**
     * Determines if the given lock handle is currently valid for the given lock name. This method can be used to
     * verify if, for example, a particular lock session currently owns a given lock.
     *
     * @param string $lockName The name of the lock to check
     * @param mixed $lockHandle The opaque lock handle to validate against the lock
     *
     * @return bool True if the handle is valid for the lock, false otherwise
     */
    public function isValid($lockName, $lockHandle);
}
