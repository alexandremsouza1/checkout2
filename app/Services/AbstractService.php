<?php


namespace App\Services;

use App\Models\Company;
use App\Models\Responsible;
use Illuminate\Support\Facades\DB;

abstract class AbstractService
{

    const STATE_MANAGEMENT = [
        'no_register' => ['confirmation','contact','company','parcial_email','parcial_sms'],
        'db_client' => ['confirmation','contact','company','parcial_email','parcial_sms'],
        'parcial_email' => ['confirmation'],
        'parcial_sms' => ['confirmation'],
        'confirmation' => ['active','review','blocked','canceled','contact','company'],
        'review' => ['active','blocked','canceled'],
        'blocked' => ['active','review','canceled'],
        'canceled' => ['active','review','blocked'],
        'contact' => ['confirmation','company','contact'],
        'company' => ['confirmation','logistic'],
        'logistic' => ['documents'],
        'documents' => ['analysis'],
        'analysis' => ['active','review','blocked','canceled'],
    ];


    public function startTranscation()
    {
        DB::beginTransaction();
    }

    public function commitTranscation()
    {
        DB::commit();
    }

    public function rollbackTranscation()
    {
        DB::rollBack();
    }

    public function changeStatus($newStatus, $document)
    {
      $responsable = $this->findResponsible($document);
      if(!in_array($newStatus->value, self::STATE_MANAGEMENT[$responsable->status])){
        throw new \Exception('Invalid status: Allowed status: '.implode(',', self::STATE_MANAGEMENT[$responsable->status]));
      }
      $responsable->status = $newStatus;
      $responsable->save();
    }

    public function findResponsible($document)
    {
      $responsable = Responsible::where('document', $document)->first();
      if(!$responsable){
        throw new \Exception('Responsable not found');
      }
      return $responsable;
    }

    public function findCompany($document)
    {
      $company = Company::where('document', $document)->first();
      if(!$company){
        throw new \Exception('Company not found');
      }
      return $company;
    }
}

