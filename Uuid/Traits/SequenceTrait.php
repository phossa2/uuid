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

/**
 * SequenceTrait
 *
 * Time & sequence related stuff
 *
 * @package Phossa2\Uuid
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.1.0
 * @since   2.1.0 added
 */
trait SequenceTrait
{
    use UtilityTrait;

    /**
     * epoch for this uuid lib
     *
     * @var    string
     * @access protected
     * @staticvar
     */
    protected static $epoch = '2016/01/01';

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
     * Reverse of getTimestamp(), convert 15-char string to unix time
     *
     * @param  string $hexValue
     * @return int
     * @access protected
     * @static
     */
    protected static function toTimeStamp(/*# string */ $hexValue)/*# : int */
    {
        $dec = bcdiv(static::toBase10($hexValue, self::BASE16), 100000000, 0);
        return (int) ($dec + strtotime(static::$epoch));
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
