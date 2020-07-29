<?php //-->
/**
 * This file is part of the Cradle PHP Library.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Package;

use Exception;

/**
 * Package exceptions
 *
 * @package  Cradle
 * @category Package
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class PackageException extends Exception
{
  /**
   * @const ERROR_METHOD_NOT_FOUND Error template
   */
  const ERROR_METHOD_NOT_FOUND = 'No method named %s was found';

  /**
   * @const string ERROR_PACKAGE_NOT_FOUND Error template
   */
  const ERROR_PACKAGE_NOT_FOUND = 'Could not find package: %s';

  /**
   * Create a new exception for invalid method
   *
   * @param *string $name
   *
   * @return PackageException
   */
  public static function forMethodNotFound(string $name): PackageException
  {
    return new static(sprintf(static::ERROR_METHOD_NOT_FOUND, $name));
  }

  /**
   * Create a new exception for invalid package
   *
   * @param *string $vendor
   *
   * @return PackageException
   */
  public static function forPackageNotFound(string $vendor): PackageException
  {
    return new static(sprintf(static::ERROR_PACKAGE_NOT_FOUND, $vendor));
  }
}
