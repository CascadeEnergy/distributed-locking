<?php
namespace Tests\DistributedLocking\LockSet;

use CascadeEnergy\DistributedLocking\LockSet\DefaultLockSet;
use CascadeEnergy\DistributedLocking\LockSet\ILockSet;

class DefaultLockSetTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $lockProvider;

    /** @var ILockSet */
    private $lockSet;

    public function setUp()
    {
        $this->lockProvider = $this->getMock('CascadeEnergy\\DistributedLocking\\ILockProvider');

        /** @noinspection PhpParamsInspection */
        $this->lockSet = new DefaultLockSet($this->lockProvider);
    }

    public function testItShouldAcquireSingleLocksWhenRequested()
    {
        $this->acquireTestLocks();
    }

    public function testItShouldReturnFalseWhenALockCannotBeAcquired()
    {
        $this->lockProvider
            ->expects($this->once())
            ->method('lock')
            ->willReturn(false);

        $this->assertFalse($this->lockSet->lock('foo'));
    }

    public function testItShouldReleaseAllPreviouslyAcquiredLockedWhenRequested()
    {
        $this->acquireTestLocks();

        $this->lockProvider
            ->expects($this->exactly(3))
            ->method('release')
            ->withConsecutive(['fooHandle'], ['barHandle'], ['bazHandle']);

        $this->lockSet->releaseAll();
    }

    public function testItShouldReturnTrueWhenAllLocksAreValid()
    {
        $this->acquireTestLocks();

        $this->lockProvider
            ->expects($this->exactly(3))
            ->method('isValid')
            ->withConsecutive(['foo', 'fooHandle'], ['bar', 'barHandle'], ['baz', 'bazHandle'])
            ->willReturn(true);

        $this->assertTrue($this->lockSet->isValid());
    }

    public function testItShouldReturnFalseWhenAnyLockIsInvalid()
    {
        $this->lockProvider->expects($this->once())->method('lock')->with('foo')->willReturn('fooHandle');
        $this->lockProvider->expects($this->once())->method('isValid')->with('foo', 'fooHandle')->willReturn(false);

        $this->lockSet->lock('foo');
        $this->assertFalse($this->lockSet->isValid());
    }

    private function acquireTestLocks()
    {
        $this->lockProvider
            ->expects($this->exactly(3))
            ->method('lock')
            ->withConsecutive(['foo'], ['bar'], ['baz'])
            ->willReturnOnConsecutiveCalls('fooHandle', 'barHandle', 'bazHandle');

        $this->assertTrue($this->lockSet->lock('foo'));
        $this->assertTrue($this->lockSet->lock('bar'));
        $this->assertTrue($this->lockSet->lock('baz'));
    }
}
