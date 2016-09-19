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

use Phossa2\Uuid\Exception\LogicException;

/**
 * UtilityInterface
 *
 * @package Phossa2\Uuid
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface UtilityInterface
{
    // convert bases
    const BASE10 = '0123456789';
    const BASE16 = '0123456789abcdef';
    const BASE56 = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';

    /**
     * Is it a valid UUID
     *
     * @param  string $uuid
     * @return bool
     * @access public
     * @static
     * @api
     */
    public static function isValid(/*# string */ $uuid)/*# : bool */;

    /**
     * Get info from an UUID.
     *
     * ```php
     * returns [
     *     'version' => '...',
     *     'type' => '...',
     *     'vendor' => '...',
     *     'remain' => '...'
     * ];
     * ```
     *
     * @param  string $uuid
     * @return array
     * @throws LogicException if not valid uuid
     * @access public
     * @static
     * @api
     */
    public static function info(/*# string */ $uuid)/*# : array */;

    /**
     * Encode an UUID, returns a short string
     *
     * @param  string $uuid
     * @param  string $base
     * @return string
     * @throws LogicException if not a valid uuid or encode failed
     * @access public
     * @static
     * @api
     */
    public static function encode(
        /*# string */ $uuid,
        /*# string */ $base = self::BASE56
    )/*# : string */;

    /**
     * Returns a full uuid from short version
     *
     * @param  string $string
     * @param  string $base
     * @return string
     * @throws LogicException if decode failed
     * @access public
     * @static
     * @api
     */
    public static function decode(
        /*# string */ $string,
        /*# string */ $base = self::BASE56
    )/*# : string */;
}
