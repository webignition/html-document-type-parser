<?php

namespace webignition\Tests\HtmlDocumentType\Parser;

use webignition\HtmlDocumentType\Parser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseNoMatchingParser()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No matching parser found for: "<!DOCTYPE html PUBLIC>"');
        $this->expectExceptionCode(1);

        $parser = new Parser();
        $parser->setSourceDoctype('<!DOCTYPE html PUBLIC>');

        $parser->getFpi();
    }

    /**
     * @dataProvider parseDataProvider
     *
     * @param string $sourceDocType
     * @param string $expectedFpi
     * @param string $expectedUri
     */
    public function testParse($sourceDocType, $expectedFpi, $expectedUri)
    {
        $parser = new Parser();
        $parser->setSourceDoctype($sourceDocType);

        $this->assertEquals($expectedFpi, $parser->getFpi());
        $this->assertEquals($expectedUri, $parser->getUri());
    }

    /**
     * @return array
     */
    public function parseDataProvider()
    {
        $dataProvider = [
            'html-2' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//IETF//DTD HTML//EN">',
                'expectedFpi' => '-//IETF//DTD HTML//EN',
                'expectedUri' => '',
            ],
            'html-32' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">',
                'expectedFpi' => '-//W3C//DTD HTML 3.2 Final//EN',
                'expectedUri' => '',
            ],
            'html-4-strict' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC '
                    .'"-//W3C//DTD HTML 4.0//EN" '
                    .'"http://www.w3.org/TR/1998/REC-html40-19980424/strict.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.0//EN',
                'expectedUri' => 'http://www.w3.org/TR/1998/REC-html40-19980424/strict.dtd',
            ],
            'html-4-transitional' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC '
                    .'"-//W3C//DTD HTML 4.0 Transitional//EN" '
                    .'"http://www.w3.org/TR/1998/REC-html40-19980424/loose.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.0 Transitional//EN',
                'expectedUri' => 'http://www.w3.org/TR/1998/REC-html40-19980424/loose.dtd',
            ],
            'html-4-frameset' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN" '
                    .'"http://www.w3.org/TR/1998/REC-html40-19980424/frameset.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.0 Frameset//EN',
                'expectedUri' => 'http://www.w3.org/TR/1998/REC-html40-19980424/frameset.dtd',
            ],
            'html-401-strict' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" '
                    .'"http://www.w3.org/TR/html4/strict.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.01//EN',
                'expectedUri' => 'http://www.w3.org/TR/html4/strict.dtd',
            ],
            'html-401-transitional' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" '
                    .'"http://www.w3.org/TR/html4/loose.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.01 Transitional//EN',
                'expectedUri' => 'http://www.w3.org/TR/html4/loose.dtd',
            ],
            'html-401-frameset' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" '
                    .'"http://www.w3.org/TR/html4/frameset.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.01 Frameset//EN',
                'expectedUri' => 'http://www.w3.org/TR/html4/frameset.dtd',
            ],
            'html-5' => [
                'sourceDocType' => '<!DOCTYPE html>',
                'expectedFpi' => '',
                'expectedUri' => '',
            ],
            'html-5-legacy-compat' => [
                'sourceDocType' => '<!DOCTYPE html SYSTEM "about:legacy-compat">',
                'expectedFpi' => '',
                'expectedUri' => 'about:legacy-compat',
            ],
            'xhtml-1-strict' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" '
                    .'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML 1.0 Strict//EN',
                'expectedUri' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd',
            ],
            'xhtml-1-transitional' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" '
                    .'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML 1.0 Transitional//EN',
                'expectedUri' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd',
            ],
            'xhtml-1-frameset' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" '
                    .'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML 1.0 Frameset//EN',
                'expectedUri' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd',
            ],
            'xhtml-11' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" '
                    .'"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML 1.1//EN',
                'expectedUri' => 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd',
            ],
            'xhtml+basic-1' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN" '
                    .'"http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML Basic 1.0//EN',
                'expectedUri' => 'http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd',
            ],
            'xhtml+basic-11' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" '
                    .'"http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML Basic 1.1//EN',
                'expectedUri' => 'http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd',
            ],
            'xhtml+print-1' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML-Print 1.0//EN" '
                    .'"http://www.w3.org/TR/xhtml-print/DTD/xhtml-print10.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML-Print 1.0//EN',
                'expectedUri' => 'http://www.w3.org/TR/xhtml-print/DTD/xhtml-print10.dtd',
            ],
            'xhtml+mobile-1' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" '
                    .'"http://www.wapforum.org/DTD/xhtml-mobile10.dtd">',
                'expectedFpi' => '-//WAPFORUM//DTD XHTML Mobile 1.0//EN',
                'expectedUri' => 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd',
            ],
            'xhtml+mobile-11' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.1//EN" '
                    .'"http://www.openmobilealliance.org/tech/DTD/xhtml-mobile11.dtd">',
                'expectedFpi' => '-//WAPFORUM//DTD XHTML Mobile 1.1//EN',
                'expectedUri' => 'http://www.openmobilealliance.org/tech/DTD/xhtml-mobile11.dtd',
            ],
            'xhtml+mobile-12' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" '
                    .'"http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">',
                'expectedFpi' => '-//WAPFORUM//DTD XHTML Mobile 1.2//EN',
                'expectedUri' => 'http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd',
            ],
            'xhtml+rdfa-1' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" '
                    .'"http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML+RDFa 1.0//EN',
                'expectedUri' => 'http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd',
            ],
            'xhtml+rdfa-11' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.1//EN" '
                    .'"http://www.w3.org/MarkUp/DTD/xhtml-rdfa-2.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML+RDFa 1.1//EN',
                'expectedUri' => 'http://www.w3.org/MarkUp/DTD/xhtml-rdfa-2.dtd',
            ],
            'xhtml+aria-1' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+ARIA 1.0//EN" '
                    .'"http://www.w3.org/WAI/ARIA/schemata/xhtml-aria-1.dtd">',
                'expectedFpi' => '-//W3C//DTD XHTML+ARIA 1.0//EN',
                'expectedUri' => 'http://www.w3.org/WAI/ARIA/schemata/xhtml-aria-1.dtd',
            ],
            'html+aria-401' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML+ARIA 1.0//EN" '
                    .'"http://www.w3.org/WAI/ARIA/schemata/html4-aria-1.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML+ARIA 1.0//EN',
                'expectedUri' => 'http://www.w3.org/WAI/ARIA/schemata/html4-aria-1.dtd',
            ],
            'html+rdfa-401-1' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01+RDFa 1.0//EN" '
                    .'"http://www.w3.org/MarkUp/DTD/html401-rdfa-1.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.01+RDFa 1.0//EN',
                'expectedUri' => 'http://www.w3.org/MarkUp/DTD/html401-rdfa-1.dtd',
            ],
            'html+rdfa-401-11' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01+RDFa 1.1//EN" '
                    .'"http://www.w3.org/MarkUp/DTD/html401-rdfa11-1.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.01+RDFa 1.1//EN',
                'expectedUri' => 'http://www.w3.org/MarkUp/DTD/html401-rdfa11-1.dtd',
            ],
            'html+rdfalite-401-11' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01+RDFa Lite 1.1//EN" '
                    .'"http://www.w3.org/MarkUp/DTD/html401-rdfalite11-1.dtd">',
                'expectedFpi' => '-//W3C//DTD HTML 4.01+RDFa Lite 1.1//EN',
                'expectedUri' => 'http://www.w3.org/MarkUp/DTD/html401-rdfalite11-1.dtd',
            ],
            'html+iso15445-1' => [
                'sourceDocType' => '<!DOCTYPE html PUBLIC "ISO/IEC 15445:2000//DTD HTML//EN">',
                'expectedFpi' => 'ISO/IEC 15445:2000//DTD HTML//EN',
                'expectedUri' => '',
            ],
        ];

        return $dataProvider;
    }
}
