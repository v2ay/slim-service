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

class Paginator
{
  private $first = null;
  private $last = null;
  private $current = null;
  private $previous = null;
  private $next = null;
  private $pages = null;
  private $total = null;

  public function __construct($items, $offset, $range)
  {
    $current = ($offset/$range) + 1;

    $pages = array();
    $total = count($items);
    $last = ceil($total/$range);

    $next = $current >= $last ? $last : $current + 1;
    $previous = $current - 1;
    $page_number = 5;

    if ($page_number < $last) {
      for($i = 0; $i < $page_number; $i++) {
        if($current + $page_number/2 <= $last and $current - $page_number/2 >= 1) {
          $pages[] = $current - 2 + $i;
        } elseif($current + $page_number/2 > $last) {
          $pages[] = $last - $page_number + $i;
        } else {
          $pages[] = 1 + $i;
        }
      }
    } else {
      for($i = 0; $i < $last; $i++) {
        $pages[] = 1 + $i;
      }
    }

    $this->first = 1;
    $this->last = $last;
    $this->current = $current;
    $this->previous = $previous;
    $this->next = $next;
    $this->pages = $pages;
    $this->total = $total;
  }

  public function getFirst()
  {
    return $this->first;
  }

  public function getLast()
  {
    return $this->last;
  }

  public function getCurrent()
  {
    return $this->current;
  }

  public function getPrevious()
  {
    return $this->previous;
  }

  public function getNext()
  {
    return $this->next;
  }

  public function getPages()
  {
    return $this->pages;
  }

  public function getTotal()
  {
    return $this->total;
  }
}