<?php

namespace Cascade\DistributedLocking\LockSet;

use Cascade\DistributedLocking\ILockProvider;

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
