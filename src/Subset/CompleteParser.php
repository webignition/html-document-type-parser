<?php
namespace webignition\HtmlDocumentType\Parser\Subset;

use webignition\HtmlDocumentType\Parser\Subset\Parser as BaseParser;

/**
 * Parse a well-formed public HTML document type that contains a FPI and a URI
 *
 * Doctype string must be of the form:
 * <!DOCTYPE html PUBLIC {{quote}}FPI{{quote}} {{quote}}URI{{quote}}>
 */
class CompleteParser extends BaseParser
{
    const PATTERN_TEMPLATE = '/^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s+[Pp][Uu][Bb][Ll][Ii][Cc]\s+'
    .'{{fpi-quote}}[^{{fpi-quote}}]*{{fpi-quote}}\s+{{uri-quote}}[^{{uri-quote}}]*{{uri-quote}}\s*>$/';

    /**
     * @var string
     */
    private $fpiQuoteCharacter = null;

    /**
     * @var string
     */
    private $uriQuoteCharacter = null;

    /**
     * @param string $fpiQuoteCharacter
     * @param string $uriQuoteCharacter
     */
    public function __construct($fpiQuoteCharacter, $uriQuoteCharacter)
    {
        $this->fpiQuoteCharacter = $fpiQuoteCharacter;
        $this->uriQuoteCharacter = $uriQuoteCharacter;
    }

    /**
     * {@inheritdoc}
     */
    public function getPattern()
    {
        return str_replace([
            '{{fpi-quote}}',
            '{{uri-quote}}'
        ], [
            $this->fpiQuoteCharacter,
            $this->uriQuoteCharacter
        ], self::PATTERN_TEMPLATE);
    }

    protected function parse()
    {
        $sourceDocType = $this->getSourceDoctype();
        $fpiQuoteCharacter = $this->fpiQuoteCharacter;

        $firstDoubleQuotePosition = strpos($sourceDocType, $fpiQuoteCharacter);
        $secondDoubleQuotePosition = strpos($sourceDocType, $fpiQuoteCharacter, $firstDoubleQuotePosition + 1);
        $thirdDoubleQuotePosition = strpos($sourceDocType, $this->uriQuoteCharacter, $secondDoubleQuotePosition + 1);
        $lastDoubleQuotePosition = strrpos($sourceDocType, $this->uriQuoteCharacter);

        $fpi = substr(
            $sourceDocType,
            $firstDoubleQuotePosition + 1,
            $secondDoubleQuotePosition - $firstDoubleQuotePosition - 1
        );
        $uri = substr(
            $sourceDocType,
            $thirdDoubleQuotePosition + 1,
            $lastDoubleQuotePosition - $thirdDoubleQuotePosition - 1
        );

        $this->setFpi($fpi);
        $this->setUri((trim($uri) == '') ? null : $uri);
    }
}
