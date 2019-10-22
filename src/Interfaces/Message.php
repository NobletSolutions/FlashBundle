<?php

namespace NS\FlashBundle\Interfaces;

interface Message
{
    public function getTitle();

    public function getMessage();

    public function getButtonMessage();

    public function getHeader();

}

