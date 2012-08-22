<?php

require dirname(__FILE__) . '/TestHelper.php';

// override the framework's configuration
$config = array('db' => array('host' => 'localhost'));

class ConfigTest extends PHPUnit_Framework_TestCase {
  
  private $config;
  
  public function setUp() {
    global $config;
    $this->config = $config;
  }
  
  /**
   * @test
   */
  public function it_should_create_an_instance_of_Input() {
    $this->assertInstanceOf('Config', Config::instance());
  }
  
  /**
   * @test
   */
  public function it_should_get_config_setting() {
    $this->assertEquals($this->config['db'], Config::get('db'));
  }
  
  /**
   * @test
   */
  public function it_should_get_the_fallback() {
    $this->assertEquals('fake_data', Config::get('nope', 'fake_data'));
  }
  
  /**
   * @test
   */
  public function it_should_set_a_value() {  
    Config::set('language', 'en_US');
    $this->assertEquals('en_US', Config::get('language'));
  }
  
  /**
   * @test
   */
  public function it_should_get_all_items() {
    $this->assertEquals($this->config + array('language' => 'en_US'), Config::all(), 'message');
  }
  
}