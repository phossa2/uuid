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

namespace Phossa2\Uuid\Traits;

use Phossa2\Uuid\Message\Message;
use Phossa2\Uuid\Exception\LogicException;
use Phossa2\Uuid\Interfaces\UuidInterface;
use Phossa2\Uuid\Interfaces\UtilityInterface;

/**
 * UtilityTrait
 *
 * @package Phossa2\Uuid
 * @author  Hong Zhang <phossa@126.com>
 * @see     UtilityInterface
 * @see     UuidInterface
 * @version 2.1.0
 * @since   2.0.0 added
 * @since   2.1.0 including SequenceTrait, updated info()
 */
trait UtilityTrait
{
    /**
     * epoch for this uuid lib
     *
     * @var    string
     * @access protected
     * @staticvar
     */
    protected static $epoch = '2016/01/01';

    /**
     * {@inheritDoc}
     */
    public static function isValid(/*# string */ $uuid)/*# : bool */
    {
        $pattern = '~^' . substr(self::VERSION, 0, 1) . '[0-9a-f]{31}$~';
        return is_string($uuid) && (bool) preg_match($pattern, $uuid);
    }

    /**
     * {@inheritDoc}
     */
    public static function info(/*# string */ $uuid)/*# : array */
    {
        if (static::isValid($uuid)) {
            return [
                'version' => substr($uuid, 0, 1),
                'type'    => substr($uuid, 1, 4),
                'time'    => static::toTimestamp(substr($uuid, 5, 15)),
                'shard'   => substr($uuid, 20, 4),
                'vendor'  => substr($uuid, 24, 4),
                'remain'  => substr($uuid, 28, 4)
            ];
        } else {
            throw new LogicException(
                Message::get(Message::UUID_INVALID, $uuid),
                Message::UUID_INVALID
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function encode(
        /*# string */ $uuid,
        /*# string */ $base = self::BASE56
    )/*# : string */ {
        if (static::isValid($uuid)) {
            return static::convertBase($uuid, self::BASE16, $base);
        }
        throw new LogicException(
            Message::get(Message::UUID_INVALID, $uuid),
            Message::UUID_INVALID
        );
    }

    /**
     * {@inheritDoc}
     */
    public static function decode(
        /*# string */ $string,
        /*# string */ $base = self::BASE56
    )/*# : string */ {
        $uuid = static::convertBase($string, $base, self::BASE16);
        if (static::isValid($uuid)) {
            return $uuid;
        }
        throw new LogicException(
            Message::get(Message::UUID_DECODE_FAIL, $string),
            Message::UUID_DECODE_FAIL
        );
    }

    /**
     * Convert numerical string between bases
     *
     * @param  string $input
     * @param  string $fromBase
     * @param  string $toBase
     * @return string
     * @access protected
     * @static
     */
    protected static function convertBase(
        /*# string */ $input,
        /*# string */ $fromBase,
        /*# string */ $toBase
    )/*# : string */ {
        if ($fromBase === $toBase) {
            return $input;
        } elseif ($fromBase === self::BASE10) {
            return static::fromBase10($input, $toBase);
        } elseif ($toBase === self::BASE10) {
            return static::toBase10($input, $fromBase);
        } else {
            return static::fromBase10(static::toBase10($input, $fromBase), $toBase);
        }
    }

    /**
     * Convert to decimal string
     *
     * @param  string $input
     * @param  string $fromBase
     * @return string
     * @access protected
     */
    protected static function toBase10(
        /*# string */ $input,
        /*# string */ $fromBase
    )/*# string */ {
        $len = strlen($fromBase);
        $res = '0';
        foreach (str_split($input) as $char) {
            $res = bcadd((int) strpos($fromBase, $char), bcmul($res, $len));
        }
        return $res;
    }

    /**
     * Convert from decimal string
     *
     * @param  string $input
     * @param  string $toBase
     * @return string
     * @access protected
     */
    protected static function fromBase10(
        /*# string */ $input,
        /*# string */ $toBase
    )/*# string */ {
        $len = strlen($toBase);
        $res = '';
        do {
            $digit = bcmod($input, $len);
            $res = $toBase[(int) $digit] . $res;
            $input = bcdiv($input, $len, 0);
        } while ($input != '0');
        return $res;
    }

    /**
     * Reverse of getTimestamp(), convert 15-char string to unix time
     *
     * @param  string $hexString
     * @return int
     * @access protected
     * @static
     */
    protected static function toTimeStamp(/*# string */ $hexString)/*# : int */
    {
        $dec = bcdiv(static::toBase10($hexString, self::BASE16), 100000000, 0);
        return (int) ($dec + strtotime(static::$epoch));
    }

    /**
     * Time related part
     *
     * @return string 15-char string
     * @access protected
     */
    protected function getTimestamp()/*# : string */
    {
        $num = bcadd(
            bcmul((microtime(true) - strtotime(static::$epoch)), 100000000),
            $this->getSequence() % 10000
        );
        return substr('00' . static::fromBase10($num, self::BASE16), -15);
    }

    /**
     * Get a pseudo sequence number
     *
     * @return int
     * @access protected
     * @static
     */
    protected function getSequence()/*# : int */
    {
        static $seq = 0;
        return $seq++;
    }
}
