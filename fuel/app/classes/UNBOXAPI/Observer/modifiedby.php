<?php
/**
 * Created by PhpStorm.
 * User: mrussell
 * Date: 3/12/15
 * Time: 11:14 AM
 */

namespace UNBOXAPI;


class Observer_ModifiedBy extends \Orm\Observer{


    /**
     * @var  string  default property to set the timestamp on
     */
    public static $property = 'modified_by';

    /**
     * @var  string  property to set the timestamp on
     */
    protected $_property;

    /**
     * @var  string  whether to overwrite an already set timestamp
     */
    protected $_overwrite;

    /**
     * Set the properties for this observer instance, based on the parent model's
     * configuration or the defined defaults.
     *
     * @param  string  Model class this observer is called on
     */
    public function __construct($class)
    {
        $props = $class::observers(get_class($this));
        $this->_property         = isset($props['property']) ? $props['property'] : static::$property;
        $this->_overwrite        = isset($props['overwrite']) ? $props['overwrite'] : false;
    }

    /**
     * Set the CreatedAt property to the current time.
     *
     * @param  Model  Model object subject of this observer method
     */
    public function before_save(\Orm\Model $model)
    {
        if ($this->_overwrite or empty($model->{$this->_property}))
        {
            $model->{$this->_property} = $_SESSION['user_id'];
        }
    }
}