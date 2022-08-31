<!DOCTYPE html>
<?php
    // Endereço IP
    $ip = isset($_POST["ip"]) ? $_POST["ip"] : 0;

    // Quantidade de bits da Máscara
    $mask = isset($_POST["mask"]) ? $_POST["mask"] : 0;

    // Conversão de Endereço IP para binário
    function ip2bin($ip){ 
        return base_convert(ip2long($ip),10,2);
    }

    // Conversão de binário para Endereço IP
    function bin2ip($bin){ 
        return long2ip(base_convert($bin,2,10));
    }
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
    <form method="post">
        Insira um Endereço IP:
        <input type="text" name="ip">
        <br><br>
        Escolha um Endereço de Máscara de Sub-rede: <select name="mask">
            <?php   
                for($i = 1; $i <= 30; $i ++){
                    $maskOptionBin = "";
                    for($i2 = 1; $i2 <= 32; $i2 ++){
                        if($i2 <= $i)
                            $maskOptionBin .= "1";
                        else
                            $maskOptionBin .= "0";
                    }
                    $maskOptionDec = bin2ip($maskOptionBin);
                    echo "<option value=".$maskOptionDec."/".$i.">".$maskOptionDec."/".$i."</option>";
                }
            ?>
        </select>
        <br><br>
        <button type="submit">Enviar dados</button>
    </form>
    <br>
    <?php
        if(isset($_POST["mask"])){
            $maskAndBits = explode("/", $mask);

            // Endereços inseridos
            echo "$ip e $mask <br>";

            // Endereço IP em binário
            $ipbin = ip2bin($ip);

            // Endereço de Rede
            $rede = long2ip((ip2long($ip)) & (ip2long($maskAndBits[0])));

            // Primeiro IP útil
            $primeiroIp = long2ip(ip2long($rede) | 1);

            // Último IP útil
            $ultimoIp = long2ip(ip2long($rede) | ((~(ip2long($maskAndBits[0]))) - 1));

            // Endereço de Broadcast
            $broadcast = long2ip(ip2long($rede) | (~(ip2long($maskAndBits[0]))));
    ?>
    <p>Decimal:</p>
    <table>
        <tr>
            <th>Endereço IP</th>
            <td><?php echo $ip; ?></td>
        </tr>
        <tr>
            <th>Máscara de sub-rede</th>
            <td><?php echo $mask; ?></td>
        </tr>
        <tr>
            <th>Endereço de rede</th>
            <td><?php echo $rede; ?></td>
        </tr>
        <tr>
            <th>Primeiro IP útil</th>
            <td><?php echo $primeiroIp; ?></td>
        </tr>
        <tr>
            <th>Último IP útil</th>
            <td><?php echo $ultimoIp; ?></td>
        </tr>
        <tr>
            <th>Endereço de Broadcast</th>
            <td><?php echo $broadcast; ?></td>
        </tr>
    </table>
    <?php
        }
    ?>
</body>
</html>