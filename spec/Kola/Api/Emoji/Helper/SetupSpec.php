<?php

namespace spec\Kola\Api\Emoji\Helper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SetupSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kola\Api\Emoji\Helper\Setup');
    }

	/**
	 * Test helper format function
	 */
	function it_converts_a_string_in_an_array_to_array() {
		$this->format(['emoji_name' => 'Angry', 'keyword' => 'anger furious mad', 'category' => 'mood'])
			->shouldReturn(['emoji_name' => 'Angry', 'keyword' => ['anger', 'furious', 'mad'], 'category' => 'mood']);
	}
}
