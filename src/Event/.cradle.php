<?php //-->

use Cradle\Package\Event\EventPackage;

$this('event')
  //map the package with the event package class methods
  ->mapPackageMethods($this('resolver')->resolve(EventPackage::class))
  //use one global resolver
  ->setResolverHandler($this('resolver')->getResolverHandler());

//use one global event emitter
$this('io')->setEventEmitter($this('event')->getEventEmitter());
