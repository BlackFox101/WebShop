<?php

namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;

class EntityChangedListener
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (true === property_exists($entity, 'createdAt')) {
            $entity->setCreatedAt(new \DateTime());
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (true === property_exists($entity, 'updatedAt')) {
            $entity->setUpdatedAt(new \DateTime());
        }
    }
}