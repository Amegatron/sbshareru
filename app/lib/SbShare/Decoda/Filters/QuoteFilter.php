<?php namespace SbShare\Decoda\Filters;

class QuoteFilter extends \Decoda\Filter\QuoteFilter {

    protected $_authors = array();

    public function __construct() {
        $this->_tags['quote']['attributes']['default'] = self::ALNUM;
    }

    public function getAuthors() {
        return array_unique($this->_authors);
    }

    public function parse(array $tag, $content) {
        if (isset($tag['attributes']['author']) && $tag['depth'] == 0) {
            $this->_authors[] = strtolower($tag['attributes']['author']);
        }
        return parent::parse($tag, $content);
    }

} 
