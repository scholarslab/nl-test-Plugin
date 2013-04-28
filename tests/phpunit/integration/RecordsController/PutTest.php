<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class RecordsControllerTest_Put extends NeatlinePlugin_TestCase
{


    /**
     * PUT should update a record.
     */
    public function testUpdateRecord()
    {

        $record = $this->__record();

        $record->setArray(array(
            'field4' => 1,
            'field5' => 2,
            'field6' => 3
        ));

        $record->save();

        $this->writePut(array(
            'field4' => '4',
            'field5' => '5',
            'field6' => '6'
        ));

        $this->dispatch('neatline/records/'.$record->id);
        $record = $this->reload($record);

        $this->assertEquals($record->field4, 4);
        $this->assertEquals($record->field5, 5);
        $this->assertEquals($record->field6, 6);

    }


}
