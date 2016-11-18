<?php

namespace steevanb\DoctrineStats\Doctrine\ORM\Event;

use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

trait HydrationEventsTrait
{
    /**
     * @return EntityManagerInterface
     */
    abstract protected function getEntityManager();

    /**
     * @param PDOStatement|null $stmt
     * @return string
     */
    protected function dispatchPreHydrationEvent(PDOStatement $stmt = null)
    {
        $eventArgs = new PreHydrationEventArgs(get_class($this), $stmt);
        $this->getEntityManager()->getEventManager()->dispatchEvent(PreHydrationEventArgs::EVENT_NAME, $eventArgs);

        return $eventArgs->getEventId();
    }

    /**
     * @param string $preHydrationEventId
     * @return $this
     */
    protected function dispatchPostHydrationEvent($preHydrationEventId)
    {
        $eventArgs = new PostHydrationEventArgs($preHydrationEventId, get_class($this));
        $this->getEntityManager()->getEventManager()->dispatchEvent(PostHydrationEventArgs::EVENT_NAME, $eventArgs);

        return $this;
    }

    /**
     * @param ClassMetadata $classMetaData
     * @param array $data
     * @return $this
     */
    protected function dispatchPostCreateEntityEvent(ClassMetadata $classMetaData, array $data)
    {
        $identifiers = [];
        foreach ($classMetaData->getIdentifierFieldNames() as $identifier) {
            if (array_key_exists($identifier, $data)) {
                $identifiers[$identifier] = $data[$identifier];
            }
        }

        $eventArgs = new PostCreateEntityEventArgs(get_class($this), $classMetaData->name, $identifiers);
        $this->getEntityManager()->getEventManager()->dispatchEvent(PostCreateEntityEventArgs::EVENT_NAME, $eventArgs);

        return $this;
    }

    /**
     * @param array $row
     * @return $this
     */
    protected function dispatchHydrateRowDataEvent(array $row)
    {
        $eventArgs = new HydrateRowDataEventArgs($row);
        $this->getEntityManager()->getEventManager()->dispatchEvent(HydrateRowDataEventArgs::EVENT_NAME, $eventArgs);

        return $this;
    }
}
