<?php //-->

use Cradle\Package\IO\IOPackage;

$this('io')
  //map the package with the resolver package class methods
  ->mapPackageMethods($this('resolver')->resolve(IOPackage::class))
  //use one global resolver
  ->setResolverHandler($this('resolver')->getResolverHandler());
