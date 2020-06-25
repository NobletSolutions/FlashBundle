<?php

namespace NS\FlashBundle\Service;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use NS\FlashBundle\Interfaces\MessageStore;
use NS\FlashBundle\Model\FlashMessage;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Messages extends AbstractExtension implements MessageStore
{
    /** @var SessionInterface */
    private $session;

    /** @var FlashBagInterface|null */
    private $flashBag;

    /** @var string */
    private $template;

    /** @var string */
    private $modalTemplate = '@NSFlash/Messages/modal.html.twig';

    /**
     * @param SessionInterface $session
     * @param string $template
     */
    public function __construct(SessionInterface $session, $template)
    {
        $this->session  = $session;
        $this->template = $template;
    }

    public function getFunctions(): array
    {
        return array(
            new TwigFunction('flash_messages', array($this, 'outputMessages'), array('needs_environment'=>true, 'is_safe' => array('html'))),
            new TwigFunction('modal_flash_messages', array($this,'outputModalMessages'),array('needs_environment'=>true,'is_safe'=>array('html'))),
        );
    }

    /**
     * @param string|null $header
     * @param string|null $title
     * @param string|null $message
     * @param string|null $buttonMessage
     * @return boolean
     */
    public function addSuccess($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->addMessage('success', $header, $title, $message, $buttonMessage);
    }

    /**
     * @param string|null $header
     * @param string|null $title
     * @param string|null $message
     * @param string|null $buttonMessage
     * @return boolean
     */
    public function addWarning($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->addMessage('warning', $header, $title, $message, $buttonMessage);
    }

    /**
     * @param string|null $header
     * @param string|null $title
     * @param string|null $message
     * @param string|null $buttonMessage
     * @return boolean
     */
    public function addError($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->addMessage('error', $header, $title, $message, $buttonMessage);
    }

    /**
     * @param string|null $header
     * @param string|null $title
     * @param string|null $message
     * @param string|null $buttonMessage
     * @return boolean
     */
    public function add($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->addMessage('message', $header, $title, $message, $buttonMessage);
    }

    /**
     * @param string $type
     * @param string|null $header
     * @param string|null $title
     * @param string|null $message
     * @param string|null $buttonMessage
     * @return bool
     */
    private function addMessage($type, $header = null, $title = null, $message = null, $buttonMessage = null)
    {
        if (!$this->flashBag && $this->session->isStarted()) {
            $this->flashBag = $this->session->getFlashBag();
        }

        if ($this->flashBag) {
            $this->flashBag->add($type, new FlashMessage($header, $title, $message, $buttonMessage));

            return true;
        }

        return false;
    }

    public function outputMessages(Environment $environment): string
    {
        return $environment->render($this->template);
    }

    public function outputModalMessages(Environment $environment): string
    {
        return $environment->render($this->modalTemplate);
    }
}
