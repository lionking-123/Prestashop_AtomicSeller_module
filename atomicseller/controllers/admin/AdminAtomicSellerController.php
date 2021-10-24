<?php

class AdminBlockListingController extends ModuleAdminController {

    // Ajax response render
    protected function ajaxRenderJson($content) {
        header('Content-Type: application/json');
        $this->ajaxRender(json_encode($content));
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
        $statusCode = curl_getinfo($curl, CURLINFO_HTP_CODE);
        curl_close($curl);

        return $statusCode == 200 ? $resp : "";
    }
}
