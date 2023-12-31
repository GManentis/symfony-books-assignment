<?php

namespace App\Middleware;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use App\Repository\LibraryRepository;

class PassLibraryMiddleware implements EventSubscriberInterface
{
    private $libraryRepo;
    private $urlMatcher;
    private $routeNamesForValidation = ["app_book_library_index", "app_book_library_new", "app_book_library_show", "app_book_library_edit", "app_book_library_delete"];

    public function __construct(UrlMatcherInterface $urlMatcher, LibraryRepository $libraryRepository)
    {
        $this->urlMatcher = $urlMatcher;
        $this->libraryRepo = $libraryRepository;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $parameters= $this->urlMatcher->match($request->getPathInfo());
        //dd($parameters);
        if(isset($parameters["_route"]) && in_array($parameters["_route"], $this->routeNamesForValidation)){
            $libraryObject = $this->libraryRepo->find($parameters["library"]);
            if(!$libraryObject){
                throw new NotFoundHttpException("The library in the middle was not found");
            }
            $request->attributes->set('passedLibraryEntity', $libraryObject);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }
}
