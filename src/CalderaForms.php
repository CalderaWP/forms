<?php


namespace calderawp\caldera\Forms;

use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\caldera\Db\Contracts\FormsDb;

class CalderaForms extends Module
{
	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return 'calderaForms';
	}

	public function registerServices(): CalderaModule
	{
		return $this;
	}


	public function getFormsDb(): FormsDb
	{
	}
}
