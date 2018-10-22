<?php
/**
* @ Autor: Whilton Reis
* @ Data : 14/06/2016
* @ Remessa Sicredi Cnab400
*/
Class RetornoSicredi{
	private $taxaDoBoleto = '1,89';
	public function __construct($SetArquivo){
		//Caminho do arquivo
		$retorno = file($SetArquivo);
		//Conta as linhas do arquivo
		$linhas = count($retorno);
		//Informações da carteira
		$linha[0] = substr($retorno[0],26, -371);
		//Titulos
		for($i = 1;$i < $linhas-1;$i++){
		    //Numero do Boleto
		    $linha[1] = intval(substr($retorno[$i],50, -347));
		    //Data de Pagamento
		    $linha[2] = substr($retorno[$i],328, -9);
		    //Valor do Boleto
		    $linha[3] = intval(substr($retorno[$i], 152, -235));
		    //Valor Pago
		    $linha[4] = intval(substr($retorno[$i], 253, -136));            
                    //Cria a variavel para guardar o resultado
		    $html = '';
		    //Taxa do boleto sem pontos e virgula
		    $taxa = self::limpaCaracteres($this->taxaDoBoleto);
		    //Processamento dos dados         
		    if($linha[4] > 0 && $linha[4] != $taxa){
			//Numero do Boleto
		        $html.= $linha[1]                     . '<br>';
			//Data de Pagamento
		        $html.= self::formataData($linha[2])  . '<br>';
			//Valor do Boleto
		        $html.= self::formataValor($linha[3]) . '<br>';
			//Valor Pago
		        $html.= self::formataValor($linha[4]) . '<hr>';
		    }            
            //Imprime o resultado
            print_r($html);
        }
    }
	
    public function formataValor($set){
        //Formata valor em real
        $set = self::limpaCaracteres($set);
        $set = ltrim($set, "0");
        $set = $set / 100;
        $set = number_format($set, 2, ',', '.');
        return $set;
    }
	
    public function limpaCaracteres($set){
        //Limpa caracteres especiais
        $setor = str_replace('.','',$set);
        $setor = str_replace(',','',$setor);
        return $setor;
    }
	
    public function formataData($set){
    	return date('d/m/Y',strtotime($set));
    }
}
## EXEMPLO DE USO
new RetornoSicredi('472950809.CRT');
