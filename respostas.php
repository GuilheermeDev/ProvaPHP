<?php
    $nome = $_POST['nome'];
    $data = $_POST['vdata'];
    // 0,4 ponto
    function higieniza_string($string){
        $string = trim($string);
		$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
		return $string;
    }

    // 0,2 ponto
    function retorna_nome($nome){
		return $nome;
    }
    
    // 0,2 ponto
    function retorna_data($data){
        $explode = explode("-", $data);
		return $explode[1] . "-" .  $explode[0];
    }
    
    // 0,2 ponto
    function retorna_tipo(){
        if($tipo = $_POST['tppessoa'] === "F"){
            return "Pessoa Física";
        }else{
            return "Pessoa Jurídica";
        }
    }
    
    // 0,2 ponto
    function retorna_documento(){
        $documento = preg_replace("/[^0-9?!]/",'',$_POST["cpfcnpj"]);
        if(!valida_documento()){
            $documento .= " documento inválido";
		}
        return $documento;
    }
    
    // 0,2 ponto
    function valida_documento(){
        if($_POST["tppessoa"] == "F"){
			return valida_cpf();
		}
		return valida_cnpj();
    }
    
    
    // 0,3 ponto
    function valida_cpf(){
        $documento = preg_replace("/[^0-9?!]/",'',$_POST["cpfcnpj"]);
		if (strlen($documento) != 11) {return false;}
		if($documento == "00000000000"){return false;}
		if($documento == "11111111111"){return false;}
		if($documento == "22222222222"){return false;}
		if($documento == "33333333333"){return false;}
		if($documento == "44444444444"){return false;}
		if($documento == "55555555555"){return false;}
		if($documento == "66666666666"){return false;}
		if($documento == "77777777777"){return false;}
		if($documento == "88888888888"){return false;}
		if($documento == "99999999999"){return false;}
		$result = 0;
		$primeiroDigito = 0;
		$i = 10;
		$y =0;
		while($i > 1){
			$result += ($i * $documento[$y]);
			$i--;
			$y++;
		}
		$primeiroDigito =(int)($result % 11);//resto divisao
		if($primeiroDigito <=2 ){
			$primeiroDigito = 0;
		}else{
			$primeiroDigito = 11 -$primeiroDigito ;
		}
		
		$result = 0;
		$segundoDigito = 0;
		$i = 11;
		$y =0;
		while($i > 2){
			$result += ($i * $documento[$y]);
			$i--;
			$y++;
		}
		$result += (2 * $primeiroDigito);
		
		$segundoDigito =(int)($result % 11);//resto divisao
		if($segundoDigito <=2 ){
			$segundoDigito = 0;
		}else{
			$segundoDigito = 11 -$segundoDigito ;
		}
		$ultimosDoisDigitosCpf = substr($documento,-2);
		if($ultimosDoisDigitosCpf == ($primeiroDigito.$segundoDigito)){
			return true;
		}
       return false;
    }
    
    // 0,3 ponto
    function valida_cnpj(){
        $documento = preg_replace("/[^0-9?!]/",'',$_POST["cpfcnpj"]);
        if (strlen($documento) != 14) {return false;}
        if($documento == "00000000000000"){return false;}
        if($documento == "11111111111111"){return false;}
        if($documento == "22222222222222"){return false;}
        if($documento == "33333333333333"){return false;}
        if($documento == "44444444444444"){return false;}
        if($documento == "55555555555555"){return false;}
        if($documento == "66666666666666"){return false;}
        if($documento == "77777777777777"){return false;}
        if($documento == "88888888888888"){return false;}
        if($documento == "99999999999999"){return false;}
        $arrayTES = array(5,4,3,2,9,8,7,6,5,4,3,2);
        $i =0;
        $result =0;
        while($i < 12){
            $result += ($documento[$i] * $arrayTES[$i]);
            $i++;
        }
        $primeiroDigito =(int)($result % 11);//resto divisao
        if($primeiroDigito <=2 ){
            $primeiroDigito = 0;
        }else{
            $primeiroDigito = 11 -$primeiroDigito ;
        }
        $arrayTES = array(6,5,4,3,2,9,8,7,6,5,4,3);
        $i =0;
        $result =0;
        while($i < 12){
            $result += ($documento[$i] * $arrayTES[$i]);
            $i++;
        }
        $result += ($primeiroDigito * 2);
        $segundoDigito =(int)($result % 11);//resto divisao
        if($segundoDigito <=2 ){
            $segundoDigito = 0;
        }else{
            $segundoDigito = 11 -$segundoDigito ;
        }
        $ultimosDoisDigitosCnpj = substr($documento,-2);
        if($ultimosDoisDigitosCnpj == ($primeiroDigito.$segundoDigito)){
            return true;
        }
        return false;
    }
    
    // 0,3 ponto
    function valida_site(){
        if(!filter_var($_POST["site"], FILTER_VALIDATE_URL)){
            return false;
        }
        return true;
    }
    
    // 0,2 ponto
    function retorna_site(){
        $site =higieniza_string($_POST["site"]);
        if(!valida_site()){
            $site .= " SITE INVÁLIDO";
        }
        return $site;
    }
    
    // 0,3 ponto
    function valida_email(){
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    
    // 0,2 ponto
    function retorna_email(){
        $email =higieniza_string($_POST["email"]); // precisa sanitizar emails
        if(!valida_email()){
            $email .= " EMAIL INVÁLIDO";
        }
        return $email;
    }
    
    
    // 0,2 ponto
    function retorna_tipo_reclamacao(){
        if($reclamacao = $_POST['lista1'] == "hard"){
            return "Defeito no hardware";
        }else if ($reclamacao = $_POST['lista1'] == "soft"){
            return "Defeito no software";
        }else if ($reclamacao = $_POST['lista1'] == "naoid"){
            return "Defeito não identificado";
        }
    }

    // 0,3 ponto
    function retorna_estado(){
        $cep = preg_replace("/[^0-9?!]/",'',$_POST["cep"]);
        if(strlen($cep) != 8){
            return "CEP INVALIDO!!";
        }
        $check = curl_init();
        curl_setopt($check, CURLOPT_URL, "https://viacep.com.br/ws/{$cep}/json/");
        curl_setopt ($check, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0");
        curl_setopt ($check, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt ($check, CURLOPT_TIMEOUT, 15);
        curl_setopt ($check, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt ($check, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($check);
        $resultJ = @json_decode($result,true);
        if(empty($resultJ["uf"])){
            return "CEP Não Existente";
        }
        curl_close($check);
        return $resultJ["uf"];
    }
    
    // 0,5 ponto
    function retorna_quantidade(){
        $count = 0;
        $arrayQtde = explode(" ",$_POST['mensagem']);
        foreach($arrayQtde as $qtd){
            $count++;
        }
        return $count;
    }
    
    // 0,5 ponto
    function retorna_positivas(){

        $positivas = array('bom','bons','boa','boas','excelente','ótimo');
        $positivas = array_flip($positivas);
        $count = 0;
        $msg = explode(" ",$_POST["mensagem"]);
        foreach($msg as $palavra){
            $palavra = strtolower($palavra);
            if(isset($positivas[$palavra])){
                $count++;
            }
        }
        return $count;
    }
    
    // 0,5 ponto
    function retorna_negativas(){

        $negativas = array('ruim','ruins','péssimo','horrível');
        $negativas = array_flip($negativas);
        $count = 0;
        $msg = explode(" ",$_POST["mensagem"]);
        foreach($msg as $palavra){
            $palavra = strtolower($palavra);
            if(isset($negativas[$palavra])){
                $count++;
            }
        }
        return $count;
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Respostas</title>
<style>
body {
  background-color: silver;
  text-align: left;
  color: black;
  font-family: Arial, Helvetica, sans-serif;
}
</style>
</head>
<body>

<h1>Avaliação de PHP</h1>
<h2><b>Questões resolvidas</b></h2>
<?php
    print_r($_POST);
?>
<h2>Olá <?php echo retorna_nome($nome);?></h2>
<p><b>Data da reclamação: <?php echo retorna_data($data);?></b></p>
<p><b>Tipo de documento: <?php echo retorna_tipo();?></b></p>
<p><b>Dados do reclamante: <?php echo retorna_documento() . " - " . retorna_email();?></b></p>
<p><b>Tipo de reclamação: <?php echo retorna_tipo_reclamacao();?></b></p>
<p><b>Estado de origem: <?php echo retorna_estado();?></b></p>
<p><b>Site da compra: <?php echo retorna_site();?></b></p>
<p><b>Quantidade de palavras postadas: <?php echo retorna_quantidade();?></b></p>
<p><b>Quantidade de palavras positivas: <?php echo retorna_positivas();?></b></p>
<p><b>Quantidade de palavras negativas: <?php echo retorna_negativas();?></b></p>
<p>&nbsp;</p>

</body>
</html>