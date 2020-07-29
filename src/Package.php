<?php //-->
/**
 * This file is part of the Cradle PHP Library.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Package;

/**
 * Package space for package methods
 *
 * @vendor   Cradle
 * @package  Package
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class Package
{
  /**
   * @const string NO_METHOD Error template
   */
  const NO_METHOD = 'No method named %s was found';

  /**
   * @const string TYPE_PSEUDO
   */
  const TYPE_PSEUDO = 'pseudo';

  /**
   * @const string TYPE_ROOT
   */
  const TYPE_ROOT = 'root';

  /**
   * @const string TYPE_VENDOR
   */
  const TYPE_VENDOR = 'vendor';

  /**
   * @var *string $name
   */
  protected $name;

  /**
   * @var array $methods A list of virtual methods
   */
  protected $methods = [];

  /**
   * @var ?string $path cache to remember the package path
   */
  protected $path = null;

  /**
   * @var ?object $map An object map for methods
   */
  protected $map = null;

  /**
   * @var ?string $root cache to remember the root path
   */
  protected static $cwd = null;

  /**
   * Store the name so we can profile later
   *
   * @param *string $name
   * @param ?string $root
   */
  public function __construct($name, ?string $path = null)
  {
    $this->name = $name;
    $this->path = $path;
  }

  /**
   * When a method doesn't exist, it this will try to call one
   * of the virtual methods.
   *
   * @param *string $name name of method
   * @param *array  $args arguments to pass
   *
   * @return mixed
   */
  public function __call(string $name, array $args)
  {
    //use closure methods first
    if (isset($this->methods[$name])) {
      return call_user_func_array($this->methods[$name], $args);
    }

    if (!is_null($this->map) && is_callable([$this->map, $name])) {
      $results = call_user_func_array([$this->map, $name], $args);
      if ($results instanceof $this->map) {
        return $this;
      }

      return $results;
    }

    throw PackageException::forMethodNotFound($name);
  }

  /**
   * Registers a method to be used
   *
   * @param *string   $name     The class route name
   * @param *callable $callback The callback handler
   *
   * @return Package
   */
  public function addMethod(string $name, callable $callback): Package
  {
    $this->methods[$name] = $callback->bindTo($this, get_class($this));
    return $this;
  }

  /**
   * Returns the package type
   *
   * @return ?object
   */
  public function getPackageMap()
  {
    return $this->map;
  }

  /**
   * Returns the path of the project
   *
   * @return string|false
   */
  public function getPackagePath()
  {
    if (!is_null($this->path)) {
      return $this->path;
    }

    switch ($this->getPackageType()) {
      case self::TYPE_ROOT:
        $this->path = static::getPackageCwd() . $this->name;
        break;
      case self::TYPE_VENDOR:
        $this->path = sprintf('%s/vendor/%s', static::getPackageCwd(), $this->name);
        break;
      case self::TYPE_PSEUDO:
      default:
        $this->path = false;
        break;
    }

    return $this->path;
  }

  /**
   * Returns the package type
   *
   * @return string
   */
  public function getPackageType(): string
  {
    //if it starts with / like /foo/bar
    if (strpos($this->name, '/') === 0) {
      //it's a root package
      return self::TYPE_ROOT;
    }

    //if theres a slash like foo/bar
    if (strpos($this->name, '/') !== false) {
      //it's vendor package
      return self::TYPE_VENDOR;
    }

    //by default it's a pseudo package
    return self::TYPE_PSEUDO;
  }

  /**
   * Sets an object map for method calling
   *
   * @return string
   */
  public function mapPackageMethods($map): Package
  {
    if (is_object($map)) {
      $this->map = $map;
    }

    return $this;
  }

  /**
   * Returns the root path of the project
   *
   * @return string|false
   */
  protected static function getPackageCwd()
  {
    //we have a cached path
    if (!is_null(static::$cwd)) {
      return static::$cwd;
    }

    //Note: Dont trust getcwd() [because of symlinks]

    //determine where it is located
    //luckily we know where we are in vendor folder :)
    //is there a better recommended way?
    self::$cwd = realpath(__DIR__ . '/../../../..');

    if (defined('CRADLE_CWD')) {
      self::$cwd = CRADLE_CWD;
    //HAX using the composer package to get the root of the vendor folder
    //is there a better recommended way?
    } else if (class_exists(SpdxLicenses::class)
      && method_exists(SpdxLicenses::class, 'getResourcesDir')
      && realpath(SpdxLicenses::getResourcesDir() . '/../../../../vendor')
    ) {
      self::$cwd = realpath(SpdxLicenses::getResourcesDir() . '/../../../..');
    }

    return self::$cwd;
  }
}
