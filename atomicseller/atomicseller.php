<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class AtomicSeller extends Module {
    // Constructor
    public function __construct() {
        $this->name = 'atomicseller';
        $this->author = 'lionking-123';
        $this->tab = 'export';
        $this->version = '1.0.0';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('AtomicSeller');
        $this->description = $this->l('Show the Order list and details and send details via Email.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    // Module install function
    public function install() {
        return (
            parent::install()
            && $this->installTab('AdminAtomicSeller', 'AtomicSeller')
        );
    }

    // Module uninstall function
    public function uninstall() {
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
        $tab->name = $tab_name;
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

    // Module's configuration page
    public function getContent() {
        return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
    }
}