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
        // $this->ajax = true;
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

        if($order_date != "") {
            if($order_status == "" && $customer_name == "") {
                $add_sql .= " HAVING DATE(`date`) = '" . $order_date . "'";
            } else {
                $add_sql .= " AND DATE(`date`) = '" . $order_date . "'";
            }
        }

        if($add_sql != "") {
            $sql = "SELECT o.id_order, CONCAT(LEFT(cu.`firstname`, 1), ' ', cu.`lastname`) AS `customer`, o.reference, o.current_state AS `status`, o.date_add AS `date` FROM ps_orders o LEFT JOIN ps_customer cu ON o.id_customer = cu.id_customer";
            $sql .= $add_sql;
            $sql .= " ORDER BY o.id_order DESC LIMIT 50";

            $params = Db::getInstance()->executeS($sql);
        }

        $this->ajaxRenderJson(array(
            'data' => $params,
            'order_ref' => "",
            'order_date' => "",
            'order_status' => "",
            'customer_name' => "",
            'reset_flag' => false,
        ));
    }

    // Check Connection
    public function displayAjaxTestConnection() {
        $wToken = Tools::getValue('wToken');
        $wStorekey = Tools::getValue('wStorekey');

        Configuration::updateValue('WS_TOKEN', $wToken);
        Configuration::updateValue('WS_STOREKEY', $wStorekey);

        $res = $this->testConnection($wToken, $wStorekey, "KKHSHWEJR");
        $this->ajaxRenderJson($res['Header']['StatusCode'] == 200 ? 'success' : 'error');
    }

    // Get Return Label from Web service
    public function displayAjaxGetReturnLabel() {
        $wToken = Configuration::get('WS_TOKEN');
        $wStorekey = Configuration::get('WS_STOREKEY');
        $wOKey = Tools::getValue('orderKey');

        $res = $this->testConnection($wToken, $wStorekey, $wOkey);
        $this->ajaxRenderJson($res);
    }

    // Check Email Settings
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

    // Email Sending
    public function displayAjaxEmailSendToCustomer() {
        $eCont = Tools::getValue('eContent');
        $ref = Tools::getValue('order_ref');

        Mail::Send(
            (int)(Configuration::get('PS_LANG_DEFAULT')),
            'contact',
            'Return label regarding order ' . $ref,
            array(
                '{email}' => 'alexeygrigorev91@gmail.com',
                '{message}' => 'Dear customer,

                ' . $eCont . '.
                
                Kind regards
                The customer service
                '
            ),
            'Pershin.alexey@list.ru',
            'Pershin Alexey',
            'alexeygrigrev91@gmail.com',
            NULL
        );

        $this->ajaxRenderJson('success');
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
              "Token": "$wToken"
           },
           "Orders":[
              {
                 "OrderKEY": "$wOkey",
                 "StoreKEY": "$wSkey"
              }
           ] 
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($resp, true);
        return $res;
    }
}
