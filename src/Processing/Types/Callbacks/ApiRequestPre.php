<?php


namespace calderawp\caldera\Forms\Processing\Types\Callbacks;

use calderawp\caldera\Forms\Exception;
use calderawp\caldera\Forms\Processing\ProcessCallback;
use calderawp\interop\Contracts\FieldsArrayLike;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;

class ApiRequestPre extends ProcessCallback
{

	/** @inheritdoc */
	public function process(FieldsArrayLike $formFields, Request $request): FieldsArrayLike
	{
		$url = $this->getConfigFieldValue('requestURL', $formFields);
		if (! filter_var($url, FILTER_VALIDATE_URL)) {
			throw new Exception('Invalid URL for API request');
		}

		$requestMethod =  $this->getConfigFieldValue('requestMethod', $formFields);

		if (! in_array($requestMethod, [
			'GET',
			'POST',
			'PUT',
			'DELETE',
		])) {
			$requestMethod = 'GET';
		}
		$apiRequest = new \calderawp\caldera\Http\Request();
		$apiRequest->setHttpMethod($requestMethod);
		$apiRequest->setParams($formFields->toArray());
		try {
			$response = $this
				->getHttp()
				->send($apiRequest, $url);
		} catch (\Exception $e) {
			throw  $e;
		}

		$responseField = $this->getConfigFieldValue('responseField', $formFields);
		$fieldToUpdate = $this->getConfigFieldValue('fieldToUpdate', $formFields);
		if ($responseField && $fieldToUpdate) {
			$formFields[$fieldToUpdate] = isset($response->getData()[$responseField]) ? $response->getData()[$responseField] : '';
		}
		return $formFields;
	}
}
