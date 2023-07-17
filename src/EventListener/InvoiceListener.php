<?php

namespace App\EventListener;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use App\Service\PdfService;
use Doctrine\ORM\Event\PrePersistEventArgs;

class InvoiceListener
{
    private $invoiceRepository;
    private $pdfService;
    public function __construct(InvoiceRepository $invoiceRepository,PdfService $pdf)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->pdfService = $pdf;
    }

    /**
     * @param PrePersistEventArgs $args
     */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Invoice) {
            $count = $this->invoiceRepository->count([]);
            do {
                $count++;
                $digits = sprintf("%06d", $count);
            } while ($this->invoiceRepository->findOneBy(['reference'=>$digits]) !== null);
            $entity->setReference($digits);

            $this->pdfService->makePdf($entity);
            $fileName = $this->pdfService->save($entity);
            $entity->setFileName($fileName);
        }

    }

  

    
}

