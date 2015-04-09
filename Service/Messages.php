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

    /**
     *
     * @param Session $session
     * @param string $template
     */
    public function __construct(Session $session, $template)
    {
        $this->session  = $session;
        $this->flashBag = ($session->isStarted()) ? $session->getFlashBag() : null;
        $this->template = $template;
    }

    /**
     *
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     *
     * @param string $header
     * @param string $title
     * @param string $message
     * @param string $buttonMessage
     * @return boolean
     */
    public function addSuccess($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('success', $header, $title, $message, $buttonMessage);
    }

    /**
     *
     * @param string $header
     * @param string $title
     * @param string $message
     * @param string $buttonMessage
     * @return boolean
     */
    public function addWarning($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('warning', $header, $title, $message, $buttonMessage);
    }

    /**
     *
     * @param string $header
     * @param string $title
     * @param string $message
     * @param string $buttonMessage
     * @return boolean
     */
    public function addError($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('error', $header, $title, $message, $buttonMessage);
    }

    /**
     *
     * @param string $header
     * @param string $title
     * @param string $message
     * @param string $buttonMessage
     * @return boolean
     */
    public function add($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        return $this->_add('message', $header, $title, $message, $buttonMessage);
    }

    /**
     *
     * @param string $header
     * @param string $title
     * @param string $message
     * @param string $buttonMessage
     * @return boolean
     */
    private function _add($type, $header = null, $title = null, $message = null, $buttonMessage = null)
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

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'flash_messages' => new \Twig_Function_Method($this, 'outputMessages', array(
                'is_safe' => array('html')))
        );
    }

    /**
     *
     * @return string
     */
    public function outputMessages()
    {
        return $this->environment->render($this->template, array('flashbag' => $this->flashBag));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'flash_message';
    }
}