<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class AtomicSeller extends Module {
    public $name;
    /** @var string */
    public $version;
    /** @var string */
    public $author;
    /** @var bool */
    public $need_instance;
    /** @var bool */
    public $bootstrap;
    /** @var string */
    public $displayName;
    /** @var string */
    public $description;
    /** @var string */
    public $js_path;
    /** @var string */
    public $css_path;
    /** @var string */
    public $logo_path;
    /** @var string */
    public $module_path;
    /** @var string Text to display when ask for confirmation on uninstall action */
    public $confirmUninstall;
    /** @var string */
    private $templateFile;

    // Constructor
    public function __construct() {
        $this->name = 'atomicseller';
        $this->author = 'lionking-123';
        $this->tab = 'export';
        $this->version = '1.0.0';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('AtomicSeller', array(), 'Modules.AtomicSeller.Admin');
        $this->description = $this->trans('Show the Order list and details and send details via Email.', array(), 'Modules.AtomicSeller.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', array(), 'Modules.AtomicSeller.Admin');

        if (!$this->_path) {
            $this->_path = __PS_BASE_URI__ . 'modules/' . $this->name . '/';
        }
        $this->js_path = $this->_path . 'views/js/';
        $this->css_path = $this->_path . 'views/css/';
        $this->logo_path = $this->_path . 'logo.png';
        $this->module_path = $this->_path;
    }

    // Module install function
    public function install() {
        Configuration::updateValue('WS_TOKEN', 'MIJIUGTIUY976R976F42UV087JIYUUYVO8GYPGLIE2PAB');
        Configuration::updateValue('WS_STOREKEY', 'MYSTORE');
        Configuration::updateValue('EMAIL_TITLE_MODEL', 'Return label regarding order MKUGH1.');
        Configuration::updateValue('EMAIL_CONTENT_MODEL', 'Dear customer,

Please find in attachment your return label.

Kind regards.
The customer service.');

        return (
            parent::install()
            && $this->installTab('AdminAtomicSeller', 'AtomicSeller')
        );
    }

    // Module uninstall function
    public function uninstall() {
        Configuration::deleteByName('WS_TOKEN');
        Configuration::deleteByName('WS_STOREKEY');
        Configuration::deleteByName('EMAIL_TITLE_MODEL');
        Configuration::deleteByName('EMAIL_CONTENT_MODEL');

        if(parent::uninstall()) {
            $this->uninstallTab('AdminAtomicSeller');

            return true;
        }

        return false;
    }

    // Tab install function
    public function installTab($tab_class, $tab_name, $parent = 'SELL') {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $tab_class;
        $tab->name = array();

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tab_name;
        }
        $tab->id_parent = (int)Tab::getIdFromClassName($parent);
        $tab->module = $this->name;
        $tab->icon = "shopping_basket";

        return $tab->add();
    }

    // Uninstall Tab function
    public function uninstallTab($tab_class) {
        $id_tab = (int)Tab::getIdFromClassName($tab_class);

        if($id_tab) {
            $tab = new Tab($id_tab);

            return $tab->delete();
        }

        return false;
    }

    // Load dependencies
    public function loadAsset() {
        $this->addJsDefList();

        $cssAssets = [
            $this->css_path . 'back.css',
        ];

        $javascriptAssets = [
            $this->js_path . 'back.js',
        ];

        $this->context->controller->addCSS($cssAssets, 'all');
        $this->context->controller->addJS($javascriptAssets);
    }

    // Add javascript parameter define
    protected function addJsDefList() {
        Media::addJsDef(array(
            'psr_controller_atomicseller_url' => $this->context->link->getAdminLink('AdminAtomicSeller'),
            'psr_controller_atomicseller' => 'AdminAtomicSeller',
            'connection_success' => $this->trans('Webservice connection tested successfully!', array(), 'Modules.AtomicSeller.Admin'),
            'active_error' => $this->trans('Oops... looks like an error occurred!', array(), 'Modules.AtomicSeller.Admin'),
            'psre_success' => $this->trans('Configuration updated successfully!', array(), 'Modules.AtomicSeller.Admin'),
        ));
    }

    // Module's configuration page
    public function getContent() {
        $this->loadAsset();

        $this->context->smarty->assign(array(
            'ws_token' => Configuration::get('WS_TOKEN'),
            'ws_storekey' => Configuration::get('WS_STOREKEY'),
            'email_title' => Configuration::get('EMAIL_TITLE_MODEL'),
            'email_content' => Configuration::get('EMAIL_CONTENT_MODEL'),
            'logo_path' => $this->logo_path,
        ));

        return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
    }
}