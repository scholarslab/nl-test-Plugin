<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class ExhibitsControllerTest_Get extends NeatlinePlugin_TestCase
{


    /**
     * GET should include expansion fields.
     */
    public function testGet()
    {

        $exhibit = $this->__exhibit();

        $exhibit->setArray(array(

            'public'        => 1,
            'query'         => '2',
            'base_layers'   => '3',
            'base_layer'    => '4',
            'widgets'       => '5',
            'title'         => '6',
            'slug'          => '7',
            'description'   => '8',
            'styles'        => '9',
            'map_focus'     => '10',
            'map_zoom'      => 11,

            'field1'        => 12,
            'field2'        => 13,
            'field3'        => 14

        ));

        $exhibit->save();

        $this->dispatch('neatline/exhibits/'.$exhibit->id);
        $response = $this->getResponseArray();

        $this->assertEquals($response->public,          1);
        $this->assertEquals($response->query,           '2');
        $this->assertEquals($response->base_layers,     '3');
        $this->assertEquals($response->base_layer,      '4');
        $this->assertEquals($response->widgets,         '5');
        $this->assertEquals($response->title,           '6');
        $this->assertEquals($response->slug,            '7');
        $this->assertEquals($response->description,     '8');
        $this->assertEquals($response->styles,          '9');
        $this->assertEquals($response->map_focus,       '10');
        $this->assertEquals($response->map_zoom,        11);

        $this->assertEquals($response->field1,          12);
        $this->assertEquals($response->field2,          13);
        $this->assertEquals($response->field3,          14);

    }


}
