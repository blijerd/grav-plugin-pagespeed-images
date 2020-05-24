<?php
/**
 * Pagespeed Images Plugin
 *
 * PHP version 7
 *
 * @category   Extensions
 * @package    Grav
 * @subpackage Zapierwebhook
 * @author     Edwin Rasser <edwin@blijwin.nl>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @link       https://github.com/blijerd/grav-plugin-pagespeedimages
 */

namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;
use DiDom\Document;



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
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onOutputGenerated' => ['onOutputGenerated', 0]
        ];
    }

    /**
     * Iterates over images in page content and rewrites paths
     *
     * @return void
     */


    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if (!$this->config->get('plugins.pagespeedimages.enabled')) {
            return;
        }
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }


        $assets = $this->grav['assets'];
        $assets->addJs('plugin://pagespeedimages/assets/img.watcher.js');
        $assets->addJs('plugin://pagespeedimages/assets/js.lazy.js');

    }




    public function onOutputGenerated()
    {
        if (!$this->config->get('plugins.pagespeedimages.enabled')) {
            return;
        }
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }



        require_once(__DIR__ . '/vendor/autoload.php');



        // Get content and list of exclude tags
        $content = $this->grav->output;

        $content = $this->manipulateDataAttributes($content);
        $content = $this->lazyCaptcha($content);
        $this->grav->output =$content;
    }

    protected function manipulateDataAttributes(string $content)
    {
        if (strlen($content) === 0) {
            return '';
        }

        $dom = new Document($content);

        $images = $dom->find('img');
        foreach ($images as $image) {
            if(!$image) {
                continue;
            }
            if ($image->hasAttribute('class') && strstr($image->getAttribute('class'), 'nolazy')) {
                continue;
            }
            $image->setAttribute('data-lazysrc', $image->getAttribute('src'));
            $image->setAttribute('src', '');
        }

        return $dom->html();
    }

    protected function lazyCaptcha(string $content)
    {
        if (strlen($content) === 0) {
            return '';
        }

        $dom = new Document($content);

        $scripts = $dom->find('script');
        foreach ($scripts as $script) {
            if(!$script) {
                continue;
            }
            if ($script->hasAttribute('src') && strstr($script->getAttribute('src'), 'recaptcha/api.js')) {
                $script->setAttribute('data-lazyjs', $script->getAttribute('src'));
                $script->setAttribute('src', '');
            }

        }

        return $dom->html();
    }


//    public function onImageMediumSaved(Event $event)
//    {
//
//        $source = $event['image'];
//
//        $target = explode(".",$source)[0] . ".webp";
//
//        $quality = 90;
//        $stripMetadata = true;
//
//// .. fire up WebP conversion
//        WebPConvert::convert($source, $target, $quality, $stripMetadata);
//    }
}
