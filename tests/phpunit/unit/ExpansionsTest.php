<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class ExpansionsTest extends NeatlinePlugin_Case_Default
{


    /**
     * When a record is saved for which an expansion row does not exist, a new
     * expansion should be created, populated with field data, and associated
     * with the record.
     */
    public function testCreateExpansion()
    {

        $record = new NeatlineRecord();

        $record->field4 = 1;
        $record->field5 = 2;
        $record->field6 = 3;

        $c1 = $this->_recordExpansions->count();
        $record->save();
        $c2 = $this->_recordExpansions->count();

        // Should create row.
        $this->assertEquals($c1+1, $c2);

        // Should set expansion fields.
        $expansion = $this->_recordExpansions->getOrCreate($record);
        $this->assertEquals(1, $expansion->field4);
        $this->assertEquals(2, $expansion->field5);
        $this->assertEquals(3, $expansion->field6);

    }


    /**
     * When a record is saved for whcih an expansion row already exists, the
     * existing expansion should be updated with new data.
     */
    public function testUpdateExpansion()
    {

        $record = new NeatlineRecord();

        $record->field4 = 1;
        $record->field5 = 2;
        $record->field6 = 3;

        $record->save();

        $record->field4 = 4;
        $record->field5 = 5;
        $record->field6 = 6;

        $c1 = $this->_recordExpansions->count();
        $record->save();
        $c2 = $this->_recordExpansions->count();

        // Should not create row.
        $this->assertEquals($c1, $c2);

        // Should set expansion fields.
        $expansion = $this->_recordExpansions->getOrCreate($record);
        $this->assertEquals(4, $expansion->field4);
        $this->assertEquals(5, $expansion->field5);
        $this->assertEquals(6, $expansion->field6);

    }


    /**
     * When record for which no expansion exists is loaded, the expansion
     * fields should be left-joined as NULL columns onto the row.
     */
    public function testJoinMissingExpansion()
    {

        $record = new NeatlineRecord();
        $record->__save();

        $record = $this->_reload($record);
        $fields = $record->toArray();

        // Should left-join expansion fields.
        $this->assertArrayHasKey('field4', $fields);
        $this->assertArrayHasKey('field5', $fields);
        $this->assertArrayHasKey('field6', $fields);
        $this->assertNull($fields['field4']);
        $this->assertNull($fields['field5']);
        $this->assertNull($fields['field6']);

    }


    /**
     * When record that has an expansion is loaded, the expansion should be
     * left-joined onto the row.
     */
    public function testJoinExistingExpansion()
    {

        $record = new NeatlineRecord();

        $record->field4 = 1;
        $record->field5 = 2;
        $record->field6 = 3;

        $record->save();

        $record = $this->_reload($record);
        $this->assertEquals(1, $record->field4);
        $this->assertEquals(2, $record->field5);
        $this->assertEquals(3, $record->field6);

    }


    /**
     * When a parent is loaded, the `id` column on the expansion table should
     * be omitted from the list of columns to be joined onto the record.
     * Otherwise, the expansion id will clobber the record id.
     */
    public function testPreserveParentIdOnQuery()
    {

        $recordA = new NeatlineRecord();
        $recordA->__save();

        // Manually create expansion for record. (Ensure that the id of the
        // expansion is different from the id of the record.)

        $expansion = new NeatlineRecordExpansion($recordA);
        $expansion->id = 999;
        $expansion->save();

        // When the record is loaded, the id of the expansion should not
        // "joined over" the id of the parent record.

        $recordB = $this->_reload($recordA);
        $this->assertEquals($recordA->id, $recordB->id);
        $this->assertNotEquals(999, $recordB->id);

    }


    /**
     * When a record is saved, its `id` column should be removed from the
     * array of data set on the expansion. Otherwise, the expansion's `id`
     * would be set to the value of the parent's id.
     */
    public function testPreserveExpansionIdOnSave()
    {

        $record = new NeatlineRecord();
        $record->__save();

        // Manually create expansion for record. (Ensure that the id of the
        // expansion is different from the id of the record.)

        $expansionA = new NeatlineRecordExpansion($record);
        $expansionA->id = 999;
        $expansionA->save();

        $record->save();

        // When the parent record is saved, the id of the parent record should
        // not get passed as a settable field to the expansion.

        $expansionB = $this->_reload($expansionA);
        $this->assertEquals(999, $expansionB->id);

    }


    /**
     * When a record that does _not_ have an expansion is queried with NULL
     * expansion columns and then the record is saved (for example, when an
     * expansion table has just been installed, and an existing Neatline
     * record is saved for the first time since the expansion was added), the
     * `parent_id` column should be removed from the array of data set on the
     * expansion. Otherwise, the NULL value that was left-joined onto the
     * parent at query-time would clobber out the foreign key reference that
     * is set when the expansion is created.
     */
    public function testPreserveExpansionParentId()
    {

        $record = new NeatlineRecord();
        $record->__save();

        // Load a record without an expansion. A NULL `parent_id` will be
        // left-joined onto the row.

        $record = $this->_reload($record);

        $record->field4 = 1;
        $record->field5 = 2;
        $record->field6 = 3;

        // Save the record normally, causing an expansion to be created.

        $record->save();

        // When the record is loaded again, the expansion row should be left-
        // joined onto the parent. If the NULL `parent_id` value were passed
        // to the expansion when it was saved, the reference to the parent
        // would be broken, and the expansion columns would not be present on
        // the row.

        $record = $this->_reload($record);
        $this->assertEquals(1, $record->field4);
        $this->assertEquals(2, $record->field5);
        $this->assertEquals(3, $record->field6);

    }


    /**
     * Likewise, left-joined NULL default values should not override field
     * defaults provided by the expansion row model.
     */
    public function testPreserveExpansionFieldDefaults()
    {

        $record = new NeatlineRecord();
        $record->__save();

        // Load a record without an expansion. The three expansion fields
        // (`field4`, `field5`, `field6`) will all be joined onto the row
        // as NULL values.

        $record = $this->_reload($record);

        // Save the record normally, causing an expansion to be created.

        $record->save();

        // The fields defaults on the expansion row model should not be
        // overwritten by the left-joined NULL values.

        $record = $this->_reload($record);
        $this->assertEquals(4, $record->field4);
        $this->assertEquals(5, $record->field5);
        $this->assertEquals(6, $record->field6);

    }


    /**
     * When a record is deleted, all of its expansions should be deleted.
     */
    public function testDeleteRecordExpansionsOnRecordDelete()
    {

        $record1 = new NeatlineRecord();
        $record2 = new NeatlineRecord();

        $record1->save();
        $record2->save();

        $c1 = $this->_recordExpansions->count();
        $record1->delete();
        $c2 = $this->_recordExpansions->count();

        $expansion1 = $this->_recordExpansions->findByParent($record1);
        $expansion2 = $this->_recordExpansions->findByParent($record2);

        // Should delete record 1 row.
        $this->assertNull($expansion1);
        $this->assertEquals($c1-1, $c2);

        // Should not delete record 2 row.
        $this->assertNotNull($expansion2);

    }


    /**
     * When an exhibit is deleted, all of the expansions for child records
     * should also be deleted.
     */
    public function testDeleteRecordExpansionsOnExhibitDelete()
    {

        $exhibit1 = $this->_exhibit();
        $exhibit2 = $this->_exhibit();

        $record1 = new NeatlineRecord($exhibit1);
        $record2 = new NeatlineRecord($exhibit2);

        $record1->save();
        $record2->save();

        $c1 = $this->_recordExpansions->count();
        $exhibit1->delete();
        $c2 = $this->_recordExpansions->count();

        $expansion1 = $this->_recordExpansions->findByParent($record1);
        $expansion2 = $this->_recordExpansions->findByParent($record2);

        // Should delete record 1 row.
        $this->assertNull($expansion1);
        $this->assertEquals($c1-1, $c2);

        // Should not delete record 2 row.
        $this->assertNotNull($expansion2);

    }


    /**
     * When an exhibit is deleted, all its expansions should be deleted.
     */
    public function testDeleteExhibitExpansionsOnExhibitDelete()
    {

        $exhibit1 = $this->_exhibit();
        $exhibit2 = $this->_exhibit();

        $c1 = $this->_exhibitExpansions->count();
        $exhibit1->delete();
        $c2 = $this->_exhibitExpansions->count();

        $expansion1 = $this->_exhibitExpansions->findByParent($exhibit1);
        $expansion2 = $this->_exhibitExpansions->findByParent($exhibit2);

        // Should delete exhibit 1 row.
        $this->assertNull($expansion1);
        $this->assertEquals($c1-1, $c2);

        // Should not delete exhibit 2 row.
        $this->assertNotNull($expansion2);

    }


}
