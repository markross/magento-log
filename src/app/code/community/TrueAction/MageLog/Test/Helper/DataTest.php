<?php
class TrueAction_MageLog_Test_Helper_DataTest extends EcomDev_PHPUnit_Test_Case
{
	const HELPER = 'trueaction_magelog';
	/**
	 * Provide null as the store view. This is slightly better than not providing
	 * anything because it lets you know that these configuration values can change
	 * at the store view level, but we don't currently test that.
	 */
	public function provideStoreView()
	{
		return array(array(null));
	}
	/**
	 * Test that the configuration returns the expected isActive value from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testIsActive($store=null)
	{
		$this->assertSame(true, Mage::helper(self::HELPER)->isActive($store));
	}
	/**
	 * Test that the configuration returns the expected system.log file name from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetSystemLogFile($store=null)
	{
		$this->assertSame('systemdotlog', Mage::helper(self::HELPER)->getSystemLogFile($store));
	}
	/**
	 * Test that the configuration returns the expected exception.log file name from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetExceptionLogFile($store=null)
	{
		$this->assertSame('exceptiondotlog', Mage::helper(self::HELPER)->getExceptionLogFile($store));
	}
	/**
	 * Test that the configuration returns the expected log level from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetLogLevel($store=null)
	{
		$this->assertSame(3, Mage::helper(self::HELPER)->getLogLevel($store));
	}
	/**
	 * Test that the configuration returns the value from the fixture on whether or not email logging is enabled.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testIsEnableEmailLogging($store=null)
	{
		$this->assertTrue(Mage::helper(self::HELPER)->isEnableEmailLogging($store));
	}
	/**
	 * Test that the configuration returns the expected logging target email address from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetLoggingEmailAddress($store=null)
	{
		$this->assertSame('nobody@example.com', Mage::helper(self::HELPER)->getLoggingEmailAddress($store));
	}
	/**
	 * Test that the configuration returns the expected email loglevel from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetEmailLoggingLevel($store=null)
	{
		$this->assertSame(2, Mage::helper(self::HELPER)->getEmailLoggingLevel($store));
	}
	/**
	 * Test that the configuration returns the expected "from" email address from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetFromEmail($store=null)
	{
		$this->assertSame('nobody@example.com', Mage::helper(self::HELPER)->getFromEmail($store));
	}
	/**
	 * Test that the configuration returns the expected path to the system log file.
	 *
	 * @loadFixture loadConfig.yaml
	 */
	public function testGetLogFile()
	{
		$this->assertSame(Mage::getBaseDir('log') . DS . 'systemdotlog', Mage::helper(self::HELPER)->getLogFile());
	}
	/**
	 * Provide arguments for testing log methods.
	 */
	public function provideLogMethodArguments()
	{
		return array(
			array('[ %s ] %s message because %d', array(__CLASS__, 'foo', 7)),
		);
	}
	/**
	 * Test that we have a method for each Zend_Log const and that each calls _log with the right const.
	 *
	 * @dataProvider provideLogMethodArguments
	 */
	public function testLogMethods($format, $argSet)
	{
		$logger = $this->getHelperMock('trueaction_magelog/data', array('_log'));
		$logger->expects($this->at(0))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::EMERG), $this->identicalTo($argSet))->will($this->returnSelf());
		$logger->expects($this->at(1))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::ALERT), $this->identicalTo($argSet))->will($this->returnSelf());
		$logger->expects($this->at(2))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::CRIT), $this->identicalTo($argSet))->will($this->returnSelf());
		$logger->expects($this->at(3))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::ERR), $this->identicalTo($argSet))->will($this->returnSelf());
		$logger->expects($this->at(4))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::WARN), $this->identicalTo($argSet))->will($this->returnSelf());
		$logger->expects($this->at(5))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::NOTICE), $this->identicalTo($argSet))->will($this->returnSelf());
		$logger->expects($this->at(6))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::INFO), $this->identicalTo($argSet))->will($this->returnSelf());
		$logger->expects($this->at(7))->method('_log')->with($this->identicalTo($format), $this->equalTo(Zend_Log::DEBUG), $this->identicalTo($argSet))->will($this->returnSelf());
		$this->assertSame(
			$logger,
			$logger
				->logEmerg($format, $argSet)
				->logAlert($format, $argSet)
				->logCrit($format, $argSet)
				->logErr($format, $argSet)
				->logWarn($format, $argSet)
				->logNotice($format, $argSet)
				->logInfo($format, $argSet)
				->logDebug($format, $argSet)
		);
	}
}

