<?php

namespace Webfactory\Bundle\LegacyIntegrationBundle\Integration;

use Symfony\Component\HttpFoundation\Response;
use Webfactory\Dom\PolyglotHTML5Parser;

class FragmentalResponse extends Response {

    protected $document;
    protected $parser;

    public function __construct($parser, $content = '', $status = 200, $headers = array()) {
        $this->parser = $parser;
        parent::__construct($content, $status, $headers);
    }

    public function getFragment($expression) {
        if ($document = $this->getDocument()) {
           return $this->parser->queryXPath($document, $expression);
        }
    }

    protected function getDocument() {
        if (!$this->document) {
            $this->document = $this->parser->parseDocument($this->getContent());
        }
        return $this->document;
    }

}