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
    private RequestStack $requestStack;

    private ?FlashBagInterface $flashBag = null;

    private string $template;

    private string $modalTemplate = '@NSFlash/Messages/modal.html.twig';

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

    public function addSuccess(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool
    {
        return $this->addMessage('success', $header, $title, $message, $buttonMessage);
    }

    public function addWarning(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool
    {
        return $this->addMessage('warning', $header, $title, $message, $buttonMessage);
    }

    public function addError(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool
    {
        return $this->addMessage('error', $header, $title, $message, $buttonMessage);
    }

    public function addInfo(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool
    {
        return $this->addMessage('info', $header, $title, $message, $buttonMessage);
    }

    public function add(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool
    {
        return $this->addMessage('message', $header, $title, $message, $buttonMessage);
    }

    private function addMessage(string $type, ?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool
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
