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

use Grav\Common\Plugin;
use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;
use DiDom\Document;


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
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onPageContentProcessed' => ['onPageContentProcessed', 0]
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
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }

        $assets = $this->grav['assets'];
        $assets->addJs('plugin://pagespeedimages/assets/img.watcher.js');

    }




    public function onPageContentProcessed(Event $event)
    {
        require_once(__DIR__ . '/vendor/autoload.php');

        /** @var Page $page */
        $page = $this->grav['page'];


        $page = $event['page'];

        $content = $this->manipulateDataAttributes($page->content());
        $page->setRawContent($content);
    }

    protected function manipulateDataAttributes(string $content)
    {
        if (strlen($content) === 0) {
            return '';
        }

        $document = new Document($content);
        $images = $document->find('img');

        foreach ($images as $image) {
//            $image = $lightbox->firstInDocument('img');

            if (!$image) {
                continue;
            }

//            $image->setAttribute('data-lazysrc', $image->getAttribute('src'));
//            $image->setAttribute('src', '');


        }

        return $document->html();
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
