<?php


namespace calderawp\caldera\Forms\Filters;

final class ProcessEventPriorities
{

	/**
	 * Filter priority that field validators should register on.
	 *
	 * @type int
	 */
	const VALIDATE_FIELDS = 1;

	/**
	 * Filter priority that pre-process callbacks should register on.
	 *
	 * @type int
	 */
	const PRE_PROCESS = 3;

	/**
	 * Filter priority that entry data saving callbacks should register on.
	 *
	 * @type int
	 */
	const SAVE = 4;

	/**
	 * Filter priority that  main process callbacks should register on.
	 *
	 * @type int
	 */
	const PROCESS = 5;

	/**
	 * Filter priority that post-process callbacks should register on.
	 *
	 * @type int
	 */
	const POST_PROCESS = 7;

	private function __construct()
	{
		//this class can not be instantiated.
	}
}
