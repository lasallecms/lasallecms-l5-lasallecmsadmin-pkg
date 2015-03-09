<?php



class ExampleTest extends PHPUnit_Framework_TestCase  {

    public function testIPAddressCheckTrue()
    {
        $allowedIPAddress = '99.999.999.999';
        $requestIPAddress = '99.999.999.999';
        $this->assertEquals($allowedIPAddress, $requestIPAddress);
    }




}