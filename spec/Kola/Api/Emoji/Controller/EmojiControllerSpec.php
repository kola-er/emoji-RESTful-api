<?php

namespace spec\Kola\Api\Emoji\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmojiControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kola\Api\Emoji\Controller\EmojiController');
    }
}
