<?php

require_once dirname(__FILE__) . '/TestHelper.php';

class ResponseTest extends PHPUnit_Framework_TestCase {
  
  /**
   * @test
   */
  public function _getStatuses_should_return_false_on_invalid_code() {
    $method = new ReflectionMethod('Response', '_getStatuses');
    $method->setAccessible(true);
    
    $this->assertFalse($method->invoke(new Response, 'lolz'));
  }
  
  /**
   * @test
   */
  public function _getStatuses_should_return_string_for_valid_response() {
    $method = new ReflectionMethod('Response', '_getStatuses');
    $method->setAccessible(true);
    
    foreach( array(200, 301, 404, 'js', 'json', 'css', 'xml', 'rss') as $code ) {
      $this->assertInternalType('string', $method->invoke(new Response, $code));
    }
  }
  
}