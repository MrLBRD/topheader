<?php
class AdminTopHeaderController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->className = 'Configuration';
        $this->table = 'configuration';

        parent::__construct();

        $this->fields_options = array(
            'general' => array(
                'title' =>    $this->l('My Module Settings'),
                'fields' =>    array(
                    'TOPHEADER_TEXT' => array(
                        'title' => $this->l('Header Text'),
                        'desc' => $this->l('Enter the text to display in the header.'),
                        'type' => 'text',
                        'name' => 'TOPHEADER_TEXT',
                        'required' => true
                    )
                ),
                'submit' => array('title' => $this->l('Save'))
            )
        );
    }
}
