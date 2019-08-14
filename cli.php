<?php
/**
 * DokuWiki Plugin linkextractor (CLI Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Michael Hamann <michael@content-space.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) {
    die();
}

use splitbrain\phpcli\Options;

class cli_plugin_linkextractor extends DokuWiki_CLI_Plugin
{

    /**
     * Register options and arguments on the given $options object
     *
     * @param Options $options
     *
     * @return void
     */
    protected function setup(Options $options)
    {
        $options->setHelp('Lists all external links of the wiki exactly once');
        $options->registerOption('version', 'print version', 'v');
    }

    /**
     * Your main program
     *
     * Arguments and options have been parsed when this is run
     *
     * @param Options $options
     *
     * @return void
     */
    protected function main(Options $options)
    {
        global $conf;

        if ($options->getOpt('version')) {
            $info = $this->getInfo();
            $this->success($info['date']);
        } else {
            /** @var $helper helper_plugin_linkextractor */
            $helper = $this->loadHelper('linkextractor');
            if (!$helper) {
                $this->fatal("Failed loading the helper");
            }

            $all_pages = [];
            search($all_pages, $conf['datadir'], 'search_allpages', ['skipacl' => true]);

            $known_links = [];
            foreach ($all_pages as $page) {
                $links = $helper->extractLinks($page['id']);
                foreach($links as $link) {
                    if (!array_key_exists($link, $known_links)) {
                        $known_links[$link] = true;
                        echo "$link\n";
                    }
                }
            }
        }
    }
}
