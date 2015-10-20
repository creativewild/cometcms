<?php
namespace App\Libraries\Theme;

use App\Libraries\Theme\Exceptions\ThemeNotFoundException;
use Illuminate\Contracts\Container\Container;
use File;
use App\Libraries\Theme\Exceptions\ThemeInfoAttributeException;

/**
 * Theme
 *
 * @author Karlo Miku�
 * @version 0.0.1
 * @package App\Libraries\Theme
 */
class Theme {

    /**
     * Scanned themes
     * @var array|ThemeInfo[]
     */
    private $themes;

    /**
     * View finder
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * Base theme folder
     * @var string
     */
    private $basePath;

    /**
     * Current active theme
     * @var string|null
     */
    private $activeTheme = null;

    /**
     * Setup default view finder and view paths.
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        // Default themes path
        $this->basePath = config('theme.path');

        // Config view finder
        $paths = $app['config']['view.paths'];
        $this->view = $app->make('view');
        $this->view->setFinder(new ThemeViewFinder($app['files'], $paths));

        // Scan themes
        $this->scanThemes();
    }

    /**
     * Set current active theme
     *
     * @param string $theme Theme namespace
     * @throws ThemeNotFoundException
     */
    public function setTheme($theme)
    {
        if (!$this->themeExists($theme)) {
            throw new ThemeNotFoundException($theme);
        }

        $this->loadTheme($theme);
    }

    /**
     * Get all found themes
     *
     * @return array|ThemeInfo[]
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Return currently active theme
     *
     * @return null|ThemeInfo
     */
    public function get()
    {
        return $this->themes[$this->activeTheme];
    }

    /**
     * Check if theme exists
     *
     * @param $theme
     * @return bool
     */
    public function themeExists($theme)
    {
        return array_key_exists($theme, $this->themes);
    }

    /**
     * Set base themes folder path
     *
     * @param $path
     */
    public function setDefaultThemePath($path)
    {
        $this->basePath = $path;
        $this->scanThemes();
    }

    /**
     * Load a theme
     *
     * @param string $theme
     * @throws \Exception
     */
    private function loadTheme($theme)
    {
        if (!isset($theme))
            return;

        $th = $this->findThemeByNamespace($theme);

        if (isset($th)) {
            $viewFinder = $this->view->getFinder();

            $viewFinder->prependPath($th->getPath());
            if (!is_null($th->getParent()))
                $this->loadTheme($th->getParent());

            $this->activeTheme = $theme;
        }
    }

    /**
     * Find a theme from all scanned themes
     *
     * @param string $namespace
     * @return null|ThemeInfo
     */
    private function findThemeByNamespace($namespace)
    {
        if (isset($this->themes[$namespace]))
            return $this->themes[$namespace];

        return null;
    }

    /**
     * Scan for all available themes
     *
     * @throws ThemeInfoAttributeException
     */
    private function scanThemes()
    {
        $themeDirectories = glob($this->basePath . '/*', GLOB_ONLYDIR);

        $themes = [];
        foreach ($themeDirectories as $themePath) {
            $json = $themePath . '/theme.json';

            if (File::exists($json)) {
                $th = $this->parseThemeInfo(json_decode(File::get($json), true));
                $themes[$th->getNamespace()] = $th;
            }
        }

        $this->themes = $themes;
    }

    /**
     * Find theme views path
     *
     * @param $namespace
     * @return string
     */
    private function findPath($namespace)
    {
        $path = [];
        $path[] = $this->basePath;
        $path[] = $namespace;
        $path[] = 'views';

        return implode(DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Parse theme json file
     *
     * @param array $info
     * @return ThemeInfo
     * @throws ThemeInfoAttributeException
     */
    private function parseThemeInfo(array $info)
    {
        $themeInfo = new ThemeInfo();

        $required = ['name', 'author', 'namespace'];
        foreach ($required as $key) {
            if (!array_key_exists($key, $info))
                throw new ThemeInfoAttributeException($key);
        }

        $themeInfo->setName($info['name']);
        $themeInfo->setAuthor($info['author']);
        $themeInfo->setNamespace($info['namespace']);

        if (isset($info['description']))
            $themeInfo->setDescription($info['description']);
        if (isset($info['version']))
            $themeInfo->setVersion($info['version']);
        if (isset($info['parent']))
            $themeInfo->setParent($info['parent']);

        $themeInfo->setPath($this->findPath($info['namespace']));

        return $themeInfo;
    }

}