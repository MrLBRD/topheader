<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminTopHeaderController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->className = 'Configuration';
        $this->table = 'topheader';

        parent::__construct();

        
        // Fetch configurations from the new table
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "topheader WHERE id_topheader = 1";
        $configs = Db::getInstance()->getRow($sql);
        echo "<script>console.log('Debug Objects: " . $configs . "' );</script>";

        $this->context->smarty->assign(array(
            'title' => $this->l('Top Header Settings'),
            'action' => $this->context->link->getAdminLink('AdminTopHeader'),
            'configs' => $configs,
            'label' => $this->l('Header Text'),
            'value' => $configs['text'],
            'label_switch' => $this->l('Display Header'),
            'display_value' => $configs['display'],
            'text_color_value' => $configs['text_color'],
            'bg_color_value' => $configs['bg_color'],
        ));


        $this->setTemplate('module:topheader/views/templates/admin/configure.tpl');
        if (Tools::isSubmit('submitUpdate')) {
            $topHeader_text = Tools::getValue('TOPHEADER_TEXT');
            $topHeader_display = Tools::getValue('TOPHEADER_DISPLAY');
            $topheader_text_color = Tools::getValue('TOPHEADER_TEXT_COLOR');
            $topheader_bg_color = Tools::getValue('TOPHEADER_BG_COLOR');
        
            // Simple validation
            if (empty($topHeader_text)) {
                $this->errors[] = $this->l('Header text cannot be empty.');
            } else {
                // Update the values in the table
                $sql = "UPDATE " . _DB_PREFIX_ . "topheader SET 
                        text = '" . pSQL($topHeader_text) . "', 
                        display = " . (int)$topHeader_display . ", 
                        text_color = '" . pSQL($topheader_text_color) . "', 
                        bg_color = 'testtesttest' 
                        WHERE id_topheader = 1";
                Db::getInstance()->execute($sql);
                
                $this->confirmations[] = $this->l('Settings updated successfully.');
            }
        } else {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&configure=topheader');
        }
    }
}
