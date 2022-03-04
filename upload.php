<?php
require("database.php");

$file = $_FILES['file'];
const CNPJ_EMITENTE = "09066241000884";

if ($file['type'] === "text/xml") {
    copy($file['tmp_name'], 'cache' . DIRECTORY_SEPARATOR . $file['name']);
    $xml = simplexml_load_file(__DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . $file['name']);

    if ($xml->NFe) {
        $xml = $xml->NFe;
    }

    $emitente_cnpj = $xml->infNFe->emit->CNPJ;
    $destinatario = $xml->infNFe->dest;

    if ($emitente_cnpj == CNPJ_EMITENTE) {
        $num_nota_fiscal = filter_var($xml->infNFe->ide->cNF, FILTER_SANITIZE_STRING);
        $dt_emissao_nota_fiscal = filter_var($xml->infNFe->ide->dhEmi, FILTER_SANITIZE_STRING);
        $vr_total_nota_fiscal = filter_var($xml->infNFe->total->ICMSTot->vNF, FILTER_SANITIZE_STRING);

        $dest_razao_social = filter_var($destinatario->xNome, FILTER_SANITIZE_STRING);
        if (isset($destinatario->CNPJ)) {
            $dest_cnpj = filter_var($destinatario->CNPJ, FILTER_SANITIZE_STRING);
        } else {
            $dest_cnpj = filter_var($destinatario->CPF, FILTER_SANITIZE_STRING);
        }
        $dest_logradouro = filter_var($destinatario->enderDest->xLgr, FILTER_SANITIZE_STRING);
        $dest_numero = filter_var($destinatario->enderDest->nro, FILTER_SANITIZE_STRING);
        $dest_complemento = filter_var($destinatario->enderDest->xCpl, FILTER_SANITIZE_STRING);
        $dest_bairro = filter_var($destinatario->enderDest->xBairro, FILTER_SANITIZE_STRING);
        $dest_municipio = filter_var($destinatario->enderDest->xMun, FILTER_SANITIZE_STRING);
        $dest_uf = filter_var($destinatario->enderDest->UF, FILTER_SANITIZE_STRING);
        $dest_pais = filter_var($destinatario->enderDest->xPais, FILTER_SANITIZE_STRING);

        $stmt = $con->prepare("INSERT INTO care.notas_fiscais
        (numero_nf, data_emissao, valor_total, cnpj_dest, razao_social, logradouro, numero, complemento, bairro, municipio, uf, pais, created_at)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp());");
        $stmt->bind_param("ssdsssssssss", $num_nota_fiscal,
            $dt_emissao_nota_fiscal,
            $vr_total_nota_fiscal,
            $dest_cnpj,
            $dest_razao_social,
            $dest_logradouro,
            $dest_numero,
            $dest_complemento,
            $dest_bairro,
            $dest_municipio,
            $dest_uf,
            $dest_pais);
        $stmt->execute();

        echo '<br>';
        echo 'Numero da nota: ' . $num_nota_fiscal . '<br>';
        echo 'Data de emissão: ' . $dt_emissao_nota_fiscal . '<br>';
        echo 'Valor total NF: ' . $vr_total_nota_fiscal . '<br>';
        echo 'CNPJ/CPF: ' . $dest_cnpj . '<br>';
        echo 'Razão Social: ' . $dest_razao_social . '<br>';
        echo 'Logradouro: ' . $dest_logradouro . '<br>';
        echo 'Número: ' . $dest_numero . '<br>';
        echo 'Complemento: ' . $dest_complemento . '<br>';
        echo 'Bairro: ' . $dest_bairro . '<br>';
        echo 'Município: ' . $dest_municipio . '<br>';
        echo 'UF: ' . $dest_uf . '<br>';
        echo 'Pais: ' . $dest_pais . '<br>';


        echo "<br><a href='index.php'>Voltar<a/>";

    } else {
        echo 'Nota fiscal não pertence ao emitente';
    }
} else {
    echo 'O arquivo não enviado é um .XML.';
}


