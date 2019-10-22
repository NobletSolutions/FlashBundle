<?php

namespace NS\FlashBundle\Interfaces;

interface MessageStore
{
    public function addSuccess($header = null, $title = null, $message = null, $buttonMessage = null);
    public function addWarning($header = null, $title = null, $message = null, $buttonMessage = null);
    public function addError($header = null, $title = null, $message = null, $buttonMessage = null);
    public function add($header = null, $title = null, $message = null, $buttonMessage = null);
}
