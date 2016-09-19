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

use Phossa2\Uuid\Exception\LogicException;
use Phossa2\Uuid\Interfaces\UtilityInterface;
use Phossa2\Uuid\Message\Message;

/**
 * UtilityTrait
 *
 * @package Phossa2\Uuid
 * @author  Hong Zhang <phossa@126.com>
 * @see     UtilityInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait UtilityTrait
{
    /**
     * GMP supported ?
     * @var    bool
     * @access protected
     */
    protected static $gmp;

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
                'version' => substr($uuid,  0, 1),
                'type'    => substr($uuid,  1, 4),
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
            $res = static::add((int) strpos($fromBase, $char), static::mul($res, $len));
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
            $digit = static::mod($input, $len);
            $res = $toBase[(int) $digit] . $res;
            $input = static::div($input, $len);
        } while($input != '0');
        return $res;
    }

    /**
     * Addition
     *
     * @param  string $a
     * @param  string $b
     * @return string
     * @access protected
     */
    protected static function add($a, $b)
    {
        static::checkGmp();
        return static::$gmp ? gmp_strval(gmp_add($a, $b)) : bcadd($a, $b);
    }

    /**
     * Multiply
     *
     * @param  string $a
     * @param  string $b
     * @return string
     * @access protected
     */
    protected static function mul($a, $b)
    {
        static::checkGmp();
        return static::$gmp ? gmp_strval(gmp_mul($a, $b)) : bcmul($a, $b);
    }

    /**
     * Modulus
     *
     * @param  string $a
     * @param  string $b
     * @return string
     * @access protected
     */
    protected static function mod($a, $b)
    {
        static::checkGmp();
        return static::$gmp ? gmp_strval(gmp_mod($a, $b)) : bcmod($a, $b);
    }

    /**
     * Division with 0 scale
     *
     * @param  string $a
     * @param  string $b
     * @param  string
     * @access protected
     */
    protected static function div($a, $b)
    {
        static::checkGmp();
        return static::$gmp ? gmp_strval(gmp_div($a, $b, true)) : bcdiv($a, $b, 0);
    }

    /**
     * Check GMP module
     *
     * @access protected
     */
    protected static function checkGmp()
    {
        if (null === static::$gmp) {
            static::$gmp = function_exists('gmp_add');
        }
    }
}
