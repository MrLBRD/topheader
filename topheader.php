<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class TopHeader extends Module
{
    public function __construct()
    {
        $this->name = 'topheader';
        $this->tab = 'front_office_features';
        $this->version = '1.0.5';
        $this->author = 'Arnaud';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Top header');
        $this->description = $this->l('Description of your module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        return parent::install() &&
            $this->registerHook('header') &&
            Configuration::updateValue('TOPHEADER_TEXT', 'My default text') &&
            Configuration::updateValue('TOPHEADER_DISPLAY', '1');
    }


    public function uninstall()
    {
        return parent::uninstall() &&
            Configuration::deleteByName('TOPHEADER_TEXT') &&
            Configuration::deleteByName('TOPHEADER_DISPLAY');
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            $top_header = strval(Tools::getValue('TOPHEADER_TEXT'));
            $display_header = Tools::getValue('TOPHEADER_DISPLAY', '0');
            if (!$top_header || empty($top_header) || !Validate::isGenericName($top_header)) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                Configuration::updateValue('TOPHEADER_TEXT', $top_header);
                Configuration::updateValue('TOPHEADER_DISPLAY', $display_header);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }
        return $output . $this->displayForm();
    }


    public function displayForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fields_form[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Header text'),
                    'name' => 'TOPHEADER_TEXT',
                    'size' => 50,
                    'required' => true
                ],
                [
                    'type' => 'switch',
                    'label' => $this->l('Display header'),
                    'name' => 'TOPHEADER_DISPLAY',
                    'is_bool' => true,
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ],
                        [
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        ]
                    ]
                ]
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'button'
            ]
        ];

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                    '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        // Load current value
        $helper->fields_value['TOPHEADER_TEXT'] = Configuration::get('TOPHEADER_TEXT');
        $helper->fields_value['TOPHEADER_DISPLAY'] = Configuration::get('TOPHEADER_DISPLAY');

        return $helper->generateForm($fields_form);
    }

    public function getConfigFieldsValues()
    {
        return [
            'TOPHEADER_TEXT' => Tools::getValue('TOPHEADER_TEXT', Configuration::get('TOPHEADER_TEXT')),
        ];
    }

    public function hookDisplayHeader()
    {
        if (Configuration::get('TOPHEADER_DISPLAY') !== '0') {
            $this->context->smarty->assign('topheader_text', Configuration::get('TOPHEADER_TEXT'));
            return $this->display(__FILE__, 'hookHeader.tpl');
        }
    }
}
