<?php

declare(strict_types=1);

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private Dompdf $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $this->dompdf = new Dompdf($options);
    }

    /**
     * Génère un PDF à partir d'un contenu HTML.
     */
    public function generate(string $html, string $filename = 'document.pdf', bool $stream = true): ?string
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        if ($stream) {
            $this->dompdf->stream($filename, ['Attachment' => false]);
            return null;
        }

        return $this->dompdf->output();
    }
}
