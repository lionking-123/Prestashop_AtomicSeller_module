<?php

class AdminAtomicSellerController extends ModuleAdminController {

    public function __construct() {
        $this->className = 'AtomicSeller';
        $this->context = Context::getContext();
        $this->bootstrap = true;

        parent::__construct();
    }

    public function initContent() {
        parent::initContent();

        $params=array();
        $this->context->smarty->assign($params);
    }

    // Ajax response render
    protected function ajaxRenderJson($content) {
        header('Content-Type: application/json');
        $this->ajaxRender(json_encode($content));
    }

    // Search Order List
    public function displayAjaxSearchOrderList() {
        $order_ref = Tools::getValue('order_ref');
        $order_date = Tools::getValue('order_date');
        $order_status = Tools::getValue('order_status');
        $customer_name = Tools::getValue('customer_name');

        $params = array();
        $add_sql = "";
        if($order_ref != "") {
            $add_sql .= " WHERE `reference` LIKE '%" . $order_ref . "%'";
        }

        if($order_date != "") {
            if($order_ref == "") {
                $add_sql .= " WHERE `date` LIKE '%" . $order_date . "%'";
            } else {
                $add_sql .= " AND `date` LIKE '%" . $order_date . "%'";
            }
        }

        if($order_status != "") {
            $add_sql .= " HAVING `status` = '" . $order_status . "'";
        }

        if($customer_name != "") {
            if($order_status == "") {
                $add_sql .= " HAVING `customer` LIKE '%" . $customer_name . "%'";
            } else {
                $add_sql .= " AND `customer` LIKE '%" . $customer_name . "%'";
            }
        }

        if($add_sql == "") {
            $this->context->smarty->assign(array(
                'data' => $params,
                'order_ref' => "",
                'order_date' => "",
                'order_status' => "",
                'customer_name' => "",
                'reset_flag' => false,
            ));
            $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . '/views/templates/admin/orderlist.tpl');
        } else {
            $sql = "SELECT o.id_order, CONCAT(LEFT(cu.`firstname`, 1), ' ', cu.`lastname`) AS `customer`, o.reference, o.current_state AS `status`, o.date_add AS DATE FROM ps_orders o LEFT JOIN ps_customer cu ON o.id_customer = cu.id_customer";
            $sql .= $add_sql;
            $sql .= " ORDER BY o.id_order DESC LIMIT 50";

            $params = Db::getInstance()->executeS($sql);
            $this->context->smarty->assign(array(
                'data' => $params,
                'order_ref' => $order_ref,
                'order_date' => $order_date,
                'order_status' => $order_status,
                'customer_name' => $customer_name,
                'reset_flag' => true,
            ));
            $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . '/views/templates/admin/orderlist.tpl');
        }

        $this->ajaxRenderJson('success');
    }

    // Reset Order List
    public function displayAjaxResetOrderList() {
        $params = array();
        $this->context->smarty->assign(array(
            'data' => $params,
            'order_ref' => "",
            'order_date' => "",
            'order_status' => "",
            'customer_name' => "",
            'reset_flag' => false,
        ));
        $this->context->smarty->fetch(_PS_MODULE_DIR_.'atomicseller/views/templates/admin/orderlist.tpl');
        
        $this->ajaxRenderJson('success');
    }

    // Check Connection
    public function displayAjaxTestConnection() {
        $wToken = Tools::getValue('wToken');
        $wStorekey = Tools::getValue('wStorekey');

        Configuration::updateValue('WS_TOKEN', $wToken);
        Configuration::updateValue('WS_STOREKEY', $wStorekey);

        $result = $this->testConnection($wToken, $wStorekey, "KKHSHWEJR") == "" ? false : true;
        $this->ajaxRenderJson($result ? 'success' : 'error');
    }

    // Check Connection
    public function displayAjaxSaveEmailConf() {
        $eTitle = Tools::getValue('eTitle');
        $eContent = Tools::getValue('eContent');
        $result = false;

        if (!empty($eTitle) && !empty($eContent)) {
            $result = Configuration::updateValue('EMAIL_TITLE_MODEL', $eTitle)
                && Configuration::updateValue('EMAIL_CONTENT_MODEL', $eContent);
        }

        $this->ajaxRenderJson($result ? 'success' : 'error');
    }

    public function testConnection($wToken, $wSkey, $wOkey) {
        $url = "https://test.atomicseller.com/Api/Delivery/GetReturnLabel";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
           "Header":{
              "Token": $wToken
           },
           "Orders":[
              {
                 "OrderKEY": $wOkey,
                 "StoreKEY": $wSkey
              }
           ] 
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = json_encode(curl_exec($curl));
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $statusCode == 200 ? $resp : "";
    }
}
