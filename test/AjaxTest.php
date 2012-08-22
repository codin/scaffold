<?php

require_once dirname(__FILE__) . '/TestHelper.php';

class AjaxTest extends PHPUnit_Framework_TestCase {
  
  /**
   * @test
   */
  public function validOrigin_should_return_false_when_origin_is_invalid() {
    Ajax::$noDirect = true;
    $_SERVER['HTTP_X_REQUESTED_WITH'] = 'BlahBlahBlah';
    
    $this->assertFalse(Ajax::validOrigin());
  }
  
  /**
   * @test
   */
  public function validOrigin_should_return_true_when_origin_is_valid() {
    Ajax::$noDirect = true;
    $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
    
    $this->assertTrue(Ajax::validOrigin());
  }
  
}