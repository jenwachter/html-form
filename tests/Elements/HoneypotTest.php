<?php

namespace HtmlForm\Elements;

class HoneypotTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Honeypot("test", "Test");

    $expected = "<div class=\"honeypot\" style=\"display: none;\"><input type=\"text\" name=\"test\"  value=\"\" /></div>";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
