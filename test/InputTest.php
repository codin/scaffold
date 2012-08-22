<?php

require dirname(__FILE__) . '/TestHelper.php';

class InputTest extends PHPUnit_Framework_TestCase {
  
  /**
   * @test
   */
  public function posted_should_check_if_any_items_were_posted() {
    $_POST['howdy'] = 'hi';
    $this->assertGreaterThan(0, Input::posted());
  }
  
  /**
   * @test
   */
  public function posted_should_check_a_specific_item() {
    $_POST['mcfly'] = 'marty';
    $this->assertTrue(Input::posted('mcfly'));
  }
  
  /**
   * @test
   */
  public function posted_should_check_multiple_items() {
    $_POST['wayne'] = 'batman';
    $_POST['kent'] = 'superman';
    $this->assertTrue(Input::posted(array('wayne', 'kent')));
  }
  
  /**
   * @test
   */
  public function get_should_use_fallback_if_key_is_not_set() {
    $this->assertEquals('blah', Input::get('nope', 'blah'));
  }
  
  /**
   * @test
   */
  public function get_should_find_the_value() {
    $_GET['whats'] = 'up';
    $this->assertEquals('up', Input::get('whats', 'down'));
  }
  
  /**
   * @test
   */
  public function post_should_use_fallback_if_key_is_not_set() {
    $this->assertEquals('uh', Input::post('nope', 'uh'));
  }
  
  /**
   * @test
   */
  public function post_should_find_the_value() {
    $_POST['you_ate_my_cookie'] = 'whaat?';
    $this->assertEquals('whaat?', Input::post('you_ate_my_cookie', 'yes i did'));
  }
  
  /**
   * @test
   */
  public function hash_should_return_null_if_method_does_not_exist() {
    $this->assertNull(Input::hash('no_buffet', 'lolz'));
  }
  
  /**
   * @test
   */
  public function hash_should_hash_get_value_from_available_methods() {
    $_GET['password'] = $_POST['password'] = 'secret';
    $hashed = 'e5e9fa1ba31ecd1ae84f75caaa474f3a663f05f4';
    
    $this->assertEquals($hashed, Input::hash('password', 'get'));
    $this->assertEquals($hashed, Input::hash('password', 'post'));
  }
  
  /**
   * @test
   */
  public function _receive_should_use_fallback() {
    $method = new ReflectionMethod('Input', '_receive');
    $method->setAccessible(true);
    
    $this->assertEquals('gotcha', $method->invoke(null, $_GET, 'fake_key', 'gotcha'));
    $this->assertEquals('gotcha', $method->invoke(null, $_POST, 'fake_key', 'gotcha'));
  }
  
  /**
   * @test
   */
  public function _receive_should_use_var_if_set() {
    $_GET['real_key'] = $_POST['real_key'] = "it's howdy doody time";
    
    $method = new ReflectionMethod('Input', '_receive');
    $method->setAccessible(true);
    
    $this->assertEquals("it's howdy doody time", $method->invoke(null, $_GET, 'real_key', 'gotcha'));
    $this->assertEquals("it's howdy doody time", $method->invoke(null, $_POST, 'real_key', 'gotcha'));
  }
  
}