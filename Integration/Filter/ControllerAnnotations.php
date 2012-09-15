<?php

namespace Webfactory\Bundle\LegacyIntegrationBundle\Integration\Filter;

use Webfactory\Bundle\LegacyIntegrationBundle\Integration\Filter as FilterInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Annotations\Reader;
use Webfactory\Bundle\LegacyIntegrationBundle\Integration\Filter\Factory;
use Symfony\Component\DependencyInjection\Container;

class ControllerAnnotations implements FilterInterface {

    protected $reader;
    protected $container;

    public function __construct(Reader $reader, Container $container) {
        $this->reader = $reader;
        $this->container = $container;
    }

    public function filter(FilterControllerEvent $event, Response $response) {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
            if ($annotation instanceof Factory) {
                $annotation->createFilter($this->container)->filter($event, $response);
                if ($event->isPropagationStopped())
                    break;
            }
        }
    }

}