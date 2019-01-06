<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Processing\ProcessorMeta;
use PHPUnit\Framework\TestCase;

class CalderaFormsTest extends TestCase
{

	/**
	 * Can get this module from the container.
	 */
	public function testInCore()
	{
		$this->assertInstanceOf(CalderaForms::class, \caldera()->getCalderaForms());
	}

	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getForms()
	 * @covers \calderawp\caldera\Forms\FormModel::getProcessors()
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::addProcessor()
	 */
	public function testAddFormProcessor()
	{
		$type = 'testType';
		$processor = new Processor(
			new ProcessorMeta(
				[
					'type' => $type
				]
			),
			new ProcessorConfig()
		);

		$forms = \caldera()
			->getCalderaForms()
			->getForms();
		$this->assertFalse($forms->getForm('contact-form' )->getProcessors()->hasProcessorOfType($type));

		$forms->getForm('contact-form' )->getProcessors()->addProcessor($processor);
		$this->assertInstanceOf(FormModel::class, $forms->getForm('contact-form'));
		$this->assertTrue($forms->getForm('contact-form' )->getProcessors()->hasProcessorOfType($type));
	}


	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getForms()
	 * @covers \calderawp\caldera\Forms\FormsCollection::addForm()
	 */
	public function testAddForm()
	{
		$form = FormModel::fromArray([
			'id' => 'form2',
		]);

		\caldera()
			->getCalderaForms()
			->getForms()
			->addForm($form);

		$this->assertSame(
			\caldera()
				->getCalderaForms()
				->getForms()
			->getForm('form2')
			->getId(),
			'form2'
		);
	}
}
