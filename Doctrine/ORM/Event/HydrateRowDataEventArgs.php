<?php

namespace steevanb\DoctrineStats\Doctrine\ORM\Event;

use Doctrine\Common\EventArgs;

class HydrateRowDataEventArgs extends EventArgs
{
    const EVENT_NAME = 'hydrateRowData';

    /** @var array */
    protected $row = [];

    /**
     * @param array $row
     */
    public function __construct(array $row)
    {
        $this->row = $row;
    }

    /**
     * @return array
     */
    public function getRow()
    {
        return $this->row;
    }
}
