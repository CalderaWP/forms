<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsArrayLike;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Processing\ProcessorMeta;
use calderawp\caldera\Forms\Processing\Types\ApiRequest;
use calderawp\caldera\Forms\Processing\Types\Callbacks\ApiRequestPre;

use calderawp\caldera\Http\CalderaHttp;
use calderawp\caldera\restApi\Request;
use calderawp\CalderaContainers\Service\Container;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class ApiRequestPreTest extends IntegrationTestCase
{

	/**
	 * Test that process callback does the right processing.
	 */
	public function testProcess()
	{
		$form = $this->getFormWithApiRequestProcessor();
		$mockResponse = new Response(200, ['X-HELLO' => 'ROY'], json_encode(['messageFromServer' => 'Everything Is Possible.']));
		$mock = new MockHandler([
			$mockResponse,
		]);
		$handler = HandlerStack::create($mock);

		$client = new Client(['handler' => $handler]);

		\caldera()->getHttp()->setClient($client);

		$processor = $form['processors']['superCool'];
		$callback = (new ApiRequestPre(
			$form,
			\caldera()->getCalderaForms()
		) )->setProcessor(Processor::fromArray($processor));

		$request = new Request();
		$request->setParams([
			'fieldOne' => 'Seventeen Seconds',
			'fieldToUpdate' => 17,
		]);
		$formFields = new FieldsArrayLike();
		$result = $callback->process($formFields,$request );
		$this->assertEquals(
			'Everything Is Possible.',
			$formFields['messageFromApi']
		);

	}

	/**
	 * @return FormArrayLike
	 */
	protected function getFormWithApiRequestProcessor(): FormArrayLike
	{
		$apiRequestProcessor = new ApiRequest();
		$field = FieldModel::fromArray(
			[
				'id' => 'fld1',
				'slug' => '',
			]
		);
		$model = FormModel::fromArray([
			'id' => 'superGoodness',
			'form' => $this->form(),
			'fields' => [$field],
			'processors' => [
				[
					'id' => 'superCool',
					'type' => $apiRequestProcessor->getProcessorType(),
					'label' => 'Test sending form data to test API',
					'config' => [
						'requestURL' => 'https://something.com',
						'requestMethod' => 'POST',
						'responseField' => 'messageFromServer',
						'fieldToUpdate' => 'messageFromApi',
					]
				]

			]
		]);


		return FormArrayLike::fromModel($model);
	}

}
