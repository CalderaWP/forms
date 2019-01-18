# Caldera Forms Processors

## Overview
`use calderawp\caldera\Forms\Processing`

During form processing, each processor in the collection -- the `ProcessorCollection` instance provided by the form being processed, one instance of `Processor` is insantiated per processor. This class takes the processor's meta info -- represented by a `ProcessorMeta` object -- and the saved settings values -- represented by a`ProcessorConfig` object. `Processor` acts as a dispatcher for registered callbacks.

The callbacks, which must (or fatal errors) extend `ProcessCallback` are where the business logic of the processor goes. A proccesrrort

* `ProcessorCollection` - A group of processors.
* `Processor` - Process controller for one processor 
* `ProcessorMeta` - Details about an instance of a processor in collection - type, label, id, etc.
* `ProcessorConfig` - The saved settings of a processor.
* `ProcessCallback` - Does something to form submission when called by `Processor`.
* `ProcessorType` - Defines a type of processor that a user can chose.

#### Processing Loop
When processing a form submission, Caldera Forms will do four loops:

* Validate Fields - Run default field validation and field validation processors.
* Pre-Process - Run all pre-process callbacks to validate submission.
    - Process payments, subscribe to email lists, etc. here.
* Save - Save entry in database -- if enabled.
    - Generally processors do not act here.
* Main Process - Modify the saved -- it it saved -- entry in database.
    - Assume submission is valid, create post, register user, etc.
* Post-Process - Last chance before completing.
    - Send emails here.
    - Not often used.
    
A processor may add a callback at any of these steps.


### Processor Meta
The processor meta data is the unique identifying information for a specific processor saved in a form for an instance of a processor, not including its saved settings. A form may have two Redirect processors, the meta data for both processors will include type "redirect", and a different id.

Processor meta is represented by `ProcessorMeta` which extends `calderawp\interop\ArrayLike`, which implements `\ArrayAccess` and may be used like an array. 

Processor meta properties are:

* `id` - The unique ID of a processor.
    - Required
    - `$processorMeta['id']` or `$processorMeta->getId()` returns id prop, setting it to a random value if not already set.
* `label` - A label for the processor.
    - Optional.
    - Helps in admin UI give context to processors list.
* `type` - The processor type
    - Required
    - What type of processor is this?
    
```php
//Create processeor meta
$processorMeta = new ProcessorMeta(['label' => 'Main sign up', 'type' => 'user-register']);

$id = $processorMeta->getId();
$id = $processorMeta[ 'id' ];
$label = $label[ 'label' ];
$label = $processorMeta->getLabel();
$type = $processorMeta['type'];
$type = $processorMeta->getType();
```

If your processor had the type "autoresponder" and the id of `741`, then you could create the meta object like this:

`$processorMeta = new ProcessorMeta( [ 'id' => 741, 'type' => 'autoresponder' ])`
    
### Processor Config
The processor config data is the saved settings for a unique instance of a form. The same object could be used to represent default values of a processor. The processor settings is represented by the objects of the class `ProcessorConfig`.


## Creating A Processor

To create a processor, you should begin with a class extending `ProcessorType` or implement the contract. This will force you to implement two methods:

* `getProcessorType()` - Return a string with the "slug" of the processor. For example "mailchimp" or "stripe".
* `getCallbacks()` An array of zero or more processor callback functions. 


### Create Processor Config
This object is created by the submission processes. 

```php
new ProcessorConfig(
	[
		'leadName' => 'firstNameField', //use value of field with id "firstNameField"
		'leadEmail' => 'lastNameField', //use value of field with id "lastNameField"
		'listSegment' => 'new-leads', //use this value entered into field settings.
	]
);

```

### Registering Processor Callbacks

For any of the processing steps you wish for your processor type to dispatch a process on, you must create a class implementing `calderawp\caldera\Forms\Contracts\ProcessorCallbackContract` which can be achieved most easily by extending `ProcessCallback` and add it to the array returned by `getCallbacks()`. The array should be indexed using constants form the `Process` class, which are documented in more detail inline. The array values are the names of classes to call when it is time for form processing.

```php
use calderawp\caldera\Forms\Processing\Processor;

    [
        Processor::PRE_PROCESS => PreProcessCallbackClass::class, // process callback to run at pre-process
        Processor::MAIN_PROCESS => MainProcessCallbackClass::class,  // process callback to run at main process
        Processor::POST_PROCESS => PostProcessCallbackClass::class, //process callback to run at post-process
    ]
```

### Creating Processor Callbacks

At each processing stage, the process callback is provided a `FieldsArrayLike` with the current submission field values and the current request.

At any stage in the process, throwing an exception will cause the form processing to stop and return an error to the client. The error message is set from the exception's message property.

At the pre-process stage, changing the values of the fields will cause the corresponding fields in the request to change. If entries are being saved, the effect of this is that the saved value will be be the value updated on the request object.

At the main process and post-process stage, changing the values of the fields will cause the entry values -- including in the database if entry saving is enabled -- to change.


#### `setProcessor()` 
Used to add the `Processor` instance to the class, so it can be used to access config field values, etc. Sets the protected property `processor`.

You probably only need to use this in testing.

#### `getConfigFieldValue()` 
Get the value of a specific config field. This is a method of the `ProcessCallback` class, it is not required by the interface -- it's protected. Be careful, that you do not call this method before the `processor` property is set or you will have errors and such.

* Example: 
```php
$url = $this->getConfigFieldValue('requestURL', $formFields);
if (! filter_var($url, FILTER_VALIDATE_URL)) {
    throw new Exception('Invalid URL for API request');
}

```

#### `getHttp()` 
Get the `CalderaHttp` object from core container to make HTTP requests with. This is a method of the `ProcessCallback` class, it is not required by the interface -- it's protected. 

* Example: 
```php
$http = $this->getHttp()->send( $request, $url );
```

* This is explained more fully below and in the docs of the `calderawp/http` package.


#### `process()`
This method will be called during form submission to apply the processing that the form processor provides at that stage in form submission. This method has the buisness logic of the processor.

##### Exceptions stop processing, which is shown in the client as an alert.
```php
    public function process(FieldsArrayLike $formFields, Request $request): FieldsArrayLike
	{
	    //Find value of setting
		$url = $this->getConfigFieldValue('requestURL', $formFields);
		//Not a valid URL?
		if (! filter_var($url, FILTER_VALIDATE_URL)) {
		    //Stop form processing
			throw new \Exception(
			'Invalid URL for API request', // Show this message in the client as the reason for the error.
			 422 //Use this status code when sending response to client. 
         );
		}
	}

```


#### Remote API Requests Must Use Http Package

If you are creating a processor that makes Http requests to a 3rd-party API or something, you MUST use the CalderaHttp::send() method to send the request. Deviation will probably not be tolerated.

The README for the Http package describes how to do so.


```php
    //Create request object.
    $apiRequest = new \calderawp\caldera\Http\Request();
    $apiRequest->setHttpMethod('POST'); //send via POST
    $apiRequest->setParams([ 'transactionTotal' => 4.55]);
    
    try {
        $response = $this
            ->getHttp()
            ->send(
                $apiRequest, //The request to make.
                $url //The URL to send request to.
             );
    } catch (\Exception $e) {
        //learn about error
        //You probably want to allow this to be thrown.
    }
```

### Mutate Fields To Change Values

```php

public function process(FieldsArrayLike $fields, Request $request): FieldsArrayLike
{
    $fields[ 'description' ] = '4 Stones, one is purple, one is red, one is green, the other is not.';
    return $fields; 
}
```

## Testing A Processor

### The Meta and Processor Config Objects?
These classes are created internally, you need to know about them, but you probably don't need to create them manually. You will use them when testing, but they probably do not need to be tested when testing a specific processor. The tests for the processor are concerned with that processor, not the processing system.


### Unit Testing ProcessorType

* Are the callback(s) in the callbacks array? 
    - This test is not concerned with if the callbacks work or are even callable, other tests will fail if they don't.
    
```php
	/**
	 * @covers \calderawp\caldera\Forms\Processing\Types\ApiRequest::getCallbacks()
	 */
	public function testGetCallbacks()
	{
		$processor = new ApiRequest();
		$this->assertArrayHasKey( Processor::PRE_PROCESS, $processor->getCallbacks() );
	}
```

* Is the type correct?
    - If the value of the getProcessorType() method changes accidentally then the processor will fail for a lot of reasons, this prevents that.
    
 ```php
 	/**
 	 * @covers \calderawp\caldera\Forms\Processing\Types\ApiRequest::getProcessorType()
 	 */
 	public function testGetProcessorType()
 	{
 		$processor = new ApiRequest();
 		$this->assertEquals( 'apiRequest', $processor->getProcessorType() );
 	}
 ```
 
 ### Unit Testing Processor Callbacks
 I'm not convinced this makes any sense to do because it involves so many different parts of the system. The amount of mocks needed to unit test this would be stupid most of the time. 
 
 ### Integration Testing 
 See the phpunit cheatsheat for info on mocking Guzzle.
 
 This test is copied from the test for the API request processor. It sets up a mock HTTP response and then tests that the right field of that response ended up in the right index of the fields array. 
 
 This test is not concerned with what happens to fields after it is returned. Other tests are cover that functionality.
 
 ```php
 	/**
 	 * Get the 
 	 */
 	public function testProcess()
 	{
 	    //Api returns this string, processor saves in a field
 	    $expectedValue = 'Three Is The Number After Two';
 	    //Look at the forms integration tests for this
 		$form = $this->getFormWithApiRequestProcessor();
 		
 		//Create guzzle client with mock responses
 		$mockResponse = new Response(200, ['X-HELLO' => 'ROY'],
 			json_encode(['messageFromServer' => $expectedValue])); //Api sends the value
 		$mock = new MockHandler([
 			$mockResponse,
 		]);
 		$handler = HandlerStack::create($mock);
 		$client = new Client(['handler' => $handler]);
 
        //Swap testing client into container
 		\caldera()->getHttp()->setClient($client); //never do this in a unit test.
 
        //Get the form processors
 		$processor = $form[ 'processors' ][ 'superCool' ];
 		
 		//Creat callback and give it the processor
 		$callback = (new ApiRequestPre(
 			$form,
 			\caldera()->getCalderaForms()
 		))->setProcessor(Processor::fromArray($processor));
 
        //Fake request to create form entry
 		$request = new Request();
 		$request->setParams([
 		    'entryValues' => [
                [
                    'fieldOne' => 'Seventeen Seconds',
                    'fieldToUpdate' => 17, //this should change due to processing
                ]
            ]
 		);
 		$formFields = new FieldsArrayLike();
 		$result = $callback->process($formFields, $request);
 		//did the return value for this field change?
 		$this->assertEquals(
 			$expectedValue, 
 			$formFields[ 'messageFromApi' ]
 		);
 
 	}
 

 
 ```
 
 
 #### API Requests Should Be Tested Separately
 
 The tests of processor callbacks should assume that any HTTP requests that the processor make function as expected. This assumption requires those requests to have unit tests and maybe acceptance tests against a live (sandbox) API.

 ### Acceptance Tests

This is probably where you should start. When you write an integration or unit test for a remote request, you use mock API responses that represent what the real API will respond with in different scenarios you need to cover. How do you know what those responses look like? Read the docs, use Postman to experiment, write some pseudo-code, that's how I always did it. 

Acceptance tests use live APIs, so you can create acceptance tests that take a request object, send it to the real API and then make assertions on the response, you have the basis for integration/unit tests and acceptance tests that are valuable.

This test checks makes a real HTTP request and checks the response:

```php
	public function testSend()
	{
		$url = 'http://localhost:5000/caldera-api/v2/roy';
		$request = Request::fromArray([
			'headers' => [],
			'params' => [
			    'fieldOne' => 'valueOne'
			],
		]);
		$http = new CalderaHttp($this->core(), $this->serviceContainer());
		$response = $http->send($request, $url);
		$this->assertSame(200, $response->getStatus());
		$this->assertArrayHasKey('Content-Length', $response->getHeaders());
		$this->assertArrayHasKey('Content-Type', $response->getHeaders());
		$this->assertArrayHasKey('blog', $response->getData());
		$this->assertArrayHasKey('location', $response->getData());
	}

```
 
 If, instead of defining `$request` in the test, we move that to a method of a trait, or a the test case class, then we could use the same request object in an integration tests and create a mock response that was the same as what we just tested for in the acceptance tests. This ensures that the mocks are valid mocks.
 
 Make sure to use environment variables for API keys! Yes, they are sandbox API keys. We do not want them abused or trigger false positives on security scans that a lot of these companies do now, looking for API keys committed on Github. Yes, there is a funny store here about a time I fucked up and did not ignore my .env file before pushing...
 
 Do this please. Then we will have acceptance tests that prove that all of the pieces come together and the remote API has changed and more isolated unit and integration tests that can fail before the more expensive acceptance tests fail.  
