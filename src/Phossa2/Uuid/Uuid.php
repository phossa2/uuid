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

namespace Phossa2\Uuid;

use Phossa2\Uuid\Traits\UtilityTrait;
use Phossa2\Uuid\Interfaces\UuidInterface;
use Phossa2\Uuid\Interfaces\UtilityInterface;

/**
 * Uuid
 *
 * @package Phossa2\Uuid
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Uuid implements UuidInterface, UtilityInterface
{
    use UtilityTrait;

    /**
     * Default vendor code
     *
     * @var    string
     * @access protected
     */
    protected $vendor = '0001';

    /**
     * remaining part
     *
     * @var    string
     * @access protected
     */
    protected $remain = '0000';

    /**
     * Instances
     *
     * @var    UuidInterface[]
     * @access private
     */
    private static $instances = [];

    /**
     * {@inheritDoc}
     */
    public static function get(
        /*# string */ $dataType = self::TYPE_OID,
        /*# string */ $shardId = '0001'
    )/*# : string */ {
        $obj = self::getInstance();
        return
            substr(self::VERSION, 0, 1) .   // 0
            $dataType .                     // 1 - 4
            $obj->getTimestamp() .          // 5 - 19
            $shardId .                      // 20 - 23
            $obj->vendor .                  // 24 - 27
            $obj->remain;                   // 28 - 31
    }

    /**
     * Get instance
     *
     * return  Uuid
     * @access protected
     * @static
     */
    protected static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
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
            bcmul((microtime(true) - strtotime('2016/01/01')), 100000000),
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
