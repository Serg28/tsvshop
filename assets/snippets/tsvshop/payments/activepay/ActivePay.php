<?php
class ActivePay {
        var $method = "GET", $url_domain = "activepay.ru", $url_uri = "/merchant_pages/create/", $secret_key, $merchant_contract;

        private function check_var($flag = False) {
		if (!$flag) {
                    if ($this->method == "GET") die("You must set method to POST!\n");
                    if ($this->url_domain == "activepay.ru") die("You must set url_domain of own server\n");
                    if ($this->url_uri == "/merchant_pages/create/") die("You must set url_uri of own server\n");
                    if (!$this->secret_key) die("You must set secret_key\n");
                } else {
                    if (!$this->merchant_contract) die("You must set merchant_contract\n");
                    if (!$this->secret_key) die("You must set secret_key\n");
                }
        }

        private function build_query_string($data) {
                $query_string = "";
                ksort($data);
                foreach ($data as $item => $value) {
                 if ($query_string != "") {
                   $query_string .= "&";
                 }
                 $query_string .= rawurlencode($item)."=".rawurlencode($value);
                }
                return $query_string;
        }

        private function sign($data) {
                $url = "http://$this->url_domain$this->url_uri";
                $query_string = $this->build_query_string($data);
                $string_to_sign = "$this->method\n$this->url_domain\n$this->url_uri\n$query_string";
                $hmac_sha1_hash = hash_hmac("sha1", $string_to_sign, $this->secret_key, true);
                return urlencode(base64_encode($hmac_sha1_hash));
        }

	public function check_signature($data) {
                $this->check_var();
                $signature = $data["signature"];
                unset($data["signature"]);
                $signature2 = $this->sign($data);
                return urlencode($signature) == $signature2;
        }

        public function build_merchant_pages_url($data) {
                $this->check_var(true);
                $data["merchant_contract"] = $this->merchant_contract;
                $signature = $this->sign($data);
                $query_string = $this->build_query_string($data);
                return "http://$this->url_domain$this->url_uri?$query_string&signature=$signature";
        }
}
?>