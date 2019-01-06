<?php


namespace calderawp\caldera\Forms\Filters;

final class ProcessEventPriories
{

	const VALIDATE_FIELDS = 1;
	const PRE_PROCESS = 3;
	const SAVE = 4;
	const PROCESS = 5;
	const POST_PROCESS = 7;

	private function __construct()
	{

		//this class can not be instantiated.
	}
}
