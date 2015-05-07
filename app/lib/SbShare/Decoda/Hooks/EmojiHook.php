<?php namespace SbShare\Decoda\Hooks;

use Decoda\Hook\AbstractHook;

class EmojiHook extends AbstractHook{

    protected $_config = array(
        'class'         => 'emoji',
        'path'          => '/img/emoji',
        'extension'     => 'png',
    );

    public function beforeParse($content) {
        $content = $this->parseSimpleEmojies($content);

        $pattern = '~:([\w\-+]+):~is';
        $content = preg_replace_callback($pattern, array($this, '_emojiCallback'), $content);
        return $content;
    }

    protected function parseSimpleEmojies($str) {
        $mappings = $this->_config['simple_emojies'];
        foreach($mappings as $mapping => $emojies) {
            $str = str_replace($emojies, ':' . $mapping . ':', $str);
        }

        return $str;
    }

    protected function _emojiCallback($matches) {
        $url = $this->_config['path'] . '/' . $matches[1] . '.' . $this->_config['extension'];
        $fileName = $this->_config['public_path'] . $url;

        if (file_exists($fileName)) {
            return '<img src="' . $url . '" class="' . $this->_config['class'] . '">';
        } else {
            return ':' . $matches[1] . ':';
        }
    }
}
