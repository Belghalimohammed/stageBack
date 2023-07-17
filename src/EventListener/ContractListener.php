<?php

namespace App\EventListener;

use App\Entity\Contract;
use App\Entity\Invoice;
use App\Repository\ContractRepository;
use App\Repository\InvoiceRepository;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;

class ContractListener
{
    private $contractRepository;
    private $invoiceRepository;
    private $pdfService;
    private $manager;
    public function __construct(ContractRepository $contractRepository,InvoiceRepository $invoiceRepository,EntityManagerInterface $manager,PdfService $pdf)
    {
        $this->contractRepository = $contractRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->manager = $manager;
        $this->pdfService = $pdf;
    }

    /**
     * @param PrePersistEventArgs $args
     */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Contract) {
            $count = $this->contractRepository->count([]);
            do {
                $count++;
                $digits = sprintf("%06d", $count);
            } while ($this->contractRepository->findOneBy(['number'=>$digits]) !== null);
            $entity->setNumber($digits);

           
        }

    }

    public function postPersist(PostPersistEventArgs $args): void{
        $entity = $args->getObject();
        if($entity instanceof Contract) {
            $invoice = new Invoice();
   
            $invoice->setContract($entity);

            $this->manager->persist($invoice);
            $this->manager->flush();
        }
    }

    public function postUpdate(PostUpdateEventArgs $args): void{
        $entity = $args->getObject();
        if($entity instanceof Contract) {
            $invoice = $this->invoiceRepository->findOneBy(['contract'=>$entity]);
            if ($invoice == null) {
                return;
            }
            $this->pdfService->makePdf($invoice);
            $fileName = $this->pdfService->save($invoice);
            $invoice->setFileName($fileName);

        }
        
    }

    public function postRemove(PostRemoveEventArgs $args): void{
        $entity = $args->getObject();
        if($entity instanceof Contract) {
            $invoice = $this->invoiceRepository->findOneBy(['contract'=>$entity]);
            if ($invoice == null) {
                return;
            }
            $this->manager->remove($invoice);

        }
        
    }

    
}

