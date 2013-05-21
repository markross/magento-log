<?php
/**
 * @category   TrueAction
 * @package    TrueAction_AdvanceLog
 * @copyright  Copyright (c) 2012 True Action Network (http://www.trueaction.com)
 */
class TrueAction_AdvanceLog_Test_Model_System_Config_Source_Log_LevelsTest extends EcomDev_PHPUnit_Test_Case
{
	protected $_levels;

	/**
	 * setUp method
	 **/
	public function setUp()
	{
		parent::setUp();
		$this->_levels = $this->_getLevels();
	}

	protected function _getLevels()
	{
		if(!$this->_levels){
			$this->_levels = mage::getModel('advancelog/system_config_source_log_levels');
		}
		return $this->_levels;
	}

	/**
	 * testing toOptionArray
	 *
	 * @test
	 */
	public function toOptionArray()
	{
		$this->assertNotEmpty(
			$this->_getLevels()->toOptionArray()
		);
	}
}
