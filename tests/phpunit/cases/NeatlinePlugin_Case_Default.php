<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


class NeatlinePlugin_Case_Default extends Neatline_Case_Abstract
{


    /**
     * Bootstrap the plugin.
     */
    public function setUp()
    {

        parent::setUp();

        // Authenticate and set the current user.
        $this->user = $this->db->getTable('User')->find(1);
        $this->_authenticateUser($this->user);

        // Install Neatline and NeatlinePlugin.
        $pluginHelper = new Omeka_Test_Helper_Plugin;
        $pluginHelper->setUp('Neatline');
        $pluginHelper->setUp('NeatlinePlugin');

        // Alias expandables.
        $this->__exhibits = $this->db->getTable('NeatlineExhibit');
        $this->__records  = $this->db->getTable('NeatlineRecord');

        // Alias expansions.
        $this->__exhibitExpansions = $this->db->getTable(
            'NeatlineExhibitExpansion');
        $this->__recordExpansions = $this->db->getTable(
            'NeatlineRecordExpansion');

    }


    /**
     * Get the Jasmine fixtures directory.
     *
     * @return string The directory.
     */
    protected function getFixturesPath()
    {
        return NL_PLUGINS_DIR . '/tests/jasmine/fixtures/';
    }


}
