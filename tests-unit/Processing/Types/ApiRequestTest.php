<?php

namespace calderawp\caldera\Forms\Tests\Processing\Types;

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
		$request = new Request();
		$request->setParam('apiKey', 'dsadfssdf' );

		$maiLChimpClient = new MC;
		$maiLChimpClient->getLists($request);
		$processor = new ApiRequest();
		$this->assertEquals( 'apiRequest', $processor->getProcessorType() );
	}
}

