<?php

namespace Kreatys\CmsBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KernelListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface 
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        /*$kernel    = $event->getKernel();
        $request   = $event->getRequest();
        $container = $this->container;*/
        
//        $request = $event->getRequest();
        //dump($request);
        
        //$request->getSession()->set('_locale', $locale);
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        /*$response  = $event->getResponse();
        $request   = $event->getRequest();
        $kernel    = $event->getKernel();
        $container = $this->container;

        switch ($request->query->get('option')) {
            case 2:
                $response->setContent('Blah');
                break;

            case 3:
                $response->headers->setCookie(new Cookie('test', 1));
                break;
        }*/
    }
}

