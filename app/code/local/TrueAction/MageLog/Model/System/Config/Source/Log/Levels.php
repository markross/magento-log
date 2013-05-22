<?php
/**
 * @category TrueAction
 * @package TrueAction_MageLog
 * @copyright Copyright (c) 2013 True Action Network (http://www.trueaction.com)
 * @author TrueAction
 * @license TrueAction
 * @link http://www.trueaction.com
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
        $priorities = array_flip($r->getConstants());
		$idx = 0;
		$results = array();
		foreach($priorities as $priority){
			$results[] = array(
				'value' => $idx,
				'label' => $priority
			);
			$idx++;
		}
		return $results;
	}
}
