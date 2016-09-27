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
 * @version 2.1.0
 * @since   2.0.0 added
 * @since   2.1.0 moved sequence related stuff to SequenceTrait
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
        $obj = static::getInstance();
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
}
