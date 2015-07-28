<?php

namespace CascadeEnergy\DistributedLocking\LockSet;

interface ILockSet
{
    /**
     * @return bool True if all the locks in the set have been acquired and are currently valid
     */
    public function isValid();

    /**
     * Attempts to acquire a single lock by name, and adds it to the lock set.
     *
     * @param string $lockName The name of the lock to acquire
     * @return bool True if the lock was acquired, false otherwise
     */
    public function lock($lockName);

    /**
     * Releases all of the locks currently held in the lock set.
     *
     * @return void
     */
    public function releaseAll();
}
