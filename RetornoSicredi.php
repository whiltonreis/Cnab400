<?php
/**
* @ Autor: Whilton Reis
* @ Data : 14/06/2016
* @ Remessa Sicredi Cnab400
*/

Class RetornoSicredi{

	private $taxaDoBoleto = '1,89';

	public function __construct($SetArquivo){
		// Caminho do arquivo
		$retorno = file($SetArquivo);
		//Conta as linhas do arquivo
		$vetores = count($retorno);
		//Informações da carteira
		$vetor[0] = substr($retorno[0],26, -371);
		//Titulos
		for($i = 1;$i < $vetores-1;$i++){
		    //Numero do Boleto
		    $vetor[1] = intval(substr($retorno[$i],50, -347));
		    //Data de Pagamento
		    $vetor[2] = substr($retorno[$i],328, -9);
		    //Valor do Boleto
		    $vetor[3] = intval(substr($retorno[$i], 152, -235));
		    //Valor Pago
		    $vetor[4] = intval(substr($retorno[$i], 253, -136));
            
                    //Cria a variavel para guardar o resultado
		    $html = '';

		    //Taxa do boleto sem pontos e virgula
		    $taxa = self::limpaCaracteres($this->taxaDoBoleto);

		    //Processamento dos dados         
		    if($vetor[4] > 0 && $vetor[4] != $taxa)
		    {
		        $html.= $vetor[1]                     . '<br>'; //Numero do Boleto
		        $html.= self::formataData($vetor[2])  . '<br>'; //Data de Pagamento
		        $html.= self::formataValor($vetor[3]) . '<br>'; //Valor do Boleto
		        $html.= self::formataValor($vetor[4]) . '<hr>'; //Valor Pago
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

new RetornoSicredi('472950809.CRT');
