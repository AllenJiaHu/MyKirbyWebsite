<?php

namespace Kirby\Cms;

/**
 * The Core class lists all parts of Kirby
 * that need to be loaded or initalized in order
 * to make the system work. Most core parts can
 * be overwritten by plugins.
 *
 * You can get such lists as kirbytags, components,
 * areas, etc. by accessing them through `$kirby->core()`
 *
 * I.e. `$kirby->core()->areas()`
 *
 * @package   Kirby Cms
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      https://getkirby.com
 * @copyright Bastian Allgeier GmbH
 * @license   https://getkirby.com/license
 */
class Core
{
    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @var \Kirby\Cms\App
     */
    protected $kirby;

    /**
     * @var string
     */
    protected $root;

    /**
     * @param \Kirby\Cms\App $kirby
     */
    public function __construct(App $kirby)
    {
        $this->kirby = $kirby;
        $this->root  = dirname(__DIR__, 2) . '/config';
    }

    /**
     * Fetches the definition array of a particular area.
     *
     * This is a shortcut for `$kirby->core()->load()->area()`
     * to give faster access to original area code in plugins.
     *
     * @param string $name
     * @return array|null
     */
    public function area(string $name): ?array
    {
        return $this->load()->area($name);
    }

    /**
     * Returns a list of all paths to area definition files
     *
     * They are located in `/kirby/config/areas`
     *
     * @return array
     */
    public function areas(): array
    {
        return [
            'account'      => $this->root . '/areas/account.php',
            'installation' => $this->root . '/areas/installation.php',
            'languages'    => $this->root . '/areas/languages.php',
            'login'        => $this->root . '/areas/login.php',
            'site'         => $this->root . '/areas/site.php',
            'system'       => $this->root . '/areas/system.php',
            'users'        => $this->root . '/areas/users.php',
        ];
    }

    /**
     * Returns a list of all default auth challenge classes
     *
     * @return array
     */
    public function authChallenges(): array
    {
        return [
            'email' => 'Kirby\Cms\Auth\EmailChallenge'
        ];
    }

    /**
     * Returns a list of all paths to blueprint presets
     *
     * They are located in `/kirby/config/presets`
     *
     * @return array
     */
    public function blueprintPresets(): array
    {
        return [
            'pages' => $this->root . '/presets/pages.php',
            'page'  => $this->root . '/presets/page.php',
            'files' => $this->root . '/presets/files.php',
        ];
    }

    /**
     * Returns a list of all paths to core blueprints
     *
     * They are located in `/kirby/config/blueprints`.
     * Block blueprints are located in `/kirby/config/blocks`
     *
     * @return array
     */
    public function blueprints(): array
    {
        return [
            // blocks
            'blocks/code'     => $this->root . '/blocks/code/code.yml',
            'blocks/gallery'  => $this->root . '/blocks/gallery/gallery.yml',
            'blocks/heading'  => $this->root . '/blocks/heading/heading.yml',
            'blocks/image'    => $this->root . '/blocks/image/image.yml',
            'blocks/line'     => $this->root . '/blocks/line/line.yml',
            'blocks/list'     => $this->root . '/blocks/list/list.yml',
            'blocks/markdown' => $this->root . '/blocks/markdown/markdown.yml',
            'blocks/quote'    => $this->root . '/blocks/quote/quote.yml',
            'blocks/table'    => $this->root . '/blocks/table/table.yml',
            'blocks/text'     => $this->root . '/blocks/text/text.yml',
            'blocks/video'    => $this->root . '/blocks/video/video.yml',

            // file blueprints
            'files/default' => $this->root . '/blueprints/files/default.yml',

            // page blueprints
            'pages/default' => $this->root . '/blueprints/pages/default.yml',

            // site blueprints
            'site' => $this->root . '/blueprints/site.yml'
        ];
    }

    /**
     * Returns a list of all cache driver classes
     *
     * @return array
     */
    public function cacheTypes(): array
    {
        return [
            'apcu'      => 'Kirby\Cache\ApcuCache',
            'file'      => 'Kirby\Cache\FileCache',
            'memcached' => 'Kirby\Cache\MemCached',
            'memory'    => 'Kirby\Cache\MemoryCache',
        ];
    }

    /**
     * Returns an array of all core component functions
     *
     * The component functions can be found in
     * `/kirby/config/components.php`
     *
     * @return array
     */
    public function components(): array
    {
        return $this->cache['components'] ?? $this->cache['components'] = include $this->root . '/components.php';
    }

    /**
     * Returns a map of all field method aliases
     *
     * @return array
     */
    public function fieldMethodAliases(): array
    {
        return [
            'bool'    => 'toBool',
            'esc'     => 'escape',
            'excerpt' => 'toExcerpt',
            'float'   => 'toFloat',
            'h'       => 'html',
            'int'     => 'toInt',
            'kt'      => 'kirbytext',
            'kti'     => 'kirbytextinline',
            'link'    => 'toLink',
            'md'      => 'markdown',
            'sp'      => 'smartypants',
            'v'       => 'isValid',
            'x'       => 'xml'
        ];
    }

    /**
     * Returns an array of all field method functions
     *
     * Field methods are stored in `/kirby/config/methods.php`
     *
     * @return array
     */
    public function fieldMethods(): array
    {
        return $this->cache['fieldMethods'] ?? $this->cache['fieldMethods'] = (include $this->root . '/methods.php')($this->kirby);
    }

    /**
     * Returns an array of paths for field mixins
     *
     * They are located in `/kirby/config/fields/mixins`
     *
     * @return array
     */
    public function fieldMixins(): array
    {
        return [
            'datetime'   => $this->root . '/fields/mixins/datetime.php',
            'filepicker' => $this->root . '/fields/mixins/filepicker.php',
            'layout'     => $this->root . '/fields/mixins/layout.php',
            'min'        => $this->root . '/fields/mixins/min.php',
            'options'    => $this->root . '/fields/mixins/options.php',
            'pagepicker' => $this->root . '/fields/mixins/pagepicker.php',
            'picker'     => $this->root . '/fields/mixins/picker.php',
            'upload'     => $this->root . '/fields/mixins/upload.php',
            'userpicker' => $this->root . '/fields/mixins/userpicker.php',
        ];
    }

    /**
     * Returns an array of all paths and class names of panel fields
     *
     * Traditional panel fields are located in `/kirby/config/fields`
     *
     * The more complex field classes can be found in
     * `/kirby/src/Form/Fields`
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'blocks'      => 'Kirby\Form\Field\BlocksField',
            'checkboxes'  => $this->root . '/fields/checkboxes.php',
            'date'        => $this->root . '/fields/date.php',
            'email'       => $this->root . '/fields/email.php',
            'files'       => $this->root . '/fields/files.php',
            'gap'         => $this->root . '/fields/gap.php',
            'headline'    => $this->root . '/fields/headline.php',
            'hidden'      => $this->root . '/fields/hidden.php',
            'info'        => $this->root . '/fields/info.php',
            'layout'      => 'Kirby\Form\Field\LayoutField',
            'line'        => $this->root . '/fields/line.php',
            'list'        => $this->root . '/fields/list.php',
            'multiselect' => $this->root . '/fields/multiselect.php',
            'number'      => $this->root . '/fields/number.php',
            'pages'       => $this->root . '/fields/pages.php',
            'radio'       => $this->root . '/fields/radio.php',
            'range'       => $this->root . '/fields/range.php',
            'select'      => $this->root . '/fields/select.php',
            'slug'        => $this->root . '/fields/slug.php',
            'structure'   => $this->root . '/fields/structure.php',
            'tags'        => $this->root . '/fields/tags.php',
            'tel'         => $this->root . '/fields/tel.php',
            'text'        => $this->root . '/fields/text.php',
            'textarea'    => $this->root . '/fields/textarea.php',
            'time'        => $this->root . '/fields/time.php',
            'toggle'      => $this->root . '/fields/toggle.php',
            'url'         => $this->root . '/fields/url.php',
            'users'       => $this->root . '/fields/users.php',
            'writer'      => $this->root . '/fields/writer.php'
        ];
    }

    /**
     * Returns a map of all kirbytag aliases
     *
     * @return array
     */
    public function kirbyTagAliases(): array
    {
        return [
            'youtube' => 'video',
            'vimeo'   => 'video'
        ];
    }

    /**
     * Returns an array of all kirbytag definitions
     *
     * They are located in `/kirby/config/tags.php`
     *
     * @return array
     */
    public function kirbyTags(): array
    {
        return $this->cache['kirbytags'] ?? $this->cache['kirbytags'] = include $this->root . '/tags.php';
    }

    /**
     * Loads a core part of Kirby
     *
     * The loader is set to not include plugins.
     * This way, you can access original Kirby core code
     * through this load method.
     *
     * @return \Kirby\Cms\Loader
     */
    public function load()
    {
        return new Loader($this->kirby, false);
    }

    /**
     * Returns all absolute paths to important directories
     *
     * Roots are resolved and baked in `\Kirby\Cms\App::bakeRoots()`
     *
     * @return array
     */
    public function roots(): array
    {
        return $this->cache['roots'] ?? $this->cache['roots'] = [
            // kirby
            'kirby' => function (array $roots) {
                return dirname(__DIR__, 2);
            },

            // i18n
            'i18n' => function (array $roots) {
                return $roots['kirby'] . '/i18n';
            },
            'i18n:translations' => function (array $roots) {
                return $roots['i18n'] . '/translations';
            },
            'i18n:rules' => function (array $roots) {
                return $roots['i18n'] . '/rules';
            },

            // index
            'index' => function (array $roots) {
                return dirname(__DIR__, 3);
            },

            // assets
            'assets' => function (array $roots) {
                return $roots['index'] . '/assets';
            },

            // content
            'content' => function (array $roots) {
                return $roots['index'] . '/content';
            },

            // media
            'media' => function (array $roots) {
                return $roots['index'] . '/media';
            },

            // panel
            'panel' => function (array $roots) {
                return $roots['kirby'] . '/panel';
            },

            // site
            'site' => function (array $roots) {
                return $roots['index'] . '/site';
            },
            'accounts' => function (array $roots) {
                return $roots['site'] . '/accounts';
            },
            'blueprints' => function (array $roots) {
                return $roots['site'] . '/blueprints';
            },
            'cache' => function (array $roots) {
                return $roots['site'] . '/cache';
            },
            'collections' => function (array $roots) {
                return $roots['site'] . '/collections';
            },
            'config' => function (array $roots) {
                return $roots['site'] . '/config';
            },
            'controllers' => function (array $roots) {
                return $roots['site'] . '/controllers';
            },
            'languages' => function (array $roots) {
                return $roots['site'] . '/languages';
            },
            'license' => function (array $roots) {
                return $roots['config'] . '/.license';
            },
            'logs' => function (array $roots) {
                return $roots['site'] . '/logs';
            },
            'models' => function (array $roots) {
                return $roots['site'] . '/models';
            },
            'plugins' => function (array $roots) {
                return $roots['site'] . '/plugins';
            },
            'sessions' => function (array $roots) {
                return $roots['site'] . '/sessions';
            },
            'snippets' => function (array $roots) {
                return $roots['site'] . '/snippets';
            },
            'templates' => function (array $roots) {
                return $roots['site'] . '/templates';
            },

            // blueprints
            'roles' => function (array $roots) {
                return $roots['blueprints'] . '/users';
            },
        ];
    }

    /**
     * Returns an array of all routes for Kirby’s router
     *
     * Routes are split into `before` and `after` routes.
     *
     * Plugin routes will be injected inbetween.
     *
     * @return array
     */
    public function routes(): array
    {
        return $this->cache['routes'] ?? $this->cache['routes'] = (include $this->root . '/routes.php')($this->kirby);
    }

    /**
     * Returns a list of all paths to core block snippets
     *
     * They are located in `/kirby/config/blocks`
     *
     * @return array
     */
    public function snippets(): array
    {
        return [
            'blocks/code'     => $this->root . '/blocks/code/code.php',
            'blocks/gallery'  => $this->root . '/blocks/gallery/gallery.php',
            'blocks/heading'  => $this->root . '/blocks/heading/heading.php',
            'blocks/image'    => $this->root . '/blocks/image/image.php',
            'blocks/line'     => $this->root . '/blocks/line/line.php',
            'blocks/list'     => $this->root . '/blocks/list/list.php',
            'blocks/markdown' => $this->root . '/blocks/markdown/markdown.php',
            'blocks/quote'    => $this->root . '/blocks/quote/quote.php',
            'blocks/table'    => $this->root . '/blocks/table/table.php',
            'blocks/text'     => $this->root . '/blocks/text/text.php',
            'blocks/video'    => $this->root . '/blocks/video/video.php',
        ];
    }

    /**
     * Returns a list of paths to section mixins
     *
     * They are located in `/kirby/config/sections/mixins`
     *
     * @return array
     */
    public function sectionMixins(): array
    {
        return [
            'empty'      => $this->root . '/sections/mixins/empty.php',
            'headline'   => $this->root . '/sections/mixins/headline.php',
            'help'       => $this->root . '/sections/mixins/help.php',
            'layout'     => $this->root . '/sections/mixins/layout.php',
            'max'        => $this->root . '/sections/mixins/max.php',
            'min'        => $this->root . '/sections/mixins/min.php',
            'pagination' => $this->root . '/sections/mixins/pagination.php',
            'parent'     => $this->root . '/sections/mixins/parent.php',
        ];
    }

    /**
     * Returns a list of all section definitions
     *
     * They are located in `/kirby/config/sections`
     *
     * @return array
     */
    public function sections(): array
    {
        return [
            'fields' => $this->root . '/sections/fields.php',
            'files'  => $this->root . '/sections/files.php',
            'info'   => $this->root . '/sections/info.php',
            'pages'  => $this->root . '/sections/pages.php',
        ];
    }

    /**
     * Returns a list of paths to all system templates
     *
     * They are located in `/kirby/config/templates`
     *
     * @return array
     */
    public function templates(): array
    {
        return [
            'emails/auth/login'          => $this->root . '/templates/emails/auth/login.php',
            'emails/auth/password-reset' => $this->root . '/templates/emails/auth/password-reset.php'
        ];
    }

    /**
     * Returns an array with all system URLs
     *
     * URLs are resolved and baked in `\Kirby\Cms\App::bakeUrls()`
     *
     * @return array
     */
    public function urls(): array
    {
        return $this->cache['urls'] ?? $this->cache['urls'] = [
            'index' => function () {
                return Url::index();
            },
            'base' => function (array $urls) {
                return rtrim($urls['index'], '/');
            },
            'current' => function (array $urls) {
                $path = trim($this->kirby->path(), '/');

                if (empty($path) === true) {
                    return $urls['index'];
                } else {
                    return $urls['base'] . '/' . $path;
                }
            },
            'assets' => function (array $urls) {
                return $urls['base'] . '/assets';
            },
            'api' => function (array $urls) {
                return $urls['base'] . '/' . $this->kirby->option('api.slug', 'api');
            },
            'media' => function (array $urls) {
                return $urls['base'] . '/media';
            },
            'panel' => function (array $urls) {
                return $urls['base'] . '/' . $this->kirby->option('panel.slug', 'panel');
            }
        ];
    }
}
