<?php

/**
* @ Autor: Whilton Reis
* @ Data : 14/06/2016
* @ Remessa Sicredi Cnab400
*/

Class RemessaSicredi{
 
 private $codCedente   = '47295';// Codigo do Cedente
 private $cnpjCedente  = '20105220000197'; // Cnpj do Cedente
 private $setSequencia = '2';// Inicio da Sequëncia dos titulos 1- Para Header

	public function __construct($SetSacados){

	## REGISTRO HEADER
		$this->titulo = '0';// 01 carácter - Identificação do registro Header
		$this->titulo.= '1';// 01 carácter - Identificação do arquivo remessa 
		$this->titulo.= 'REMESSA';// 07 carácter - Literal remessa 
		$this->titulo.= '01';// 02 carácter - Código do serviço de cobrança 
		$this->titulo.= 'COBRANCA'.self::PreencherCaracteres('7','vazio'); // 15 carácter  - 'COBRANCA'= 08 e Brancos = 07
		$this->titulo.= $this->codCedente; // 05 carácter - Código do cedente e/ou conta c/ digito
		$this->titulo.= $this->cnpjCedente; // 14 carácter - CNPJ do cedente
		$this->titulo.= self::PreencherCaracteres('31','vazio'); // 31 carácter - em Branco
		$this->titulo.= '748'; // 03 carácter - Número do SICREDI 
		$this->titulo.= 'SICREDI'.self::PreencherCaracteres('8','vazio'); // 15 carácter - 'SICREDI'= 07 e Brancos = 08
		$this->titulo.= date('Ymd'); // 08 carácter - Data de gravação do arquivo 'AAAAMMDD'
		$this->titulo.= self::PreencherCaracteres('8','vazio'); // 08 carácter - em Branco
		$this->titulo.= self::NumeroDaRemessa();// 07 carácter - Número da remessa
		$this->titulo.= self::PreencherCaracteres('273','vazio'); // 273 carácter - em Branco
		$this->titulo.= '2.00'; // 04 carácter - Versão do sistema (o ponto deve ser colocado) 
		$this->titulo.= self::SequencialRemessa('1'); // 06 carácter - Número seqüencial do registro
		$this->titulo.= chr(13).chr(10); //Quebra de linha 

    ## REGISTRO DETALHE (OBRIGATORIO)
	    foreach($SetSacados as $this->sacado){
		$this->titulo.= '1';// 01 carácter - Identificação do registro
		$this->titulo.= 'A';// 01 carácter - Tipo de cobrança  “A” - SICREDI Com Registro 
		$this->titulo.= 'A';// 01 carácter - Tipo de carteira  “A” - Simples
		$this->titulo.= 'A';// 01 carácter - Tipo de Impressão “A” - Normal / “B” – Carnê  
		$this->titulo.= self::PreencherCaracteres('12','vazio'); // 12 carácter - em Branco
		$this->titulo.= 'A';// 01 carácter - Tipo de moeda  “A” – Real
		$this->titulo.= 'A';// 01 carácter - Tipo de desconto “A” – Valor / “B” – Percentual
		$this->titulo.= 'A';// 01 carácter - Tipo de juros “A” – Valor / “B” – Percentual
		$this->titulo.= self::PreencherCaracteres('28','vazio'); // 28 carácter - em Branco
		$this->titulo.= str_pad($this->sacado[0], 9, "0", STR_PAD_LEFT); // 09 carácter - Nosso número
		$this->titulo.= self::PreencherCaracteres('6','vazio'); // 06 carácter - em Branco
		$this->titulo.= date('Ymd'); // 06 carácter - Data da Instrução   "AAAAMMDD"
		$this->titulo.= '1'; // 01 carácter - Cadastro de titulo
		$this->titulo.= 'N'; // 01 carácter - Postagem do título / “S”- Para postar o título / “N” - Não postar e remeter para o Cedente
		$this->titulo.= self::PreencherCaracteres('1','vazio'); // 01 carácter - em Branco
		$this->titulo.= 'B'; // 01 carácter - Emissão do bloqueto - “A” – Impressão pelo SICREDI / “B” – Impressão pelo Cedente 
		$this->titulo.= '00'; // 02 carácter - Número da parcela do carnê
		$this->titulo.= '00';// 02 carácter - Número total de parcelas do carnê 		
		$this->titulo.= self::PreencherCaracteres('4','vazio'); // 04 carácter - em Branco		
		$this->titulo.= '0000000000'; // 10 carácter - Valor de desconto por dia de antecipação
		$this->titulo.= '0000'; // 04 carácter - % multa por pagamento em atraso 
		$this->titulo.= self::PreencherCaracteres('12','vazio'); // 12 carácter - em Branco
		$this->titulo.= '01'; // 02 carácter - Instrução / “01” - Cadastro de Títulos
		$this->titulo.= date('mdhis'); // 10 carácter - Instrução / “01” - Cadastro de Títulos / Usei Mês, Dia, Hora, Minutos e Segundos
		$this->titulo.= $this->sacado[1]; // 06 carácter - Data de vencimento "DDMMYY"
		$this->titulo.= str_pad($this->sacado[2], 13, "0", STR_PAD_LEFT); // 13 carácter - Valor principal do título 
		$this->titulo.= self::PreencherCaracteres('9','vazio'); // 09 carácter - em Branco
		$this->titulo.= 'A'; // 01 carácter - Espécie de documento / "A" DMI
		$this->titulo.= 'S'; // 01 carácter - Aceite do título  "S" Sim / "N" Não
		$this->titulo.= date('dmy'); // 06 carácter - Data de emissão
		$this->titulo.= '00'; // 02 carácter - Instrução de protesto automático - “00” -Não protestar automaticamente / “06” - Protestar automaticamente
		$this->titulo.= '05'; // 02 carácter - Número de dias p/protesto automático - Min 05 dias
		$this->titulo.= '0000000000200'; // 13 carácter - Valor/% de juros por dia de atraso - Definido 2,00 
		$this->titulo.= date('dmy'); // 06 carácter - Data limite p/concessão de desconto  "DDMMAA"
		$this->titulo.= '0000000000000'; // 13 carácter - Valor/% do desconto 
		$this->titulo.= self::PreencherCaracteres('13','zeros'); // 13 carácter - Zeros
		$this->titulo.= '0000000000000'; // 13 carácter - Valor do abatimento
		$this->titulo.= '1'; // 01 carácter - Tipo de pessoa do sacado: PF ou PJ - “1” - Pessoa Física / “2” - Pessoa Jurídica
		$this->titulo.= self::PreencherCaracteres('1','zeros'); // 01 carácter - Zeros
		$this->titulo.= str_pad($this->sacado[3], 14, "0", STR_PAD_LEFT); // 14 carácter - CPF/CNPJ do sacado 
		$this->titulo.= self::LimitCaracteres($this->sacado[4],'40'); // 40 carácter - Nome do sacado 
		$this->titulo.= self::LimitCaracteres($this->sacado[5],'40'); // 40 carácter - Endereço do sacado 
		$this->titulo.= '00000'; // 05 carácter - Código do sacado na cooperativa cedente
		$this->titulo.= '000000'; // 06 carácter - Código da praça do sacado 
		$this->titulo.= self::PreencherCaracteres('1','vazio'); // 01 carácter - em branco 
		$this->titulo.= $this->sacado[6]; // 08 carácter - CEP do sacado 
		$this->titulo.= '00000'; // 05 carácter - Código do Sacado junto ao cliente
		$this->titulo.= '00000000000000'; // 14 carácter - CPF/CNPJ do sacador avalista 
		$this->titulo.= self::LimitCaracteres(' ','41'); // 41 carácter - Nome do sacador avalista 
		$this->titulo.= self::SequencialRemessa($this->setSequencia++); // 06 carácter - Número seqüencial do registro   
		$this->titulo.= chr(13).chr(10); //Quebra de linha 		
	    }

    ## REGISTRO TRILER
		$this->titulo.= '9';// 01 carácter - Identificação do registro titulo
		$this->titulo.= '1';// 01 carácter - Identificação do arquivo remessa
		$this->titulo.= '748';// 03 carácter - Número do SICREDI
		$this->titulo.= $this->codCedente;// 05 carácter - Código do cedente
		$this->titulo.= self::PreencherCaracteres('384','vazio'); // 01 carácter - em branco 
		$this->titulo.= self::SequencialRemessa($this->setSequencia); // 06 carácter - Número seqüencial do registro 
		$this->titulo.= chr(13).chr(10); //Quebra de linha 
		
    ## GERAR ARQUIVO
	        $this->NomeArquivo = $this->codCedente.substr(date('yd'), 1).'.CRM'; // permissão 777 na pasta onde vai gerar o arquivo
	        $this->fp = fopen($this->NomeArquivo, "w+");
                $this->fp = fwrite(
                $this->fp, $this->titulo);
	        fclose($this->fp);	
	}

    ## Não Alterar a partir deste ponto
    private function NumeroDaRemessa(){
    	$this->sequencia  = 'NumRemessa';// permissão 777 na pasta onde vai gerar o arquivo
    	$this->abrir = fopen($this->sequencia, "a+");
    	$this->identificador = fread($this->abrir, filesize($this->sequencia));
    	$this->gravar = fopen($this->sequencia, "w");
    	if($this->identificador == '9999999'){
    	   $this->identificador = 1;
    	}
    	$this->grava = fwrite($this->gravar, $this->identificador+1);
        return str_pad($this->identificador, 7, "0", STR_PAD_LEFT);
    }

    private function PreencherCaracteres($SetInt,$SetTipo){
        if($SetTipo == 'zeros'){
          $this->caracter = '';
	        for($i = 1; $i <= $SetInt; $i++){
	          $this->caracter .= '0';
	        }
        }elseif($SetTipo == 'vazio'){
        $this->caracter = '';
	        for($i = 1; $i <= $SetInt; $i++){
	          $this->caracter .= ' ';
	        }
        }
        return $this->caracter;
    }

    private function SequencialRemessa($i){
        if($i < 10){
	      return self::Zeros('0','5').$i;
	  }elseif($i > 10 && $i < 100){
	      return self::Zeros('0','4').$i;
	  }elseif($i > 100 && $i < 1000){
	       return self::Zeros('0','3').$i;
	  }elseif($i > 1000 && $i < 10000){
	       return self::Zeros('0','2').$i;
	  }elseif($i > 10000 && $i < 100000){
	return self::Zeros('0','1').$i;
	}
    }

    private function Zeros($SetMin,$SetMax){
	$this->conta = ($SetMax - strlen($SetMin));
	$this->zeros = '';
	    for($i = 0; $i < $this->conta; $i++){
		$this->zeros .= '0';
             }
        return $this->zeros.$SetMin;
    }

    private function LimitCaracteres($SetPalavra,$SetLimite){
	    if(strlen($SetPalavra) >= $SetLimite){
	        $this->var = substr($SetPalavra, 0,$SetLimite);
	    }else{
	        $max = (int)($SetLimite-strlen($SetPalavra));
	        $this->var = $SetPalavra.self::PreencherCaracteres($max,'vazio');
	    }
       return $this->var;
    }
	
}
## LEGENDA
//0 - Nosso Numero
//1 - Data Vencimento
//2 - Valor do Titulo
//3 - Cpf ou Cnpj
//4 - Nome
//5 - Endereço
//6 - Cep

### DADOS DOS CLIENTES PARA TESTE
$GetTitulo[] = array('1','010816','200','3829504969','JOAO NINGUEM DA SILVA','R. JORGIOR DE ARMANI, 172','86083310');
$GetTitulo[] = array('2','020816','300','3829504969','MARIA DA SILVA NASCIM','R. JORGIOR DE ARMANI, 145','86083310');
$GetTitulo[] = array('3','030816','400','3829504969','ABREU DA SILVA JUNIOR','R. JORGIOR DE ARMANI, 167','86083310');

new RemessaSicredi($GetTitulo);

?>
