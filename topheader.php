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
        $this->version = '1.0.25';
        $this->author = 'Arnaud';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.8',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Top Header');
        $this->description = $this->l('Description of your module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        Db::getInstance()->execute("
            CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "topheader` (
                `id_topheader` INT(11) NOT NULL AUTO_INCREMENT,
                `text` TEXT NOT NULL,
                `display` TINYINT(1) NOT NULL DEFAULT '1',
                `text_color` VARCHAR(7) NOT NULL DEFAULT '#FFFFFF',
                `bg_color` VARCHAR(7) NOT NULL DEFAULT '#000000',
                PRIMARY KEY (`id_topheader`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8;
        ");
        
        Db::getInstance()->execute("
            INSERT INTO `" . _DB_PREFIX_ . "topheader` (text, display, text_color, bg_color)
            VALUES ('My default text', 1, '#FFFFFF', '#000000')
        ");

        return parent::install() &&
            $this->registerHook('header') &&
            $this->installTab();
    }

    public function uninstall()
    {
        Db::getInstance()->execute("
            DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "topheader`;
        ");

        return parent::uninstall() &&
            $this->uninstallTab();
    }

    public function installTab()
    {
        // Log the start of the function
        PrestaShopLogger::addLog('Installing TopHeader tab', 1, null, 'TopHeader', (int) $this->id, true);
        
        $tab = new Tab();
        $tab->class_name = 'AdminTopHeader';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->position = Tab::getNewLastPosition($tab->id_parent);
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Top Header';
        }
        $result = $tab->save();
        if (!$tab->save()) {
            PrestaShopLogger::addLog('Error saving TopHeader tab: ' . implode(', ', $tab->getErrors()), 3, null, 'TopHeader', (int) $this->id, true);
        }
        
    
        // Log the result of the tab installation
        if ($result) {
            PrestaShopLogger::addLog('TopHeader tab installed successfully', 1, null, 'TopHeader', (int) $this->id, true);
        } else {
            PrestaShopLogger::addLog('Failed to install TopHeader tab', 3, null, 'TopHeader', (int) $this->id, true);
        }
    
        return $result;
    }
    

    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminTopHeader');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            return $tab->delete();
        }
        return true;
    }


    public function getContent()
    {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "topheader WHERE id_topheader = 1";
        $value = Db::getInstance()->getRow($sql);
        // Assign variables for the template
        $this->context->smarty->assign(array(
            'action' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=topheader',
            'value' => $value['text'],
            'display_value' => $value['display'] === '1',
            'text_color_value' => $value['text_color'],
            'bg_color_value' => $value['bg_color'],
        ));

        // Handle form submission and save
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
                        bg_color = '" . pSQL($topheader_bg_color) . "' 
                        WHERE id_topheader = 1";
                Db::getInstance()->execute($sql);
                $this->confirmations[] = $this->l('Settings updated successfully.');
            }
        }        

        // Fetch the template and return
        return $this->display($this->local_path, 'views/templates/admin/configure.tpl');
    }

    public function getConfigFieldsValues()
    {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "topheader WHERE id_topheader = 1";
        $data = Db::getInstance()->getRow($sql);
    
        return [
            'TOPHEADER_TEXT' => Tools::getValue('TOPHEADER_TEXT', $data['text']),
            'TOPHEADER_DISPLAY' => Tools::getValue('TOPHEADER_DISPLAY', $data['display']),
            'TOPHEADER_TEXT_COLOR' => Tools::getValue('TOPHEADER_TEXT_COLOR', $data['text_color']),
            'TOPHEADER_BG_COLOR' => Tools::getValue('TOPHEADER_BG_COLOR', $data['bg_color']),
        ];
    }

    public function hookDisplayHeader()
    {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "topheader WHERE id_topheader = 1";
        $value = Db::getInstance()->getRow($sql);
        if ($value['display'] !== '0') {
            $this->context->smarty->assign(array(
                'topheader_text' => $value['text'],
                'text_color_value' => $value['text_color'],
                'bg_color_value' => $value['bg_color'],
            ));
            return $this->display(__FILE__, 'hookHeader.tpl');
        }
    }
}
