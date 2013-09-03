<?php
class SectionRurale
{
	/**
	 * @var string
	 */
	public $commune;

	/**
	 * @var string
	 */
	public $section_rurale;

	public function __construct($commune, $section_rurale) {
		$this->commune = $commune;
		$this->section_rurale = $section_rurale;
	}
}

class SectionRurales extends ArrayObject
{
	public function __construct()
	{
		parent::__construct(array());
	}
	public function offsetSet($index, $newval) {
		if (!($newval instanceof SectionRurale)) {
			throw new InvalidArgumentException('You can only add values of type SectionRurale.');
		}
		parent::offsetSet($index, $newval);
	}
}
