<?php

namespace NS\FlashBundle\Interfaces;

/**
 *
 * @author gnat
 */
interface Message
{
    public function getTitle();

    public function setTitle($title);

    public function getMessage();

    public function setMessage($message);

    public function getButtonMessage();

    public function setButtonMessage($buttonMessage);

    public function getHeader();

    public function setHeader($header);
}

