<?php

namespace NS\FlashBundle\Service;

use NS\FlashBundle\Interfaces\MessageStore;
use NS\FlashBundle\Model\FlashMessage;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Messages extends AbstractExtension implements MessageStore
{
    /** @var RequestStack */
    private $requestStack;

    /** @var FlashBagInterface|null */
    private $flashBag;

    /** @var string */
    private $template;

    /** @var string */
    private $modalTemplate = '@NSFlash/Messages/modal.html.twig';

    public function __construct(RequestStack $requestStack, string $template)
    {
        $this->requestStack = $requestStack;
        $this->template     = $template;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('flash_messages', [$this, 'outputMessages'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('modal_flash_messages', [$this, 'outputModalMessages'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    /**
     * @param string|null $header
     * @param string|null $title
     * @param string|null $message
     * @param string|null $buttonMessage
     *
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
     *
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
     *
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
     *
     * @return boolean
     */
    public function add($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->addMessage('message', $header, $title, $message, $buttonMessage);
    }

    /**
     * @param string      $type
     * @param string|null $header
     * @param string|null $title
     * @param string|null $message
     * @param string|null $buttonMessage
     *
     * @return bool
     */
    private function addMessage($type, $header = null, $title = null, $message = null, $buttonMessage = null)
    {
        if (!$this->flashBag && $this->requestStack->getSession()->isStarted()) {
            $this->flashBag = $this->requestStack->getSession()->getFlashBag();
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
