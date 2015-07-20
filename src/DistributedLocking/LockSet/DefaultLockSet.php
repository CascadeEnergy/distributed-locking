<?php

namespace Cascade\DistributedLocking\LockSet;

use Cascade\DistributedLocking\ILockProvider;

class DefaultLockSet implements ILockSet
{
    private $lockList = [];

    /** @var ILockProvider */
    private $lockProvider;

    /**
     * @param ILockProvider $lockProvider The lock provider to use to acquire and release locks
     */
    public function __construct(ILockProvider $lockProvider)
    {
        $this->lockProvider = $lockProvider;
    }

    /**
     * @return bool True if all the locks in the set have been acquired and are currently valid
     */
    public function isValid()
    {
        foreach ($this->lockList as $lockName => $lockHandle) {
            if (!$this->lockProvider->isValid($lockName, $lockHandle)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Attempts to acquire a single lock by name, and adds it to the lock set.
     *
     * @param string $lockName The name of the lock to acquire
     * @return bool True if the lock was acquired, false otherwise
     */
    public function lock($lockName)
    {
        $lockHandle = $this->lockProvider->lock($lockName);

        if ($lockHandle === false) {
            return false;
        }

        $this->lockList[$lockName] = $lockHandle;
        return true;
    }

    /**
     * Releases all of the locks currently held in the lock set.
     *
     * @return void
     */
    public function releaseAll()
    {
        foreach ($this->lockList as $lockHandle) {
            $this->lockProvider->release($lockHandle);
        }
    }
}
