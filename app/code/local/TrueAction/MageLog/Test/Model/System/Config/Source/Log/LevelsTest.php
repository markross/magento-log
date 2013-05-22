<?php
/**
 * @category   TrueAction
 * @package    TrueAction_MageLog
 * @copyright  Copyright (c) 2012 True Action Network (http://www.trueaction.com)
 */
class TrueAction_MageLog_Test_Model_System_Config_Source_Log_LevelsTest extends EcomDev_PHPUnit_Test_Case
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
			$this->_levels = mage::getModel('magelog/system_config_source_log_levels');
		}
		return $this->_levels;
	}

	/**
	 * testing toOptionArray
	 *
	 * @test
	 */
	public function testToOptionArray()
	{
		$this->assertSame(
			array(
				array('value' => Zend_Log::EMERG, 'label' => 'EMERG'),
				array('value' => Zend_Log::ALERT, 'label' => 'ALERT'),
				array('value' => Zend_Log::CRIT, 'label' => 'CRIT'),
				array('value' => Zend_Log::ERR, 'label' => 'ERR'),
				array('value' => Zend_Log::WARN, 'label' => 'WARN'),
				array('value' => Zend_Log::NOTICE, 'label' => 'NOTICE'),
				array('value' => Zend_Log::INFO, 'label' => 'INFO'),
				array('value' => Zend_Log::DEBUG, 'label' => 'DEBUG')
			),
			$this->_getLevels()->toOptionArray()
		);
	}
}
