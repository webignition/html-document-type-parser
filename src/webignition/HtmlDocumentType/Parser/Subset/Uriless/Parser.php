<?php
namespace webignition\HtmlDocumentType\Parser\Subset\Uriless;

use webignition\HtmlDocumentType\Parser\Subset\Parser as BaseParser;

/**
 * Parse a well-formed public HTML document type that contains a FPI and a URI
 * 
 * Doctype string must be of the form:
 * <!DOCTYPE html PUBLIC {{quote}}FPI{{quote}}>
 */
class Parser extends BaseParser {      

    const PATTERN_TEMPLATE = '/^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s+[Pp][Uu][Bb][Ll][Ii][Cc]\s+{{quote}}[^{{quote}}]+{{quote}}\s*>$/';
    
    private $fpiQuoteCharacter = null;
    
    public function __construct($fpiQuoteCharacter) {
        $this->fpiQuoteCharacter = $fpiQuoteCharacter;
    }
    
    public function getFpiQuoteCharacter() {
        return $this->fpiQuoteCharacter;
    } 
    
    /**
     * 
     * @return string
     */
    public function getPattern() {
        return str_replace(array(
            '{{quote}}'
        ), array(
            $this->getFpiQuoteCharacter(),
        ), self::PATTERN_TEMPLATE);
    }      

    protected function parse() {        
        $firstDoubleQuotePosition = strpos($this->getSourceDoctype(), $this->getFpiQuoteCharacter());        
        $lastDoubleQuotePosition = strrpos($this->getSourceDoctype(), $this->getFpiQuoteCharacter());
        
        $this->setFpi(substr($this->getSourceDoctype(), $firstDoubleQuotePosition + 1, $lastDoubleQuotePosition - $firstDoubleQuotePosition - 1));
        $this->setUri(null);
    }     
  
}