<?php

namespace webignition\Tests\HtmlDocumentType\Parser;

class GetUriTest extends GetPropertyTest {
    
    private $uriList = array(
        'fpi-only-double-quoted' => null,
        'fpi-only-single-quoted' => null,
        'fpi-and-uri-both-double-quoted' => 'uri value',
        'fpi-and-uri-both-single-quoted' => 'uri value',
        'fpi-single-quoted-and-uri-double-quoted' => 'uri value',
        'fpi-double-quoted-and-uri-single-quoted' => 'uri value',
        'dtdless' => null,
        'html-5-legacy-compat' => 'about:legacy-compat'  
    );
    
    public function setUp() {                
        $this->methodName = 'getUri';
        $this->expectedResult = $this->uriList[$this->getKey()];
        parent::setUp();
    }

}