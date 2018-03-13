<?php
namespace webignition\HtmlDocumentType\Parser\Subset;

/**
 * Parse a well-formed public HTML document type that conforms to a subset
 */
abstract class Parser
{
    const PATTERN = '^<![Dd][Oo][Cc][Tt][Yy][Pp][Ee]\s+[Hh][Tt][Mm][Ll]\s?>$';

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
     * @return string
     */
    abstract protected function getPattern();

    abstract protected function parse();

    /**
     * @return bool
     */
    public function matches()
    {
        return preg_match($this->getPattern(), $this->sourceDoctype) > 0;
    }

    /**
     * @param string $sourceDoctype
     *
     * @return self
     */
    public function setSourceDoctype($sourceDoctype)
    {
        $this->sourceDoctype = trim($sourceDoctype);
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceDoctype()
    {
        return $this->sourceDoctype;
    }

    /**
     * @param string $fpi
     */
    protected function setFpi($fpi)
    {
        $this->fpi = $fpi;
    }

    /**
     * @param string $uri
     */
    protected function setUri($uri)
    {
        $this->uri = $uri;
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
}
