<?php

namespace NS\FlashBundle\Model;

use NS\FlashBundle\Interfaces\Message;

class FlashMessage implements Message
{
    private $header;
    private $title;
    private $message;
    private $buttonMessage;

    /**
     *
     * @param string $header
     * @param string $title
     * @param string $message
     * @param string $buttonMessage
     */
    public function __construct($header = null, $title = null, $message = null, $buttonMessage = null)
    {
        $this->header        = $header;
        $this->title         = $title;
        $this->message       = $message;
        $this->buttonMessage = (is_null($buttonMessage)) ? 'Close':$buttonMessage;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $title
     * @return \NS\FlashBundle\Model\FlashMessage
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     *
     * @param string $message
     * @return \NS\FlashBundle\Model\FlashMessage
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getButtonMessage()
    {
        return $this->buttonMessage;
    }

    /**
     *
     * @param string $buttonMessage
     * @return \NS\FlashBundle\Model\FlashMessage
     */
    public function setButtonMessage($buttonMessage)
    {
        $this->buttonMessage = $buttonMessage;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     *
     * @param string $header
     * @return \NS\FlashBundle\Model\FlashMessage
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }
}
