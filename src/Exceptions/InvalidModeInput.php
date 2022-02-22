<?php
namespace Mas\Acl\Exceptions;

class InvalidModeInput extends \Exception 
{
    public function __construct(?int $mode) {
        
        parent::__construct("Your mode couldn't parse: $mode !");
    }
}