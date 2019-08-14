<?php
/**
 * DokuWiki Plugin linkextractor (Helper Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Michael Hamann <michael@content-space.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) {
    die();
}

class helper_plugin_linkextractor extends DokuWiki_Plugin
{
    /**
     * Extract the external links of a given page.
     *
     * @param string $id The id to get the links for
     * @return array The list of external links
     */
    public function extractLinks(string $id)
    {
        $result = [];
        $ins = p_cached_instructions(wikiFN($id), false, $id);
        foreach ($ins as $i) {
            if ($i[0] === 'externallink') {
                $result[] = $i[1][0];
            }
        }
        return $result;
    }
}
