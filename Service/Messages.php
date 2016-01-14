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
    /**
     * @var Session
     */
    private $session;

    /**
     * @var null
     */
    private $flashBag;

    /**
     * @var string
     */
    private $template = 'NSFlashBundle:Messages:index.html.twig';

    /**
     * @var string
     */
    private $modalTemplate = 'NSFlashBundle:Messages:modal.html.twig';

    /**
     * @param Session $session
     * @param string $template
     */
    public function __construct(Session $session, $template)
    {
        $this->session  = $session;
        $this->template = $template;
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
        return $this->addMessage('success', $header, $title, $message, $buttonMessage);
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
        return $this->addMessage('warning', $header, $title, $message, $buttonMessage);
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
        return $this->addMessage('error', $header, $title, $message, $buttonMessage);
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
        return $this->addMessage('message', $header, $title, $message, $buttonMessage);
    }

    /**
     * @param $type
     * @param null $header
     * @param null $title
     * @param null $message
     * @param null $buttonMessage
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

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('flash_messages', array($this, 'outputMessages'), array('needs_environment'=>true, 'is_safe' => array('html'))),
            new \Twig_SimpleFunction('modal_flash_messages', array($this,'outputModalMessages'),array('needs_environment'=>true,'is_safe'=>array('html'))),
        );
    }

    /**
     * @param \Twig_Environment $environment
     * @return string
     */
    public function outputMessages(\Twig_Environment $environment)
    {
        return $environment->render($this->template);
    }

    /**
     * @param \Twig_Environment $environment
     * @return string
     */
    public function outputModalMessages(\Twig_Environment $environment)
    {
        return $environment->render($this->modalTemplate);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'flash_message';
    }
}
