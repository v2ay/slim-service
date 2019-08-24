<?php

/**
 * This file is part of the Zanra Framework package.
 *
 * (c) v2ay <v2ay.hub@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace V2ay\Slim\Service;

use Psr\Http\Message\ResponseInterface;

abstract class Controller
{
  protected $container;
  protected $request;
  protected $response;

  public function __construct($container)
  {
    $this->container = $container;

    $this->request = $this->container->request;
    $this->response = $this->container->response;
  }

  public function __get($property)
  {
    if ($this->container->{$property}) {
      return $this->container->{$property};
    }
  }

  public function render($code, $file, array $params = array())
  {
    if ($this->request->isXhr()) {
      return json_encode(array('code' => $code, 'type' => 'html', 'content' => $this->view->fetch($file, $params)));
    }

    return $this->view->render($this->response, $file, $params);
  }

  public function renderRaw($template, array $params = array())
  {
    $view = $this->container->view->fetch($template, $params);

    if ($this->request->isXhr()) {
      $view = preg_replace("#\r|\n#", '', addslashes($view));
    }
    
    return $view;
  }

  public function redirect($code, $routeName = null, array $params = array())
  {
    $location = '';

    if ($routeName) {
      $location = $this->router->pathFor($routeName, $params);
    }

    if ($this->request->isXhr()) {
      return json_encode(array('code' => $code, 'type' => 'redirect', 'content' => $location));
    }

    return $this->response->withRedirect($location, $code);
  }
}