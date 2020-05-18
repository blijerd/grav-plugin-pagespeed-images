<?php
/**
 * ImgSrcset Plugin
 *
 * PHP version 7
 *
 * @category   Extensions
 * @package    Grav
 * @subpackage ImgSrcset
 * @author     Ole Vik <git@olevik.net>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @link       https://github.com/OleVik/grav-plugin-imgsrcset
 */
namespace Grav\Plugin;

use Grav\Common\Data;
use Grav\Common\Plugin;
use Grav\Common\Grav;
use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;
use PHPHtmlParser\Dom;

/**
 * Adds a srcset-attribute to img-elements to allow for responsive images in Markdown
 *
 * Class ImgSrcsetPlugin
 *
 * @category Extensions
 * @package  Grav\Plugin
 * @author   Ole Vik <git@olevik.net>
 * @license  http://www.opensource.org/licenses/mit-license.html MIT License
 * @link     https://github.com/OleVik/grav-plugin-imgsrcset
 */
class PagespeedImagesPlugin extends Plugin
{

    /**
     * Register events with Grav
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPageContentProcessed' => ['onPageContentProcessed', 0],
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Iterates over images in page content and rewrites paths
     *
     * @return void
     */
    public function onPageContentProcessed()
    {
        if ($this->isAdmin()) {
            return;
        }
        $config = (array) $this->config->get('plugins.pagespeedimages');
        $page = $this->grav['page'];
        $config = $this->mergeConfig($page);
        if ($config['enabled']) {
            include __DIR__ . '/vendor/autoload.php';
            $dom = new Dom;
            $dom->load($page->getRawContent());
            $images = $dom->find('img');
            $loadIcon = $config['loadIcon'];
            if(!$loadIcon) {
                $loadIcon = url("plugin://pagespeedimages/assets/giphy.gif");
            }
            foreach ($images as $image) {
                $image->setAttribute('data-lazysrc', $image->getAttribute('src'));
                $image->setAttribute('src', $loadIcon);
            }
            $page->setRawContent($dom->outerHtml);
        }
    }

    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        //add assets
        $assets = $this->grav['assets'];
        // $assets->addJs('plugin://fullcalendar/assets/lib/jquery.min.js');	// geht auch ohne, da jquery bereits in system/assets

        $assets->addJs('plugin://pagespeedimages/assets/img.watcher.js');

    }
}
