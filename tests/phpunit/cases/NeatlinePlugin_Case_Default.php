<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


class NeatlinePlugin_Case_Default extends Neatline_Case_Default
{


    /**
     * Bootstrap the plugin.
     */
    public function setUp()
    {

        parent::setUp();

        // Install NeatlinePlugin.
        $this->helper->setUp('NeatlinePlugin');

        // Alias expansions.
        $this->_exhibitExpansions = $this->db->getTable(
            'NeatlineExhibitExpansion'
        );
        $this->_recordExpansions  = $this->db->getTable(
            'NeatlineRecordExpansion'
        );

    }


}
