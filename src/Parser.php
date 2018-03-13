<?php

namespace webignition\HtmlDocumentType\Parser;

use webignition\HtmlDocumentType\Parser\Subset\CompleteParser;
use webignition\HtmlDocumentType\Parser\Subset\DtdlessParser;
use webignition\HtmlDocumentType\Parser\Subset\Html5LegacyCompatParser;
use webignition\HtmlDocumentType\Parser\Subset\Parser as SubsetParser;
use webignition\HtmlDocumentType\Parser\Subset\UrilessParser;

/**
 * Parse a well-formed public HTML document type and allow the FPI and URI to be
 * extracted
 *
 * Doctype string must be of the form:
 * <!DOCTYPE html PUBLIC "FPI" ["URI"]>
 */
class Parser
{
    /**
     * @var string
     */
    private $sourceDoctype = null;

    /**
     * @var string
     */
    private $fpi = null;

    /**
     * @var string
     */
    private $uri = null;

    /**
     * @var SubsetParser[]
     */
    private $parsers = array();

    public function __construct()
    {
        $this->parsers[] = new DtdlessParser();
        $this->parsers[] = new CompleteParser('"', '"');
        $this->parsers[] = new CompleteParser("'", "'");
        $this->parsers[] = new UrilessParser("'");
        $this->parsers[] = new UrilessParser('"');
        $this->parsers[] = new CompleteParser("'", '"');
        $this->parsers[] = new CompleteParser('"', "'");
        $this->parsers[] = new Html5LegacyCompatParser();
    }

    /**
     * @param string $sourceDoctype
     *
     * @return self
     */
    public function setSourceDoctype($sourceDoctype)
    {
        $this->sourceDoctype = trim($sourceDoctype);

        foreach ($this->parsers as $parser) {
            $parser->setSourceDoctype($this->sourceDoctype);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFpi()
    {
        if (is_null($this->fpi)) {
            $this->parse();
        }

        return $this->fpi;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        if (is_null($this->uri)) {
            $this->parse();
        }

        return $this->uri;
    }

    private function parse()
    {
        $subtypeParser = $this->getMatchingParser();

        $this->fpi = $subtypeParser->getFpi();
        $this->uri = $subtypeParser->getUri();
    }

    /**
     * @return SubsetParser
     */
    private function getMatchingParser()
    {
        foreach ($this->parsers as $parser) {
            if ($parser->matches()) {
                return $parser;
            }
        }

        throw new \RuntimeException('No matching parser found for: "' . $this->sourceDoctype . '"', 1);
    }
}
