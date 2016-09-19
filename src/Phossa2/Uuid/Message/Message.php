<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Library
 * @package   Phossa2\Uuid
 * @copyright Copyright (c) 2016 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa2\Uuid\Message;

use Phossa2\Shared\Message\Message as BaseMessage;

/**
 * Message class for Phossa2\Uuid
 *
 * @package Phossa2\Uuid
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa2\Shared\Message\Message
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Message extends BaseMessage
{
    /*
     * Invalid UUID "%s" found
     */
    const UUID_INVALID = 1609191845;

    /*
     * Decode "%s" to UUID failed
     */
    const UUID_DECODE_FAIL = 1609191846;

    /**
     * {@inheritDoc}
     */
    protected static $messages = [
        self::UUID_INVALID => 'Invalid UUID "%s" found',
        self::UUID_DECODE_FAIL => 'Decode "%s" to UUID failed',
    ];
}
