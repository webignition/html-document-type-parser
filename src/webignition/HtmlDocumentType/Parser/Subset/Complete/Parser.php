<?php
namespace webignition\HtmlDocumentType\Parser\Subset\Complete;

use webignition\HtmlDocumentType\Parser\Subset\Parser as BaseParser;

/**
 * Parse a well-formed public HTML document type that contains a FPI and a URI
 * 
 * Doctype string must be of the form:
 * <!DOCTYPE html PUBLIC {{quote}}FPI{{quote}} {{quote}}URI{{quote}}>
 */
class Parser extends BaseParser {      
    
    const PATTERN_TEMPLATE = '/^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s+[Pp][Uu][Bb][Ll][Ii][Cc]\s+{{fpi-quote}}[^{{fpi-quote}}]+{{fpi-quote}}\s+{{uri-quote}}[^{{uri-quote}}]+{{uri-quote}}\s*>$/';
    
    private $fpiQuoteCharacter = null;
    private $uriQuoteCharacter = null;
    
    public function __construct($fpiQuoteCharacter, $uriQuoteCharacter) {
        $this->fpiQuoteCharacter = $fpiQuoteCharacter;
        $this->uriQuoteCharacter = $uriQuoteCharacter;
    }
    
    public function getFpiQuoteCharacter() {
        return $this->fpiQuoteCharacter;
    }
    
    public function getUriQuoteCharacter() {
        return $this->uriQuoteCharacter;
    }   
    
    /**
     * 
     * @return string
     */
    public function getPattern() {
        return str_replace(array(
            '{{fpi-quote}}',
            '{{uri-quote}}'
        ), array(
            $this->getFpiQuoteCharacter(),
            $this->getUriQuoteCharacter()
        ), self::PATTERN_TEMPLATE);
    }      

    protected function parse() {        
        $firstDoubleQuotePosition = strpos($this->getSourceDoctype(), $this->getFpiQuoteCharacter());
        $secondDoubleQuotePosition = strpos($this->getSourceDoctype(), $this->getFpiQuoteCharacter(), $firstDoubleQuotePosition + 1);
        $thirdDoubleQuotePosition = strpos($this->getSourceDoctype(), $this->getUriQuoteCharacter(), $secondDoubleQuotePosition + 1);
        $lastDoubleQuotePosition = strrpos($this->getSourceDoctype(), $this->getUriQuoteCharacter()); 
        
        $this->setFpi(substr($this->getSourceDoctype(), $firstDoubleQuotePosition + 1, $secondDoubleQuotePosition - $firstDoubleQuotePosition - 1));
        $this->setUri(substr($this->getSourceDoctype(), $thirdDoubleQuotePosition + 1, $lastDoubleQuotePosition - $thirdDoubleQuotePosition - 1));
    }       
  
}