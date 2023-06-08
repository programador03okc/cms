<?php

namespace App\Helpers;
include_once 'simple_html_dom.php';

class WebHelper
{
    public $cUrl;

    public function __construct()
    {
        $this->cUrl = curl_init();
        curl_setopt($this->cUrl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->cUrl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->cUrl, CURLOPT_VERBOSE, true);
        curl_setopt($this->cUrl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->cUrl, CURLOPT_RETURNTRANSFER, true);
    }

    public function __destruct()
    {
        if ($this->cUrl!=null)
        {
            curl_close($this->cUrl);
        }
    }

    public function descargarArchivo($ruta, $destino)
    {
        file_put_contents($destino, $this->visitarUrl($ruta));
    }

    public function parseHtml($pagina)
    {
        return str_get_html($pagina);
    }

    public function visitarUrl($url)
    {
        curl_setopt($this->cUrl, CURLOPT_URL, $url);
        curl_setopt($this->cUrl, CURLOPT_HEADER, 0);
        return curl_exec($this->cUrl);
    }

    public function enviarData($dataEnviar, $url,$metodo='post',$dataCabecera=null)
    {
        //Método de petición: GET, POST, PUT, DELETE, PATCH
        switch (strtoupper($metodo)){
          case "POST":
            curl_setopt($this->cUrl, CURLOPT_POST, 1);
            if ($dataEnviar!=null)
            {
              curl_setopt($this->cUrl, CURLOPT_POSTFIELDS, http_build_query($dataEnviar));
            }
            //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
          case "PUT":
            curl_setopt($this->cUrl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($dataEnviar!=null)
            {
              curl_setopt($this->cUrl, CURLOPT_POSTFIELDS, http_build_query($dataEnviar));
            }
          break;
          default:
            if ($dataEnviar!=null)
            {
              $url = sprintf("%s?%s", $url, http_build_query($dataEnviar));
            }
          break;
        }
        curl_setopt($this->cUrl, CURLOPT_URL, $url);

        if ($dataCabecera==null)
        {
          curl_setopt($this->cUrl, CURLOPT_HEADER, 0);
        }
        else {
          curl_setopt($this->cUrl, CURLOPT_HTTPHEADER, $dataCabecera);
        }

        $headers = [];
        curl_setopt($this->cUrl, CURLOPT_HEADERFUNCTION,
          function($curl, $header) use (&$headers)
          {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
              return $len;

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
          }
        );

        $respuesta=new \stdClass();
        $respuesta->body=curl_exec($this->cUrl);
        $respuesta->header=$headers;
        return $respuesta;
    }
}
