<?php

namespace steevanb\DoctrineStats\Doctrine\ORM\Event;

use Doctrine\Common\EventArgs;
use Doctrine\DBAL\Driver\PDOStatement;

class PreHydrationEventArgs extends EventArgs
{
    const EVENT_NAME = 'preHydration';

    /** @var string */
    protected $eventId;

    /** @var string */
    protected $hydratorClassName;

    /** @var PDOStatement|null */
    protected $stmt;

    /**
     * @param $hydratorClassName
     * @param PDOStatement $stmt
     */
    public function __construct($hydratorClassName, PDOStatement $stmt = null)
    {
        $this->eventId = uniqid('hydration_');
        $this->hydratorClassName = $hydratorClassName;
        $this->stmt = $stmt;
    }

    /**
     * @return string
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function getHydratorClassName()
    {
        return $this->hydratorClassName;
    }

    /**
     * @return PDOStatement|null
     */
    public function getStmt()
    {
        return $this->stmt;
    }
}
