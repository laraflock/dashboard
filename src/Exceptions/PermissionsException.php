<?php

/**
 * @package     Dashboard
 * @version     2.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Exceptions;

use Exception;

class PermissionsException extends Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}