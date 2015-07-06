<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Exceptions;

use Exception;

class PermissionsException extends Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}