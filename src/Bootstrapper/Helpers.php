<?php

namespace Bootstrapper;

use Illuminate\Config\Repository;

/**
 * Helper class
 *
 * @package Bootstrapper
 */
class Helpers
{
    private static $counts = [

    ];

    /**
     * The config repository
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;


    /**
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Slugifies a string
     *
     * @param string $string
     * @return mixed
     */
    public static function slug($string)
    {
        return preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
    }

    /**
     * Outputs a link to the Bootstrap CDN
     *
     * @param bool $withTheme Gets the bootstrap theme as well
     * @return string
     */
    public function css($withTheme = true)
    {
        $version = $this->config->get('bootstrapper::bootstrapVersion');
        $string = "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/{$version}/css/bootstrap.min.css'>";
        if ($withTheme) {
            $string .= "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/{$version}/css/bootstrap-theme.min.css'>";
        }

        return $string;
    }

    /**
     * Outputs a link to the Jquery and Bootstrap CDN
     *
     * @return string
     */
    public function js()
    {
        $jquery = $this->config->get('bootstrapper::jqueryVersion');
        $bootstrap = $this->config->get('bootstrapper::bootstrapVersion');

        return "<script src='http://code.jquery.com/jquery-{$jquery}.min.js'></script><script src='//netdna.bootstrapcdn.com/bootstrap/{$bootstrap}/js/bootstrap.min.js'></script>";
    }

    public static function generateId(RenderedObject $caller)
    {
        $class = get_class($caller);

        if (isset(self::$counts[$class]))
        {
            $count = self::$counts[$class];
            self::$counts[$class] += 1;
        }
        else
        {
            $count = 1;
            self::$counts[$class] = 2;
        }

        return self::slug(' ' . $class . ' ' . $count);
    }
}
