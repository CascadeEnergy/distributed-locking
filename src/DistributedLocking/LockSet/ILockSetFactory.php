<?php

namespace CascadeEnergy\DistributedLocking\LockSet;

interface ILockSetFactory
{
    /**
     * Creates and returns a lock set.
     *
     * @return ILockSet The new ILockSet implementation instance
     */
    public function createLockSet();
}
