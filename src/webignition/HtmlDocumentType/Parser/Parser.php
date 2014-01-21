<?php
namespace webignition\HtmlDocumentType\Parser;

/**
 * Parse a well-formed public HTML document type and allow the FPI and URI to be
 * extracted
 * 
 * Doctype string must be of the form:
 * <!DOCTYPE html PUBLIC "FPI" ["URI"]>
 */
class Parser {
    
    /**
     *
     * @var string
     */
    private $sourceDoctype = null;
    
    /**
     *
     * @var string
     */
    private $fpi = null;
    
    /**
     *
     * @var string
     */
    private $uri = null;
    
    
    /**
     *
     * @var \webignition\HtmlDocumentType\Parser\Subset[]
     */
    private $parsers = array();
    
    
    public function __construct() {
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Dtdless\Parser();
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Complete\Parser('"', '"');
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Complete\Parser("'", "'");
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Uriless\Parser("'");        
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Uriless\Parser('"');        
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Complete\Parser("'", '"');
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Complete\Parser('"', "'");
        $this->parsers[] = new \webignition\HtmlDocumentType\Parser\Subset\Html5LegacyCompat\Parser();
    }
    
    
    /**
     * 
     * @param string $sourceDoctype
     * @return \webignition\HtmlDocumentType\Parser
     */
    public function setSourceDoctype($sourceDoctype) {        
        $this->sourceDoctype = trim($sourceDoctype);
        
        foreach ($this->parsers as $parser) {
            $parser->setSourceDoctype($this->sourceDoctype);
        }
        
        return $this;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getFpi() {
        if (is_null($this->fpi)) {
            $this->parse();
        }
        
        return $this->fpi;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getUri() {
        if (is_null($this->uri)) {
            $this->parse();
        }
        
        return $this->uri;
    }    
    
    
    private function parse() { 
        $subtypeParser = $this->getMatchingParser();
        
        $this->fpi = $subtypeParser->getFpi();
        $this->uri = $subtypeParser->getUri();
    }
    
    
    private function getMatchingParser() {
        foreach ($this->parsers as $parser) {
            if ($parser->matches()) {
                return $parser;
            }
        }        
        
        throw new \RuntimeException('No matching parser found for: "' . $this->sourceDoctype . '"', 1);       
    }    
}