<?php namespace SbShare\Presenters;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use SbShare\Decoda\Decoda;
use SbShare\Decoda\Filters\QuoteFilter;
use SbShare\Decoda\Hooks\EmojiHook;
use SbShare\Decoda\Hooks\MentionHook;

class BasePresenter {
    protected $model;

    protected $attributes = array();

    public static function instances($models) {
        $instances = array();
        foreach($models as $model) {
            $instances[] = new static($model);
        }

        if ($models instanceof Paginator) {
            return $models->getEnvironment()->make(
                $instances,
                $models->getTotal(),
                $models->getPerPage()
            );
        } elseif ($models instanceof Collection) {
            return new Collection($instances);
        } else {
            return $instances;
        }
    }

    public function __construct($model) {
        $this->model = $model;
    }

    public function __get($field) {
        if (!isset($this->attributes[$field])) {
            $value = false;
            $method = 'get' . \Str::studly($field) . 'Attribute';
            if (method_exists($this, $method)) {
                $value = $this->$method();
            } else {
                $value = $this->model->$field;
            }
            $this->attributes[$field] = $value;
        }

        return $this->attributes[$field];
    }

    public static function parseCommonMarkup($str, &$mentions = null, &$authors = null) {
        $decoda = self::setUpDecoda($str);
        $str = $decoda->parse();
        $mentions = $decoda->getHook('Mention')->getMentions();
        $authors = $decoda->getFilter('Quote')->getAuthors();
        return $str;
    }

    protected static function setUpDecoda($text) {
        $decoda = new Decoda($text, array(
            'locale'    => 'ru-ru',
        ));
        $decoda->defaults();
        $decoda->addHook(new EmojiHook(array(
            'public_path'       => public_path(),
            'simple_emojies'    => \Config::get('emojies.mappings'),
        )));
        $decoda->addHook(new MentionHook());
        $decoda->removeFilter('Quote');
        $decoda->addFilter(new QuoteFilter());
        return $decoda;
    }

    public static function parseMentions($str, &$out = null) {
        $pattern = '~\B(@([\w]+))~is';
        $matches = array();
        $out = array();
        if (preg_match_all($pattern, $str, $matches)) {
            foreach(array_unique($matches[2]) as $mention) {
                $out[] = $mention;
            }
        }
        $str = preg_replace($pattern, '<strong>$1</strong>', $str);
        return $str;
    }
    public static function parseEmojies($str) {
        $str = self::parseSimpleEmojies($str);
        $pattern = '~:([\w\-+]+):~is';
        $str = preg_replace($pattern, '<img src="/img/emoji/$1.png" class="emoji" />', $str);
        return $str;
    }

    protected static function parseSimpleEmojies($str) {
        $mappings = \Config::get('emojies.mappings');
        foreach($mappings as $mapping => $emojies) {
            $str = str_replace($emojies, ':' . $mapping . ':', $str);
        }

        return $str;
    }

    protected function getCreatedAtAttribute() {
        return $this->model->created_at->format('d.m.Y H:i:s');
    }
} 
