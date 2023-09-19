<?php

namespace App\Services;


use App\Repositories\CustomerRepository;

class CustomerService extends AbstractService
{

  private $customerRepository;
  
  public function __construct(CustomerRepository $customerRepository)
  {
    $this->customerRepository = $customerRepository;
  }
 

  public function getOrCreateCustomer($data)
  {
    return $this->customerRepository->store($data, 'client_id');
  } 

}