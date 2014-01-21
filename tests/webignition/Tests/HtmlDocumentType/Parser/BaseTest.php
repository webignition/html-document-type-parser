<?php

namespace webignition\Tests\HtmlDocumentType\Parser;

use webignition\HtmlDocumentType\Parser\Parser;
use webignition\HtmlDocumentType\Generator;

abstract class BaseTest extends \PHPUnit_Framework_TestCase {  
    
    protected $doctypeList = array(
        'fpi-only-double-quoted' => '<!DOCTYPE html PUBLIC "fpi value">',
        'fpi-only-single-quoted' => '<!DOCTYPE html PUBLIC \'fpi value\'>',
        'fpi-only-double-quoted-and-empty' => '<!DOCTYPE html PUBLIC "">',
        'fpi-only-single-quoted-and-empty' => '<!DOCTYPE html PUBLIC \'\'>',        
        'fpi-and-uri-both-double-quoted' => '<!DOCTYPE html PUBLIC "fpi value" "uri value">',
        'fpi-and-uri-both-single-quoted' => '<!DOCTYPE html PUBLIC \'fpi value\' \'uri value\'>',
        'fpi-and-uri-both-double-quoted-with-empty-fpi' => '<!DOCTYPE html PUBLIC "" "uri value">',
        'fpi-and-uri-both-double-quoted-with-empty-uri' => '<!DOCTYPE html PUBLIC "fpi value" "">',
        'fpi-single-quoted-and-uri-double-quoted' => '<!DOCTYPE html PUBLIC \'fpi value\' "uri value">',
        'fpi-double-quoted-and-uri-single-quoted' => '<!DOCTYPE html PUBLIC "fpi value" \'uri value\'>',
        'dtdless' => '<!DOCTYPE html>',
        'html-5-legacy-compat' => '<!DOCTYPE html SYSTEM "about:legacy-compat">',        
    );

    /**
     *
     * @var \webignition\HtmlDocumentType\Generator
     */
    private $generator;
    
    /**
     *
     * @var \webignition\HtmlDocumentType\Parser\Parser
     */
    private $parser;    
 
    
    public function setUp() {        
        $this->generator = new Generator();
        $this->parser = new Parser();             
    }    
    
    /**
     * 
     * @return \webignition\HtmlDocumentType\Generator
     */
    protected function getGenerator() {
        return $this->generator;
    }
    
    /**
     * 
     * @return \webignition\HtmlDocumentType\Parser
     */
    protected function getParser() {
        return $this->parser;
    }
    
}