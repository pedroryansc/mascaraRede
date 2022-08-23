<!DOCTYPE html>
<?php
    $ip = isset($_POST["ip"]) ? $_POST["ip"] : 0;
    $mask = isset($_POST["mask"]) ? $_POST["mask"] : 0;

    function ip2bin($ip) 
    { 
        if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) 
            //return sprintf("%032s",base_convert(ip2long($ip),10,2)); 
            return base_convert(ip2long($ip),10,2); 
        if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) 
            return false; 
        if(($ip_n = inet_pton($ip)) === false) return false; 
        $bits = 15;  
        $ipbin = '';
        while ($bits >= 0) 
        { 
            $bin = sprintf("%08b",(ord($ip_n[$bits]))); 
            $ipbin = $bin.$ipbin; 
            $bits--; 
        } 
        return $ipbin;
    }
    function bin2ip($bin) 
    { 
        if(strlen($bin) <= 32)  
            return long2ip(base_convert($bin,2,10)); 
        if(strlen($bin) != 128) 
            return false; 
        $pad = 128 - strlen($bin); 
        for ($i = 1; $i <= $pad; $i++) 
        { 
            $bin = "0".$bin; 
        } 
        $bits = 0; 
        $ipv6 = '';
        while ($bits <= 7) 
        { 
            $bin_part = substr($bin,($bits*16),16); 
            $ipv6 .= dechex(bindec($bin_part)).":"; 
            $bits++; 
        } 
        return inet_ntop(inet_pton(substr($ipv6,0,-1))); 
    }

    echo "$ip e $mask <br>";
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Máscara de Rede</title>
</head>
<body>
    <br>
    <a href="https://tutorialspots.com/php-how-to-convert-ip-address-to-binary-string-or-hex-string-3561.html" target="_blank">
        Funções
    </a>
    <br><br>
    <form method="post">
        Insira um Endereço IP:
        <input type="text" name="ip">
        <br><br>
        Escolha um Endereço de Máscara de Rede: <select name="mask">
            <option value="1">128.0.0.0/1</option>
            <option value="2">192.0.0.0/2</option>
            <option value="3">224.0.0.0/3</option>
            <option value="4">240.0.0.0/4</option>
            <option value="5">248.0.0.0/5</option>
            <option value="6">252.0.0.0/6</option>
            <option value="7">254.0.0.0/7</option>
            <option value="8">255.0.0.0/8</option>
            <option value="9">255.128.0.0/9</option>
            <option value="10">255.192.0.0/10</option>
            <option value="11">255.224.0.0/11</option>
            <option value="12">255.240.0.0/12</option>
            <option value="13">255.248.0.0/13</option>
            <option value="14">255.252.0.0/14</option>
            <option value="15">255.254.0.0/15</option>
            <option value="16">255.255.0.0/16</option>
            <option value="17">255.255.128.0/17</option>
            <option value="18">255.255.192.0/18</option>
            <option value="19">255.255.224.0/19</option>
            <option value="20">255.255.240.0/20</option>
            <option value="21">255.255.248.0/21</option>
            <option value="22">255.255.252.0/22</option>
            <option value="23">255.255.254.0/23</option>
            <option value="24">255.255.255.0/24</option>
            <option value="25">255.255.255.128/25</option>
            <option value="26">255.255.255.192/26</option>
            <option value="27">255.255.255.224/27</option>
            <option value="28">255.255.255.240/28</option>
            <option value="29">255.255.255.248/29</option>
            <option value="30">255.255.255.252/30</option>
        </select>
        <br><br>
        <button type="submit">Enviar dados</button>
    </form>
    <br>
    <?php
        if(isset($_POST["mask"])){
            $ipArray = explode(".", $ip);
            echo "<b>Endereço IP (Array): </b>";
            var_dump($ipArray);

            $ipbin = ip2bin($ip);
            $ipbinArray = explode(1, $ipbin);
            echo "<br><br>
            <b>Endereço IP em Binário (Array - 0): </b>";
            var_dump($ipbinArray);
            echo "<br>".$ipbinArray[0];

            echo "<hr>
            <table>
                <tr>
                    <th>Endereço IP</th>
                    <td>$ip</td>
                </tr>
                <tr>
                    <th>Bits</th>
                    <td>$mask</td>
                </tr>
                <tr>
                    <th>Endereço IP (Binário)</th>
                    <td>".$ipbin."</td>
                </tr>
            </table>
            <hr>";
            
            echo "<b> Verificação para o Endereço de Rede: </b>";
            for($i = 1; $i <= 30; $i ++){
                if($i <= $mask)
                    echo "1";
                else
                    echo "0";
            }
            
            $maskExemplo = "255.192.0.0";
            $maskBin = ip2bin($maskExemplo);
            echo "<hr>
            <b> Máscara em Binário (Exemplo - ".$maskExemplo."): </b> ".$maskBin."<br><br>";

            $maskBinArray = explode(0, $maskBin);
            echo "<b>Máscara em Binário (Array - 1): </b>";
            var_dump($maskBinArray);
            echo "<br><br> <b> Quantidade de bits 1 na Máscara: </b>".strlen($maskBinArray[0]);

            $maskBinArray = explode(1, $maskBin);
            echo "<hr> <b>Máscara em Binário (Array - 0): </b>";
            var_dump($maskBinArray);
            echo "<br><br>";
            for($i = 0; $i < count($maskBinArray); $i ++){
                if($maskBinArray[$i] == "")
                    echo "1";
                else
                    for($i2 = 1; $i < strlen($maskBinArray[$i]); $i ++){
                        array_push ($maskBinArray, "0");
                    }
            }
            echo bin2ip($maskBin);
        }
    ?>
</body>
</html>