<?php

require_once dirname(__FILE__) . '/TestHelper.php';

class ErrorTest extends PHPUnit_Framework_TestCase {
  
  /**
   * @test
   */
  public function the_log_method_should_add_the_error_to_the_stack() {
    $error = Error::log('yup, we have a problem');
    $this->assertContains((array) $error, Error::$errors);
  }
  
  /**
   * @test
   */
  public function it_should_return_the_error_object() {
    $error = Error::log("didn't say the magic word");
    
    // make sure it is a class
    $this->assertEquals('stdClass', get_class($error));
    
    // make sure it assigns the attributes
    $this->assertObjectHasAttribute('at', $error);
    $this->assertObjectHasAttribute('message', $error);
    $this->assertObjectHasAttribute('stack_trace', $error);
    
    // did it assign them correctly
    $this->assertInternalType('float', $error->at);
    $this->assertEquals("didn't say the magic word", $error->message);
    $this->assertInternalType('array', $error->stack_trace);
  }
  
  /**
   * @test
   */
  public function it_should_return_all_the_errors() {
    $errors = Error::$errors;
    $this->assertEquals($errors, Error::output());
  }
  
}