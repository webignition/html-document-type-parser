<?php

namespace webignition\Tests\HtmlDocumentType\Parser;

abstract class GetPropertyTest extends BaseTest {
    
    protected $methodName = 'invalidMethodName';
    protected $expectedResult = null;
    protected $key;
    
    protected function getKey() {
        return \ICanBoogie\hyphenate(str_replace('test', '', $this->getName()));
    }
    
    public function setUp() {        
        parent::setUp();        

        $this->getParser()->setSourceDoctype($this->doctypeList[$this->getKey()]);                       
        
        $methodName = $this->methodName;
        $this->assertEquals($this->expectedResult, $this->getParser()->$methodName());
    }

    public function testFpi_Only_Double_Quoted() {}
    public function testFpi_Only_Single_Quoted() {}
    public function testFpi_And_Uri_Both_Double_Quoted() {}
    public function testFpi_And_Uri_Both_Single_Quoted() {}
    public function testFpi_Single_Quoted_And_Uri_Double_Quoted() {}
    public function testFpi_Double_Quoted_And_Uri_Single_Quoted() {}
    public function testDtdless() {}
    public function testHtml_5_Legacy_Compat() {}

}