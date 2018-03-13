<?php

namespace webignition\HtmlDocumentType\Parser\Subset;

use webignition\HtmlDocumentType\Parser\Subset\Parser as BaseParser;

/**
 * Parse a well-formed public HTML document type that contains a FPI and no URI
 *
 * Doctype string must be of the form:
 * <!DOCTYPE html PUBLIC {{quote}}FPI{{quote}}>
 */
class UrilessParser extends BaseParser
{
    const PATTERN_TEMPLATE = '/^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s+[Pp][Uu][Bb][Ll][Ii][Cc]\s+'
    .'{{quote}}[^{{quote}}]*{{quote}}\s*>$/';

    /**
     * @var string
     */
    private $fpiQuoteCharacter = null;

    /**
     * @param string $fpiQuoteCharacter
     */
    public function __construct($fpiQuoteCharacter)
    {
        $this->fpiQuoteCharacter = $fpiQuoteCharacter;
    }

    /**
     * {@inheritdoc}
     */
    public function getPattern()
    {
        return str_replace([
            '{{quote}}'
        ], [
            $this->fpiQuoteCharacter,
        ], self::PATTERN_TEMPLATE);
    }

    protected function parse()
    {
        $sourceDocType = $this->getSourceDoctype();

        $firstDoubleQuotePosition = strpos($sourceDocType, $this->fpiQuoteCharacter);
        $lastDoubleQuotePosition = strrpos($sourceDocType, $this->fpiQuoteCharacter);

        $this->setFpi(substr(
            $sourceDocType,
            $firstDoubleQuotePosition + 1,
            $lastDoubleQuotePosition - $firstDoubleQuotePosition - 1
        ));
        $this->setUri(null);
    }
}
