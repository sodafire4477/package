<?php //-->
/**
 * This file is part of the Cradle PHP Library.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Package\Event;

use Cradle\Event\EventTrait;

use Cradle\Helper\LoopTrait;
use Cradle\Helper\ConditionalTrait;

use Cradle\Profiler\InspectorTrait;
use Cradle\Profiler\LoggerTrait;

use Cradle\Resolver\StateTrait;

use Cradle\IO\Request;
use Cradle\IO\Response;

/**
 * Event Package
 *
 * @vendor   Cradle
 * @package  Package
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class EventPackage
{
  use EventTrait,
    LoopTrait,
    ConditionalTrait,
    InspectorTrait,
    LoggerTrait,
    StateTrait;

  /**
   * Runs an event like a method
   *
   * @param bool $load whether to load the RnRs
   *
   * @return array
   */
  public function method($event, $request = [], Response $response = null)
  {
    if (is_array($request)) {
      $request = Request::i()->load()->set('stage', [])->setStage($request);
    }

    if (!($request instanceof Request)) {
      $request = Request::i()->load();
    }

    if (is_null($response)) {
      $response = Response::i()->load();
    }

    $this->emit($event, $request, $response);

    if ($response->isError()) {
      return false;
    }

    return $response->getResults();
  }
}
