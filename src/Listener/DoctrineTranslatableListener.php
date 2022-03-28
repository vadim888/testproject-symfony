<?php

namespace App\Listener;

use Gedmo\Translatable\TranslatableListener;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class DoctrineTranslatableListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function onLateKernelRequest(RequestEvent $event)
    {
        $translatable = $this->container->get(TranslatableListener::class);
        $translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }
}