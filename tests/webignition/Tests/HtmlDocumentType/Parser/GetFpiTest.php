<?php

namespace webignition\Tests\HtmlDocumentType\Parser;

class GetFpiTest extends GetPropertyTest {
    
    private $fpiList = array(
        'fpi-only-double-quoted' => 'fpi value',
        'fpi-only-single-quoted' => 'fpi value',
        'fpi-only-double-quoted-and-empty' => '',
        'fpi-only-single-quoted-and-empty' => '',        
        'fpi-and-uri-both-double-quoted' => 'fpi value',
        'fpi-and-uri-both-single-quoted' => 'fpi value',
        'fpi-and-uri-both-double-quoted-with-empty-fpi' => '',
        'fpi-and-uri-both-double-quoted-with-empty-uri' => 'fpi value',
        'fpi-single-quoted-and-uri-double-quoted' => 'fpi value',
        'fpi-double-quoted-and-uri-single-quoted' => 'fpi value',
        'dtdless' => null,
        'html-5-legacy-compat' => null     
    );
    
    public function setUp() {                
        $this->methodName = 'getFpi';
        $this->expectedResult = $this->fpiList[$this->getKey()];
        parent::setUp();
    }

}