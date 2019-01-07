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

* Validate Fields - Run default field validation and field validation processors.
* Pre-Process - Run all pre-process callbacks to validate submission.
    - Process payments, subscribe to email lists, etc. here.
* Save - Save entry in database -- if enabled.
    - Generally processors do not act here.
* Process - Modify the saved -- it it saved -- entry in database.
    - Assume submission is valid, create post, register user, etc.
* Post-Process - Last chance before completing.
    - Send emails here.
    - Not often used.
    
## Creating A Processor

## Creating Processor Callbacks

## Unit Testing A Processor
