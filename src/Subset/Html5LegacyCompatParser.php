<?php

namespace webignition\HtmlDocumentType\Parser\Subset;

use webignition\HtmlDocumentType\Parser\Subset\Parser as BaseParser;

/**
 * Parse a well-formed public HTML document type that is present for HTML5 compatibility
 *
 * Doctype string must be of the form:
 * <!DOCTYPE html "about:legacy-compat">
 */
class Html5LegacyCompatParser extends BaseParser
{
    const PATTERN = '/^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s*[Ss][Yy][Ss][Tt][Ee][Mm]\s'
    .'"about:legacy-compat">$/';

    /**
     * {@inheritdoc}
     */
    public function getPattern()
    {
        return self::PATTERN;
    }

    protected function parse()
    {
        $this->setUri('about:legacy-compat');
    }
}
