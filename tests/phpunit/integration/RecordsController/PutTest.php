<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class RecordsControllerTest_Put extends NeatlinePlugin_Case_Default
{


    /**
     * PUT should update a record.
     */
    public function testUpdateRecord()
    {

        $record = $this->_record();

        $record->setArray(array(
            'field4' => 1,
            'field5' => 2,
            'field6' => 3
        ));

        $record->save();

        $this->_setPut(array(
            'field4' => '4',
            'field5' => '5',
            'field6' => '6'
        ));

        $this->dispatch('neatline/records/'.$record->id);
        $record = $this->_reload($record);

        $this->assertEquals(4, $record->field4);
        $this->assertEquals(5, $record->field5);
        $this->assertEquals(6, $record->field6);

    }


}
