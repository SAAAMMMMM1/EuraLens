<?php


namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Listener responsible to change the redirection at the end of the mail change
 */
class ChangeProfileListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router , SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onChangeMailSuccess',
        );
    }

    public function onChangeMailSuccess(FormEvent $event)
    {

        $flash = $this->session->getFlashBag()
        ->add('changeEmail', 'Votre email a été modifié');

        $url = $this->router->generate('fos_user_profile_show');
        $event->setResponse(new RedirectResponse($url));
    }
}
