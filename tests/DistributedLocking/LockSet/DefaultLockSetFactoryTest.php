<?php
namespace Tests\DistributedLocking\LockSet;

use CascadeEnergy\DistributedLocking\ILockProvider;
use CascadeEnergy\DistributedLocking\LockSet\DefaultLockSetFactory;
use CascadeEnergy\DistributedLocking\LockSet\ILockSetFactory;

class DefaultLockSetFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ILockProvider */
    private $lockProvider;

    /** @var ILockSetFactory */
    private $defaultLockSetFactory;

    public function setUp()
    {
        $this->lockProvider = $this->getMock('CascadeEnergy\\DistributedLocking\\ILockProvider');

        $this->defaultLockSetFactory = new DefaultLockSetFactory($this->lockProvider);
    }

    public function testItShouldCreateADefaultLockSetWithTheGivenLockProvider()
    {
        $lockSet = $this->defaultLockSetFactory->createLockSet();

        $this->assertInstanceOf('CascadeEnergy\\DistributedLocking\\LockSet\\DefaultLockSet', $lockSet);
        $this->assertAttributeSame($this->lockProvider, 'lockProvider', $lockSet);
    }
}
