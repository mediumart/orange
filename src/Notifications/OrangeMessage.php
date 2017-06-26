<?php

namespace Mediumart\Orange\Laravel\Notifications;

/**
 * Class OrangeMessage
 * @package Mediumart\Orange\Laravel\Notifications
 */
class OrangeMessage
{
    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $text;

    /**
     * @param $to
     * @return \Mediumart\Orange\Laravel\Notifications\OrangeMessage
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param $from
     * @return \Mediumart\Orange\Laravel\Notifications\OrangeMessage
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param string $text
     * @return \Mediumart\Orange\Laravel\Notifications\OrangeMessage
     */
    public function text($text = '')
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if(property_exists($this, $property) && in_array($property, ['to','from','text']))
            return $this->{$property};
    }
}