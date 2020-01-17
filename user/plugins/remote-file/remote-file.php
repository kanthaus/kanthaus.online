<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class RemoteFilePlugin
 * @package Grav\Plugin
 */
class RemoteFilePlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main event we are interested in
        $this->enable([
            'onPageContentRaw' => ['onPageContentRaw', 0]
        ]);
    }


    /**
     * Do some work for this event, full details of events can be found
     * on the learn site: http://learn.getgrav.org/plugins/event-hooks
     *
     * @param Event $e
     */
    public function onPageContentRaw(Event $e)
    {
        $cacheDriver = $this->grav['cache']->getCacheDriver();
        $header = $e['page']->header();
        // $remote = ->remote;
        if(!isset($header->remote) || !$header->remote) {
            return;
        }
        if(!isset($header->remote['url']) || !$header->remote['url']) {
            throw new \Error('url missing in remote definition');
        }

        $url = $header->remote['url'];
        $cachePeriod = isset($header->remote['cachePeriod']) ? $header->remote['cachePeriod'] : 5*60;
        $cacheKey = "remote-file:".$cachePeriod.":".$url;

        if($cachePeriod) {
            $cached = $this->grav['cache']->fetch($cacheKey);
            if ($cached) {
                $e['page']->setRawContent($cached);
                return;
            }
        }

        $content = file_get_contents($url);
        $e['page']->setRawContent($content);
        if($cachePeriod) {
            $this->grav['cache']->save($cacheKey, $content, $cachePeriod); // 5 min
        }
    }
}
