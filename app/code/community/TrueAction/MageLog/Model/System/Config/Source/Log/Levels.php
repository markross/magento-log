<?php
/**
 * @category   TrueAction
 * @package    TrueAction_MageLog
 * @copyright  Copyright (c) 2013 True Action Network (http://www.trueaction.com)
 */
class TrueAction_MageLog_Model_System_Config_Source_Log_Levels
{
	/**
	 * Options getter
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		$r = new ReflectionClass('Zend_Log');
		$results = array();
		foreach($r->getConstants() as $label => $value) {
			$results[] = array(
				'value' => $value,
				'label' => $label
			);
		}

		return $results;
	}
}
