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
        $this->buttonMessage = $buttonMessage ?? 'Close';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getButtonMessage()
    {
        return $this->buttonMessage;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }
}
