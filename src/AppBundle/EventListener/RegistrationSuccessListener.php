<?php


namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class RegistrationSuccessListener implements EventSubscriberInterface
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
          FOSUserEvents::REGISTRATION_SUCCESS => [
          ['onRegistrationSuccess', -10],
          ],
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {

        $flash = $this->session->getFlashBag()
        ->add('registrationSuccess', 'Un email de confirmation vous a été envoyé');

        $url = $this->router->generate('fos_user_security_homepage');
        $event->setResponse(new RedirectResponse($url));
    }
}
