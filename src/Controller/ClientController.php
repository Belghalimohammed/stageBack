<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contract;
use App\Entity\Invoice;
use App\Entity\Prospect;
use App\Exception\EntityExistException;
use App\Repository\CityRepository;
use App\Repository\ClientRepository;
use App\Repository\ProspectRepository;
use App\Repository\SalesRepRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ClientController extends AbstractController
{
    private $prospectRepository;
    private $salesRepRepository;
    private $cityRepository;
    public function __construct(ProspectRepository $prospectRepository,
                                SalesRepRepository $salesRepRepository,
                                CityRepository $cityRepository)
    {
        $this->prospectRepository = $prospectRepository;
        $this->salesRepRepository = $salesRepRepository;
        $this->cityRepository = $cityRepository;
    }
    #[Route(
        name: 'prospectToClient',
        path: '/client/switch',
        methods:['POST']
    )]
    public function switchToClient(Request $request,EntityManagerInterface $manager)
    {
        $data = json_decode($request->getContent(), true);

        $prospect = $this->prospectRepository->findOneBy(['id'=>$data['prospectId']]);
        if($prospect === null)
        {
            throw new EntityNotFoundException("prospect does not exist",302);
        }

        if(!($prospect instanceof Prospect))
        {
            throw new InvalidTypeException("the Entity is not an instance of prospect",307);
        }
    
        $client = new Client();
        $client->setAdresse($data["adresse"]);
        $client->setEmail($data["email"]);
        $client->setManager($data["manager"]);
        $client->setName($prospect->getName());
        $client->setCity($prospect->getCity());
        $client->setPhoneNumber($prospect->getPhoneNumber());

        $manager->persist($client);
        $manager->flush();
        
        $contract = new Contract();

        

        $contract->setClient($client);
        $contract->setStartDate(new DateTime($data["startDate"]));
        $contract->setEndDate(new DateTime($data["endDate"]));
        $contract->setPrice($data["price"]);

        $salesRep = $this->salesRepRepository->findOneBy(['id'=>$data["salesRep"]]);
        $contract->setSalesRep($salesRep);

        $manager->persist($contract);



       

        $manager->remove($prospect);

        $manager->flush();

        return new JsonResponse(['message' => 'Client added successfully'], 200);
       
    }


    #[Route(
        name: 'addClient',
        path: '/client/add',
        methods:['POST']
    )]
    public function addClient(Request $request,EntityManagerInterface $manager)
    {
        $data = json_decode($request->getContent(), true);

        
    
        $client = new Client();
        $client->setAdresse($data["adresse"]);
        $client->setEmail($data["email"]);
        $client->setManager($data["manager"]);
        $client->setName($data["name"]);

        $city = $this->cityRepository->findOneBy(['id'=>$data["city"]]);
        $client->setCity($city);

        $client->setPhoneNumber($data["phoneNumber"]);

        $manager->persist($client);
        $manager->flush();
        
        $contract = new Contract();

        

        $contract->setClient($client);
        $contract->setStartDate(new DateTime($data["startDate"]));
        $contract->setEndDate(new DateTime($data["endDate"]));
        $contract->setPrice($data["price"]);

        $salesRep = $this->salesRepRepository->findOneBy(['id'=>$data["salesRep"]]);
        $contract->setSalesRep($salesRep);

        $manager->persist($contract);

        $manager->flush();

        return new JsonResponse(['message' => 'Client added successfully'], 200);
       
    }

}

