<?php

/**
 * This file is part of the Zanra Framework package.
 *
 * (c) v2ay <v2ay.hub@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace V2ay\Slim\Service\Session\Exception;

/**
 * Zanra SessionStartException
 *
 * @author Targalis
 */
class SessionStartException extends \Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message, 404);
    }
}
