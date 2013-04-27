<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


class NeatlinePluginPlugin extends Omeka_Plugin_AbstractPlugin
{


    protected $_hooks = array(
        'install',
        'uninstall'
    );


    protected $_filters = array(
        'neatline_exhibit_expansions',
        'neatline_record_expansions'
    );


    /**
     * Create exhibit and record expansions.
     */
    public function hookInstall()
    {

        // Exhibit:
        $sql = "CREATE TABLE IF NOT EXISTS
            `{$this->_db->prefix}neatline_exhibit_expansions` (

            `id`            INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `parent_id`     INT(10) UNSIGNED NULL,
            `field1`        INT(10) UNSIGNED NULL,
            `field2`        INT(10) UNSIGNED NULL,
            `field3`        INT(10) UNSIGNED NULL,

             PRIMARY KEY    (`id`),
             INDEX          (`parent_id`)

        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $this->_db->query($sql);

        // Record:
        $sql = "CREATE TABLE IF NOT EXISTS
            `{$this->_db->prefix}neatline_record_expansions` (

            `id`            INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `parent_id`     INT(10) UNSIGNED NULL,
            `field4`        INT(10) UNSIGNED NULL,
            `field5`        INT(10) UNSIGNED NULL,
            `field6`        INT(10) UNSIGNED NULL,

             PRIMARY KEY    (`id`),
             INDEX          (`parent_id`)

        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $this->_db->query($sql);

    }


    /**
     * Drop exhibit expansion table.
     */
    public function hookUninstall()
    {

        // Exhibit:
        $sql = "DROP TABLE IF EXISTS
            `{$this->_db->prefix}neatline_exhibit_expansions`";
        $this->_db->query($sql);

        // Record:
        $sql = "DROP TABLE IF EXISTS
            `{$this->_db->prefix}neatline_record_expansions`";
        $this->_db->query($sql);

    }


    /**
     * Register the exhibit expansion.
     *
     * @param array $tables Exhbit expansions.
     * @return array The modified array.
     */
    public function filterNeatlineExhibitExpansions($tables)
    {
        $tables[] = $this->_db->getTable(
            'NeatlineExhibitExpansion'
        );
        return $tables;
    }


    /**
     * Register the exhibit expansion.
     *
     * @param array $tables Exhbit expansions.
     * @return array The modified array.
     */
    public function filterNeatlineRecordExpansions($tables)
    {
        $tables[] = $this->_db->getTable(
            'NeatlineRecordExpansion'
        );
        return $tables;
    }


}
