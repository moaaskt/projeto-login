<?php

namespace App\Libraries;

class EmailSes
{
    public function enviarEmail($email, $email_from, $name_from, $subject, $message)
    {
        $dados = [
            'email'      => $email,
            'email_from' => $email_from,
            'name_from'  => $name_from,
            'subject'    => $subject,
            'message'    => $message,
            
          
        ];
              


        $json = json_encode($dados);
        $apiUrl = 'https://licsglgsm6.execute-api.us-east-1.amazonaws.com/default/EmailMultiplosAnexos';
      

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        // ====================================================================
        // == CORREÇÃO APLICADA AQUI ==
        // Estas linhas desativam a verificação de certificado SSL do cURL.
        // ESSENCIAL para rodar em ambientes locais como XAMPP/Laragon.
        // ATENÇÃO: Em produção, o ideal é configurar o caminho para o certificado.
        // ====================================================================
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            log_message('error', '[EmailSes] cURL Error: ' . $error);
            // Lança uma exceção para ser capturada pelo controller
            throw new \Exception('Falha na comunicação com a API de e-mail: ' . $error);
        }

        curl_close($ch);

        return $result;
    }
}
