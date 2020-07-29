<?php //-->
/**
 * This file is part of the Cradle PHP Library.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Package;

use Cradle\IO\IOHandler;

/**
 * Handler for micro framework calls. Combines both
 * Http handling and Event handling
 *
 * @vendor   Cradle
 * @package  Package
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class PackageHandler extends IOHandler
{
  use PackageTrait
    {
      PackageTrait::__invokePackage as __invoke;
  }

  /**
   * Setups dispatcher and global package
   */
  public function __construct()
  {
    $this
      ->register('global')
      ->register('resolver', sprintf('%s/Resolver', __DIR__))
      ->register('io', sprintf('%s/IO', __DIR__))
      ->register('event', sprintf('%s/Event', __DIR__))
      ->register('http', sprintf('%s/Http', __DIR__))
      ->register('terminal', sprintf('%s/Terminal', __DIR__));
  }

  /**
   * Returns all the packages
   *
   * @param string|null $name Name of package
   *
   * @return array
   */
  public function getPackages(string $name = null)
  {
    if (isset($this->packages[$name])) {
      return $this->packages[$name];
    }

    return $this->packages;
  }
}
