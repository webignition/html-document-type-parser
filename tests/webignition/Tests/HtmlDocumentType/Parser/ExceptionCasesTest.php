<?php

namespace webignition\Tests\HtmlDocumentType\Parser;

class ExceptionCasesTest extends BaseTest {    
    
    public function testNoSourceDoctypeThrowsRuntimeException() {        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: ""', 1);
        $this->getParser()->getFpi();
    }
    
    public function testNonsenseSourceDoctypeThrowsRuntimeException() {
        $doctype = 'foo';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();
    }
    
    public function testUnquotedUrilessDoctypeThrowsRuntimeException() {        
        $doctype = '<!DOCTYPE html PUBLIC fpi value>';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }     
    
    public function testImbalancedQuotesInUrilessDoctypeThrowsRuntimeException1() {        
        $doctype = '<!DOCTYPE html PUBLIC \'fpi value">';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }    
    
    public function testImbalancedQuotesInUrilessDoctypeThrowsRuntimeException2() {        
        $doctype = '<!DOCTYPE html PUBLIC "fpi value\'>';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }   
    
    public function testUnquotedCompleteDoctypeThrowsRuntimeException() {        
        $doctype = '<!DOCTYPE html PUBLIC fpi value uri value>';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }     
    
    public function testImbalancedQuotesInCompleteDoctypeThrowsRuntimeException1() {        
        $doctype = '<!DOCTYPE html PUBLIC \'fpi value" "uri value">';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }     
    
    public function testImbalancedQuotesInCompleteDoctypeThrowsRuntimeException2() {        
        $doctype = '<!DOCTYPE html PUBLIC "fpi value\' "uri value">';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }
    
    public function testImbalancedQuotesInCompleteDoctypeThrowsRuntimeException3() {        
        $doctype = '<!DOCTYPE html PUBLIC "fpi value" \'uri value">';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }
    
    public function testImbalancedQuotesInCompleteDoctypeThrowsRuntimeException4() {        
        $doctype = '<!DOCTYPE html PUBLIC "fpi value" "uri value\'>';        
        $this->setExpectedException('RuntimeException', 'No matching parser found for: "' . $doctype . '"', 1);
        $this->getParser()->setSourceDoctype($doctype);
        $this->getParser()->getFpi();        
    }    

}