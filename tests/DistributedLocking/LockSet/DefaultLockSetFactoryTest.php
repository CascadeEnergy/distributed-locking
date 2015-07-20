<?php
namespace Tests\DistributedLocking\LockSet;

use Cascade\DistributedLocking\ILockProvider;
use Cascade\DistributedLocking\LockSet\DefaultLockSetFactory;
use Cascade\DistributedLocking\LockSet\ILockSetFactory;

class DefaultLockSetFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ILockProvider */
    private $lockProvider;

    /** @var ILockSetFactory */
    private $defaultLockSetFactory;

    public function setUp()
    {
        $this->lockProvider = $this->getMock('Cascade\\DistributedLocking\\ILockProvider');

        $this->defaultLockSetFactory = new DefaultLockSetFactory($this->lockProvider);
    }

    public function testItShouldCreateADefaultLockSetWithTheGivenLockProvider()
    {
        $lockSet = $this->defaultLockSetFactory->createLockSet();

        $this->assertInstanceOf('Cascade\\DistributedLocking\\LockSet\\DefaultLockSet', $lockSet);
        $this->assertAttributeSame($this->lockProvider, 'lockProvider', $lockSet);
    }
}
