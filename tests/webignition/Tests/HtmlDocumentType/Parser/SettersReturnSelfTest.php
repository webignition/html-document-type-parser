<?php

namespace webignition\Tests\HtmlDocumentType\Parser;

use webignition\HtmlDocumentType\Parser\Parser;

class SettersReturnSelfTest extends BaseTest {    
    
    public function setUp() {
        $setterMethodName = strtolower(str_replace('test', '', $this->getName()));
        
        $parser = new Parser();
        $this->assertEquals($parser, $parser->$setterMethodName('foo')); 
    }
    
    public function testSetSourceDoctype() {}    
}