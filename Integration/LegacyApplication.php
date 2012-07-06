<?php

namespace Webfactory\Bundle\LegacyIntegrationBundle\Integration;

use Symfony\Component\HttpFoundation\Response;

class LegacyApplication extends IntegratableApplication {

    protected $bootstrapFile;
    protected $response;

    public function __construct($bootstrapFile) {
        $this->bootstrapFile = $bootstrapFile;
    }

    public function getResponse() {
        if (!$this->response) {
            $legacyBootstrap = $this->bootstrapFile;

            ob_start();
            include($legacyBootstrap);

            if (headers_sent())
                throw new \Exception("Du musst sicherstellen, dass die Legacy-Anwendung $legacyBootstrap keine Header bzw. Output sendet (output_buffering)!");

            /**
             * http_response_code geht leider erst mit PHP5.4.
             * Wir wollen aber eigentlich sowieso, dass alle Responses <> 200 mit Exceptions realisiert werden.
             * Die Exception Page wird über den Kernel gelöst
             */
            $statusCode = 200;

            $content = ob_get_contents();
            ob_end_clean();

            $headers = headers_list();
            $responseHeaders = array();
            foreach ($headers as $header) {
                $header = preg_match('(^[^:]+:(.*)$)', $header, $matches);
                $headerName = $matches[1];
                $headerValue = $matches[2];
                $responseHeaders[$headerName][] = $headerValue;
            }
            header_remove();

            $this->response = new Response($content, $statusCode, $responseHeaders);
        }
        return $this->response;
    }

}