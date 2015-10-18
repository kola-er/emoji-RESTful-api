<?php

namespace spec\Kola\Api\Emoji\Auth;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthenticateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kola\Api\Emoji\Auth\Authenticate');
    }
}
