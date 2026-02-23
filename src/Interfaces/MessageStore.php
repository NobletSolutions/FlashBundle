<?php

namespace NS\FlashBundle\Interfaces;

interface MessageStore
{
    public function addSuccess(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool;
    public function addWarning(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool;
    public function addError(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool;
    public function addInfo(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool;
    public function add(?string $header = null, ?string $title = null, ?string $message = null, ?string $buttonMessage = null): bool;
}
