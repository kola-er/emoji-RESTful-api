<?php

namespace spec\Kola\Api\Emoji\Middleware;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorizeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kola\Api\Emoji\Middleware\Authorize');
    }
}
