<?php
namespace webignition\HtmlDocumentType\Parser\Subset\Dtdless;

use webignition\HtmlDocumentType\Parser\Subset\Parser as BaseParser;

/**
 * Parse a well-formed public HTML document type that does not use a DTD
 * 
 * Doctype string must be of the form:
 * <!DOCTYPE html>
 */
class Parser extends BaseParser {
    
    const PATTERN = '/^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s*>$/';    
    
    /**
     * 
     * @return string
     */
    public function getPattern() {
        return self::PATTERN;
    }    
    
    protected function parse() {}    
}