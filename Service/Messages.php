<?php

namespace NS\FlashBundle\Service;

use \Symfony\Component\HttpFoundation\Session\Session;
use NS\FlashBundle\Interfaces\MessageStore;
use NS\FlashBundle\Model\FlashMessage;

/**
 * Description of Messages
 *
 * @author gnat
 */
class Messages extends \Twig_Extension implements MessageStore
{
    private $session;
    private $flashBag;
    private $template;
    private $environment;

    public function __construct(Session $session, $template)
    {
        $this->session  = $session;
        $this->flashBag = ($session->isStarted()) ? $session->getFlashBag():null;
        $this->template = $template;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function addSuccess($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('success', $header, $title, $message, $buttonMessage);
    }

    public function addWarning($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('warning', $header, $title, $message, $buttonMessage);
    }

    public function addError($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('error', $header, $title, $message, $buttonMessage);
    }

    public function add($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('message', $header, $title, $message, $buttonMessage);
    }

    private function _add($type, $header = null, $title = null, $message = null, $buttonMessage = null)
    {
        if(!$this->flashBag && $this->session->isStarted())
            $this->flashBag = $this->session->getFlashBag ();

        if($this->flashBag)
        {
            $this->flashBag->add($type, new FlashMessage($header, $title, $message, $buttonMessage));
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'flash_messages' => new \Twig_Function_Method($this, 'flash_messages',array('is_safe' => array('html')))
        );
    }

    public function flash_messages()
    {
        return $this->environment->render($this->template, array('flashbag'=>$this->flashBag));
    }

    public function getName()
    {
        return 'flash_message';
    }
}
