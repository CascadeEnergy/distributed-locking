<?php

namespace CascadeEnergy\DistributedLocking\LockSet;

use CascadeEnergy\DistributedLocking\ILockProvider;

class DefaultLockSetFactory implements ILockSetFactory
{
    /** @var ILockProvider */
    private $lockProvider;

    public function __construct(ILockProvider $lockProvider)
    {
        $this->lockProvider = $lockProvider;
    }

    public function createLockSet()
    {
        return new DefaultLockSet($this->lockProvider);
    }
}
