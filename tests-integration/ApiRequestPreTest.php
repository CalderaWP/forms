<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsArrayLike;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;
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

	public function testProcess()
	{
		$this->markTestSkipped('Too hot. Come back hotter' );
		$form = $this->getFormWithApiRequestProcessor();
		$mockResponse = new Response(200, ['X-HELLO' => 'ROY'], json_encode(['messageFromServer' => 'Hi Server']));
		$mock = new MockHandler([
			$mockResponse,
		]);
		$handler = HandlerStack::create($mock);

		$client = new Client(['handler' => $handler]);

		\caldera()->getHttp()->setClient($client);
		$form = new FormModel();
		//$form->getProcessors()->get
		//$calderaForms = new CalderaForms(\caldera(), new Container());
		var_dump($form['processors']);exit;
		$callback = new ApiRequestPre(
			$form,
			$this->calderaForms()
		);

		$request = new Request();
		$request->setParams([
			'fieldOne' => 'Seventeen Seconds',
			'fieldTwo' => 17,
		]);
		$formFields = new FieldsArrayLike();
		$result = $callback->process($formFields,$request );
		$this->assertEquals(
			'Hi Server',
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
			'form' => $this->form(),
			'fields' => [$field],
			'processors' => [
				[
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
