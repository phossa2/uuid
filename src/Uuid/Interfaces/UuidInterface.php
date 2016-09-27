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

namespace Phossa2\Uuid\Interfaces;

/**
 * UuidInterface
 *
 * @package Phossa2\Uuid
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface UuidInterface
{
    /**
     * Lib version, only '2' used in UUID
     */
    const VERSION = '2.0.0';

    /**
     * Predefined data types, '1***' are reserved for lib
     */
    const TYPE_OID = '1000';

    // user
    const TYPE_USER = '1010';

    // article & news
    const TYPE_POST = '1020';
    const TYPE_NEWS = '1020';

    // image & pictures
    const TYPE_IMAGE = '1030';
    const TYPE_ALBUM = '1031';

    // comment & rate
    const TYPE_COMM = '1040';
    const TYPE_RATE = '1041';

    // connection tracking
    const TYPE_UID = '1050'; // unique user id
    const TYPE_DEVICE  = '1051'; // device
    const TYPE_SESSION = '1052'; // session
    const TYPE_REQUEST = '1053'; // request

    /**
     * Generate an UUID
     *
     * @param  string $dataType
     * @param  string $shardId
     * @return string
     * @access public
     * @static
     * @api
     */
    public static function get(
        /*# string */ $dataType = self::TYPE_OID,
        /*# string */ $shardId = '0001'
    )/*# : string */;
}
