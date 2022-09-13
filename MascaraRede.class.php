<?php
    class MascaraRede{
        private $ip;
        private $mask;
        private $rede;
        private $primeiroIp;
        private $ultimoIp;
        private $broadcast;
        public function __construct($ip, $mask){
            $this->setIp($ip);
            $this->setMask($mask);
            $this->setRede();
            $this->setPrimeiroIp();
            $this->setUltimoIp();
            $this->setBroadcast();
        }

        public function setIp($ip){
            if($ip <> "")
                $this->ip = $ip;
            else
                throw new Exception("Insira um endereço IP, por favor");
        }
        public function setMask($mask){
            if($mask <> "")
                $this->mask = $mask;
            else
                throw new Exception("Insira um endereço de máscara de sub-rede, por favor");
        }
        public function setRede(){
            $maskAndBits = $this->separaMaskBits();
            $this->rede = long2ip((ip2long($this->getIp())) & (ip2long($maskAndBits[0])));
        }
        public function setPrimeiroIp(){
            $this->primeiroIp = long2ip(ip2long($this->getRede()) | 1);
        }
        public function setUltimoIp(){
            $maskAndBits = $this->separaMaskBits();
            $this->ultimoIp = long2ip(ip2long($this->getRede()) | ((~(ip2long($maskAndBits[0]))) - 1));
        }
        public function setBroadcast(){
            $maskAndBits = $this->separaMaskBits();
            $this->broadcast = long2ip(ip2long($this->getRede()) | (~(ip2long($maskAndBits[0]))));
        }

        public function getIp(){ return $this->ip; }
        public function getMask(){ return $this->mask; }
        public function getRede(){ return $this->rede; }
        public function getPrimeiroIp(){ return $this->primeiroIp; }
        public function getUltimoIp(){ return $this->ultimoIp; }
        public function getBroadcast(){ return $this->broadcast; }

        public function separaMaskBits(){
            return explode("/", $this->getMask());
        }

        public function ip2bin($end){ 
            $ipBin = base_convert(ip2long($end), 10, 2);
            return implode(".", str_split($ipBin, 8));
        }

        public function __toString(){
            return "<p><b>Decimal:</b></p>
            <table border='1'>
                <tr>
                    <th>Endereço IP</th>
                    <td>".$this->getIp()."</td>
                </tr>
                <tr>
                    <th>Máscara de sub-rede</th>
                    <td>".$this->getMask()."</td>
                </tr>
                <tr>
                    <th>Endereço de rede</th>
                    <td>".$this->getRede()."</td>
                </tr>
                <tr>
                    <th>Primeiro IP útil</th>
                    <td>".$this->getPrimeiroIp()."</td>
                </tr>
                <tr>
                    <th>Último IP útil</th>
                    <td>".$this->getUltimoIp()."</td>
                </tr>
                <tr>
                    <th>Endereço de Broadcast</th>
                    <td>".$this->getBroadcast()."</td>
                </tr>
            </table>
            <br>
            <p><b>Binário:</b></p>
            <table border='1'>
                <tr>
                    <th>Endereço IP</th>
                    <td>".$this->ip2bin($this->getIp())."</td>
                </tr>
                <tr>
                    <th>Máscara de sub-rede</th>
                    <td>".$this->ip2bin($this->separaMaskBits($this->getMask())[0])."/".$this->separaMaskBits($this->getMask())[1]."</td>
                </tr>
                <tr>
                    <th>Endereço de rede</th>
                    <td>".$this->ip2bin($this->getRede())."</td>
                </tr>
                <tr>
                    <th>Primeiro IP útil</th>
                    <td>".$this->ip2bin($this->getPrimeiroIp())."</td>
                </tr>
                <tr>
                    <th>Último IP útil</th>
                    <td>".$this->ip2bin($this->getUltimoIp())."</td>
                </tr>
                <tr>
                    <th>Endereço de Broadcast</th>
                    <td>".$this->ip2bin($this->getBroadcast())."</td>
                </tr>
            </table>";
        }
    }
?>