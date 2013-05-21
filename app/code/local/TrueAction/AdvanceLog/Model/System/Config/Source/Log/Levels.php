<?php
/**
 * @category TrueAction
 * @package TrueAction_AdvanceLog
 * @copyright Copyright (c) 2013 True Action Network (http://www.trueaction.com)
 * @author TrueAction
 * @license TrueAction
 * @link http://www.trueaction.com
 */
class TrueAction_AdvanceLog_Model_System_Config_Source_Log_Levels
{
	/**
	 * Options getter
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		return array(
			array('value' => 0, 'label' => 'EMERG => Emergency: system is unusable'),
			array('value' => 1, 'label' => 'ALERT => Alert: action must be taken immediately'),
			array('value' => 2, 'label' => 'CRIT => Critical: critical conditions'),
			array('value' => 3, 'label' => 'ERR => Error: error conditions'),
			array('value' => 4, 'label' => 'WARNING => Warning: warning conditions'),
			array('value' => 5, 'label' => 'NOTICE => Notice: normal but significant condition'),
			array('value' => 6, 'label' => 'INFO => Informational: informational messages'),
			array('value' => 7, 'label' => 'DEBUG => Debug: debug messages'),
		);
	}
}
