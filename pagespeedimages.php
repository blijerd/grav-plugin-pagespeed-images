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
//use WebPConvert\WebPConvert;

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
            if($loadIcon == '') {
                $loadIcon = "iVBORw0KGgoAAAANSUhEUgAABQAAAAPAAQMAAABQEkY6AAAABlBMVEXx7/DJyckxtY4GAAAE0UlEQVR42u3dTXLaSAAF4KZYsPQROApHQzcbjqIjsNRCJScDdqwWLdupTIoH832rxPLi1UPqbv3hUgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAgvr990FlBAAQV8zoD7p2lw8BELKKCAxkEfsYB/KeB3fi094OauAbvoBvcatA++NTho8HHHwU6DfzgOatA4qEEzifVgfIO7z8+X+rsfxV8G1OBjN1jSG+yeo8HhfuNgZx80DmpQg//nBvdP0+BgH3QUWw++vk7tG085DV6S5I2DHw3+/P8xucGxtG9wxxzF/2bYJY+D/fUiR+5McrpeJspt8PKDY+4+OF1+cMhtcHwfd1LXg+N74tQGr8fpLncfvEbY5jbYrwfMaPAyDLZG6pS5+JOA951J3j/i7vqT3AbfAh5j14NlPWBGgyWywduAh9RxcPokYESD06M0uE9vcJ/a4Ph5g3e8T1K+DvgIDd5/H3yYBl80+BcClvSDRIPfWQ/GNzhlziQPNBdbDz59g/HnJKFndfvVE/d/4hpcXPo4xO2Di4D7uAYXV7f2cfdJ+irg9BJ3beYacNsKmHG/+FwFHHdxDdZX+auAGdcHh+qcadzGNThVq60qYOK9umGTd7ezm890VcCQO+6n+URyLpl33LfNgCF33IfZKPMz4DGuweqpjypgyvODXZmnOuQ9/daX+eB3yHv6bZqdFJ8+/p35/GAVMPH5wdPHlczM5wergInvk8x+mtlgFTDxfZLZrJfZYBWwRAbcZI+DVcDABqfZ0jCywTpgYIPjbPUf2WAdMPB9knF2ghfb4CH5fZJhtvyPbLAOGHgUn2eXaSLn4jpg4HrwXBZvcSQ2uIt7n6S+efNrvRXZYB0w8Cg+BTXYrQXcJM8kdcBHaDBtH+zKx4o1ssE6YOB6sKQ3eNl4DN4H64Aa/O0Gq7tOiXPxImDG+yTLc6boBqt37BLXg4uAGvztgNXd98RxcBEwr8FzeoOXxczsPnJag29PBO9iG+zLTYP3f5/kZqnw67Qur8FhGTBtHzyFN/j+PPD7aV1cg+ebgGFzcRfW4PIjHj+2ZjbY3wbMWg+W8AbnU8Yx8erWqREwaRycSrvBmI+4CnIIbLBrBQxqcCzhDfbLQSjt+mBpBsxpcCxpDS72wfFma1iD53bAnJmkT2zwk4C7uPVg1w6Y02AX12C9HpwWW7dpDa4FjBkHh8gGu/kbBrVNWoNrAWMaPK03mDGTdMvNaQ2uBUxZD04lvMHbgMeso3hYC5jS4JDeYH+z+ZA1F5/WAqasB0+tgzypwebmoPdJbkeZ65aYBhsBt1FHceNT3ESNg63dLKrBvrH9mNTgqbH9EPeGdmMgzPpG78ZAmLIenFrbd0ENNgNug85JmhE2QQ22I8R9o3djIMz6PurGQJiyHuzWDvOw76O+/YU+4/rg1P6FXdw3ON4OhL2/vvvVQfI1f333zxu0Dz5qg3sN2gc1+F8EvPf7JE/R4F3Xgxo0DmrwsRv8nviAd7xP8iQNCiiggMZB46CAAgpoHDQOCggAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAED5Ad0SkTuGJPcVAAAAAElFTkSuQmCC";
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
