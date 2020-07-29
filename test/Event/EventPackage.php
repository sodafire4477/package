<?php

namespace Cradle\Package\Event;

use StdClass;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 13:49:45.
 */
class Cradle_Package_Event_EventPackage_Test extends TestCase
{
  /**
   * @var EventPackage
   */
  protected $object;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {
    $this->object = new EventPackage;
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {
  }

  /**
   * @covers Cradle\Package\Event\EventPackage::method
   */
  public function testMethod()
  {
    $trigger = new StdClass();
    $trigger->success = false;
    $trigger->stage = [];
    $this->object->on('method-test', function($req, $res) use ($trigger) {
      $trigger->success = true;
      $trigger->stage = $req->getStage();

      if ($req->hasStage('fail')) {
        return $res->setError(true, 'Failed');
      }

      $res->setResults('works');
    });

    $results = $this->object->method('method-test');

    $this->assertTrue($trigger->success);
    $this->assertTrue(empty($trigger->stage));
    $this->assertEquals('works', $results);

    $trigger->success = false;
    $trigger->stage = [];
    $results = $this->object->method('method-test', ['foo' => 'bar']);

    $this->assertTrue($trigger->success);
    $this->assertEquals('bar', $trigger->stage['foo']);
    $this->assertEquals('works', $results);

    $trigger->success = false;
    $trigger->stage = [];
    $results = $this->object->method('method-test', ['fail' => true]);

    $this->assertTrue($trigger->success);
    $this->assertFalse($results);
  }
}
