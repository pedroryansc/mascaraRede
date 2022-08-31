<!DOCTYPE html>
<?php
    $ip = isset($_POST["ip"]) ? $_POST["ip"] : 0;
    $mask = isset($_POST["mask"]) ? $_POST["mask"] : 0;
    
    function bin2ip($bin){ 
        return long2ip(base_convert($bin, 2, 10));
    }
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de endereços de rede</title>
    <style>
        td{
            font-family: "Courier New";
        }
    </style>
</head>
<body>
    <br>
    <form method="post">
        Insira um endereço IP: <input type="text" name="ip" value="<?php if(isset($_POST["ip"])) echo $ip; ?>"><br>
        <br>
        Escolha um endereço de Máscara de Sub-rede: <select name="mask">
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
                    $maskOption = $maskOptionDec."/".$i;
            ?>
                <option value="<?php echo $maskOption; ?>" <?php if($maskOption == $mask) echo "selected"; ?>> <?php echo $maskOption; ?> </option>
            <?php
                }
            ?>
        </select><br>
        <br>
        <button type="submit">Enviar dados</button>
    </form>
    <br>
    <?php
        if(isset($_POST["mask"])){
            require_once("MascaraRede.class.php");
            $maskRede = new MascaraRede($ip, $mask);
            echo $maskRede;
        }
    ?>
</body>
</html>