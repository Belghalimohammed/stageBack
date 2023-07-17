<?php

namespace App\Service;

use App\Entity\Invoice;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Twig\Environment;

class PdfService
{
    private $domPdf;
    private $templating;
    private $root = "";
    
    public function __construct(Environment $templating,ContainerBagInterface $params) {
        $this->domPdf = new DomPdf();
        $this->templating = $templating;
        $this->root = $params->get('storage_path');

        $pdfOptions = new Options();
        $this->domPdf->setPaper('A4', 'portrait');
        $pdfOptions->set('defaultFont', 'Garamond');
        $this->domPdf->setOptions($pdfOptions);
    }

    public function makePdf($entity) {
        $html = $this->templating->render('invoice.html.twig',['invoice'=>$entity]);
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
    }

    public function download(Invoice $invoice) {
        $folder = $this->root.'/'.$invoice->getContract()->getClient()->getId().'/invoices/';
        $file = $folder.$invoice->getFileName();
        if($invoice->getFileName() && strlen(trim($invoice->getFileName()) > 0) && file_exists($file)) {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Content-Length: ' . filesize($file));
            
            readfile($file);
        } else {
            throw new FileNotFoundException('File Not Found',310);
        }

    }

    public function showPdfFile() {
        $this->domPdf->stream("invoice.pdf", [
            'Attachement' => true
        ]);
    }

    public function save(Invoice $invoice) {
        $folder = $this->root.'/'.$invoice->getContract()->getClient()->getId();
        $fileName = 'invoice_'.$invoice->getContract()->getClient()->getId().'_'.$invoice->getCreatedAt()->format('Y-m-d').'.pdf';
        $file = $folder.'/invoices/'.$fileName;

        if (!is_dir($folder)) {
            mkdir($folder);
        }
        if (!is_dir($folder.'/invoices')) {
            mkdir($folder.'/invoices');
        }
        
        file_put_contents($file, $this->domPdf->output());
        return $fileName;
    }

    public function output() {
        return $this->domPdf->output();
    }

    
}



