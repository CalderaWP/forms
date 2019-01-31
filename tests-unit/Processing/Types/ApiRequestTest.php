<?php

namespace calderawp\caldera\Forms\Tests\Processing\Types;

use calderawp\caldera\Forms\Processing\Mailchimp;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\Types\ApiRequest;
use calderawp\caldera\Http\Request;
use PHPUnit\Framework\TestCase;

class ApiRequestTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Types\ApiRequest::getCallbacks()
	 */
	public function testGetCallbacks()
	{
		$processor = new ApiRequest();
		$this->assertArrayHasKey( Processor::PRE_PROCESS, $processor->getCallbacks() );
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Types\ApiRequest::getProcessorType()
	 */
	public function testGetProcessorType()
	{
		$processor = new ApiRequest();
		$this->assertSame('apiRequest',$processor->getProcessorType() );
	}
}

