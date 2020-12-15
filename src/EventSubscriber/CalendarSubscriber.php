<?php

namespace App\EventSubscriber;
use App\Entity\Session;
use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use App\Repository\SessionRepository;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber 
{

    private $sessionRepository;
    private $router;

    public function __construct(
        SessionRepository $sessionRepository,
        UrlGeneratorInterface $router
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function load(CalendarEvent $calendar) :void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        // $filters = $sessionEvent->getFilters();

        // You may want to make a custom query from your database to fill the calendar

        // $sessionEvent->addEvent(new Event(
        //     'Event 1',
        //     new \DateTime('Tuesday this week'),
        //     new \DateTime('Wednesdays this week')
        // ));

        $sessions = $this->sessionRepository
        ->createQueryBuilder('session') //Requête interne de symfony (construire requête en plusieurs étapes)
        ->where('session.dateDebut BETWEEN :start and :end OR session.DateFin BETWEEN :start and :end')
        ->setParameter('start', $start->format('Y-m-d'))
        ->setParameter('end', $end->format('Y-m-d'))
        ->getQuery()
        ->getResult();


        foreach($sessions as $session){

            $sessionEvent = new Event(
                $session->getNom(),
                $session->getdateDebut(),
                $session->getDateFin(),
            );
        }

        
        $calendar->addEvent($sessionEvent);
    }
}