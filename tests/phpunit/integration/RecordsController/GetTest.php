<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class RecordsControllerTest_Get extends NeatlinePlugin_Case_Default
{


    public function setUp()
    {
        parent::setUp();
        $this->_mockTheme();
    }


    /**
     * GET should emit expansion fields.
     */
    public function testGet()
    {

        $exhibit    = $this->_exhibit();
        $item       = $this->_item();
        $record     = new NeatlineRecord($exhibit, $item);

        $record->setArray(array(
            'field4' => 1,
            'field5' => 2,
            'field6' => 3
        ));

        $record->save();

        $this->dispatch('neatline/records/'.$record->id);
        $json = $this->_getResponseArray();

        $this->assertEquals($record->id, $json['id']);
        $this->assertEquals(1, $json['field4']);
        $this->assertEquals(2, $json['field5']);
        $this->assertEquals(3, $json['field6']);

    }


}
