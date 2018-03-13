<?php

namespace webignition\HtmlDocumentType\Parser\Subset;

use webignition\HtmlDocumentType\Parser\Subset\Parser as BaseParser;

/**
 * Parse a well-formed public HTML document type that does not use a DTD
 *
 * Doctype string must be of the form:
 * <!DOCTYPE html>
 */
class DtdlessParser extends BaseParser
{
    const PATTERN = '/^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s*>$/';

    /**
     * {@inheritdoc}
     */
    public function getPattern()
    {
        return self::PATTERN;
    }

    protected function parse()
    {
    }
}
