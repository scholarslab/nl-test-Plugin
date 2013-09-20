<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class RecordsControllerTest_Post extends NeatlinePlugin_Case_Default
{


    /**
     * POST should create a new record with expansion fields.
     */
    public function testCreateRecord()
    {

        $exhibit = $this->_exhibit();

        $this->request->setMethod('POST')->setRawBody(
            Zend_Json::encode(array(
                'exhibit_id'    => $exhibit->id,
                'field4'        => '1',
                'field5'        => '2',
                'field6'        => '3'
            )
        ));

        $this->dispatch('neatline/records');
        $record = $this->_records->find($this->_getResponseArray()->id);

        // Should update fields.
        $this->assertEquals(1, $record->field4);
        $this->assertEquals(2, $record->field5);
        $this->assertEquals(3, $record->field6);

    }


}
