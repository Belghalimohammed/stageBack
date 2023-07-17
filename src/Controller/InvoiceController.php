<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Invoice;
use App\Exception\EntityExistException;
use App\Repository\ClientRepository;
use App\Repository\InvoiceRepository;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class InvoiceController extends AbstractController
{
    private $invoiceRepository;
    private $domPdf;
    public function __construct(InvoiceRepository $invoiceRepository,PdfService $pdf)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->domPdf = $pdf;
    }
    #[Route(
        name: 'getInvoice',
        path: '/invoice/{id}',
        methods:['GET']
    )]
    public function getInvoice(Invoice $invoice)
    {
        $this->domPdf->download($invoice);
        
        return $this->json(base64_encode($this->domPdf->Output()));
    }

    #[Route(
        name: 'getInvoicesOf',
        path: '/invoices/of/{id}',
        methods:['GET']
    )]
    public function getInvoicesOf(Client $client)
    {
        $arr = [];
        foreach ($client->getContracts() as $key) {
            array_push($arr, $key->getId());
        }
        $res = $this->invoiceRepository->findBy(['contract'=>$arr]);

        return $this->json($res);
    }


}

