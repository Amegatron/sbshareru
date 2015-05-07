<?php namespace SbShare\Decoda\Hooks;

use Decoda\Hook\AbstractHook;

class MentionHook extends AbstractHook{

    protected $_mentions = array();

    public function beforeParse($content) {
        $pattern = '~\B(@([\w]+))~is';

        $content = preg_replace_callback($pattern, array($this, '_mentionCallback'), $content);
        return $content;
    }

    public function getMentions() {
        return array_unique($this->_mentions);
    }

    protected function _mentionCallback($matches) {
        $this->_mentions[] = strtolower($matches[2]);
        return '<b>' . $matches[1] . '</b>';
    }
} 
