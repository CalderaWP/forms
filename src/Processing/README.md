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

### Processor Config
    
## Creating A Processor

To create a processor, you should begin with a class extending `ProcessorType` or implement the contract. This will force you to implement two methods:

* `getProcessorType()` - Return a string with the "slug" of the processor. For example "mailchimp" or "stripe".
* `getCallbacks()` An array of zero or more processor callback functions. 

### Registering Processor Callbacks

For any of the processing steps you wish for your processor type to dispatch a process on, you must create a class extending `ProcessCallback` and add it to the array returned by `getCallbacks()`. The array should be indexed using constants form the `Process` class, which are documented in more detail inline. The array values are the names of classes to call when it is time for form processing.

```php
use calderawp\caldera\Forms\Processing\Processor;

    [
        Processor::PRE_PROCESS => PreProcessCallbackClass::class,
        Processor::MAIN_PROCESS => MainProcessCallbackClass::class,
        Processor::POST_PROCESS => PostProcessCallbackClass::class,
    ]
```

### Creating Processor Callbacks

At each processing stage, the process callback is provided a `FieldsArrayLike` with the current submission field values and the current request.

At any stage in the process, throwing an exeception will cause the form processing to stop and return an error to the client. The error message is set from the exception's message property.

At the pre-process stage, changing the values of the fields will cause the corresponding fields in the request to change. If entries are being saved, the effect of this is that the saved value will be be the value updated on the request object.

At the main process and post-process stage, changing the values of the fields will cause the entry values -- including in the database if entry saving is enabled -- to change.

#### Remote API Requests Must Use Http Package

If you are creating a processor that makes Http requests to a 3rd-party API or something, you MUST use the CalderaHttp::send() method to send the request. Deviation will probably not be tolerated.

The README for the Http package describes how to do so.


## Unit Testing A Processor


