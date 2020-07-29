<?php //-->
/**
 * This file is part of the Cradle PHP Library.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Package\IO;

use Cradle\IO\IOHandler;
use Cradle\IO\Request;
use Cradle\IO\Response;

/**
 * IO Package
 *
 * @vendor   Cradle
 * @package  Package
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class IOPackage extends IOHandler
{
  /**
   * Creates a new Request and Response
   *
   * @param bool $load whether to load the RnRs
   *
   * @return array
   */
  public function makePayload(bool $load = true): array
  {
    $request = Request::i();
    $response = Response::i();

    if ($load) {
      $request->load();
      $response->load();

      $stage = $this->getRequest()->getStage();

      if (is_array($stage)) {
        $request->setSoftStage($stage);
      }
    }

    return [
      'request' => $request,
      'response' => $response
    ];
  }
}
