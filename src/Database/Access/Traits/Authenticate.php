<?php

namespace Tinkle\Database\Access\Traits;

use Tinkle\Database\Access\Rules\RuleResolver;
use Tinkle\Exceptions\Display;
use Tinkle\Helpers\Helper;

trait Authenticate
{

    /**
     * @throws Display
     */
    public function getCredential()
    {
        $credential = $this->setCredential();

        if(count($credential) === 3)
        {
            $data=[
                'first'=>$credential[0],
                'second'=>$credential[1],
                'confirmSecond'=>$credential[2],
            ];

            return $this->matchCredential($data);

        }else{
            throw new Display("Maximum Three Credential Allowed.['first','second','confirmSecond']",Display::HTTP_SERVICE_UNAVAILABLE);
        }

    }


    private function matchCredential(array $credential)
    {
       // dryDump($credential,'Credential');
        $ruleList = $this->resolveRules();
       // dryDump($ruleList,'Rules');
        $newArray=[];
        $errors = [];
        $same='';
        foreach ($credential as $key => $value)
        {
            foreach ($ruleList as $rKey => $rValue)
            {
                if($value === $rKey)
                {
                    $newArray[$key]['field'] = $value;
                    if($rValue['same'] !=null)
                    {
                       // $newArray['same']['file'] = $rValue['same'];
                        $same=$rValue['same'];
                    }
                    unset($rValue['same']);
                    $newArray[$key]['config'] = $rValue;

                }

            }


        }

//        // Check For Same Filed
        if(!empty($same))
        {
            foreach ($newArray as $key => $value)
            {
                if($same === $value['field'])
                {
                    $newArray['same']['field'] =$same;
                    $newArray['same']['as'] =$key;
                    $newArray['same'][$key] =$value;

                }
            }
        }


        return $newArray;

    }

    private function resolveRules()
    {
        $resolver = new RuleResolver($this->rules());
        return $resolver->getFormat();
       // ddump($rules);

    }



    public function vefifyCredential(array $webCredential,array $credFormat)
    {
         $data = [];

         if(!empty($webCredential) && !empty($credFormat) && is_array($webCredential) && is_array($credFormat) && count($webCredential) === 3)
         {

             foreach ($webCredential as $key => $credential)
             {

                 if($key === $credFormat['first']['field'])
                 {
                    if(Helper::REGEX()->verify($credential,$credFormat['first']['config']['type']))
                    {
                        if(!empty($credFormat['first']['config']['max']))
                        {
                            if(strlen($credential) < $credFormat['first']['config']['max'])
                            {
                                if(!empty($credFormat['first']['config']['min']))
                                {
                                    if(strlen($credential) > $credFormat['first']['config']['min'])
                                    {
                                        $data['first']=[
                                            'value'=> $credential,
                                            'field'=> $credFormat['first']['field'],
                                            'config'=>$credFormat['first']['config'],
                                        ];
                                    }
                                }
                            }
                        }
                    }
                 }elseif($key === $credFormat['second']['field'])
                 {
                     // Currently Only AlphaNumeric Can Be As Password..But Need To use Symbols For Complex Password
                     if(Helper::REGEX()->verify($credential,$credFormat['second']['config']['type']))
                     {
                         if(!empty($credFormat['second']['config']['max']))
                         {
                             if(strlen($credential) < $credFormat['second']['config']['max'])
                             {
                                 if(!empty($credFormat['second']['config']['min']))
                                 {
                                     if(strlen($credential) > $credFormat['second']['config']['min'])
                                     {
                                         $data['second']=[
                                             'value'=> $credential,
                                             'field'=> $credFormat['second']['field'],
                                             'config'=>$credFormat['second']['config'],
                                         ];
                                     }
                                 }
                             }
                         }
                     }
                 }elseif($key === $credFormat['confirmSecond']['field'])
                 {
                     if(Helper::REGEX()->verify($credential,$credFormat['confirmSecond']['config']['type']))
                     {
                         if(!empty($credFormat['confirmSecond']['config']['max']))
                         {
                             if(strlen($credential) < $credFormat['confirmSecond']['config']['max'])
                             {
                                 if(!empty($credFormat['confirmSecond']['config']['min']))
                                 {
                                     if(strlen($credential) > $credFormat['confirmSecond']['config']['min'])
                                     {
                                         $data['confirmSecond']=[
                                             'value'=> $credential,
                                             'field'=> $credFormat['confirmSecond']['field'],
                                             'config'=>$credFormat['confirmSecond']['config'],
                                         ];
                                     }
                                 }
                             }
                         }
                     }
                 }else{
                     continue;
                 }



             }


         }
         return $this->checkSameAs($data);
    }




    private function checkSameAs(array $data)
    {

      // As we predefine All Key Fields
        if($data['second']['value'] === $data['confirmSecond']['value'])
        {
            if($data['second']['config']['min'] === $data['confirmSecond']['config']['min'])
            {
                if($data['second']['config']['max'] === $data['confirmSecond']['config']['max'])
                {
                    if($data['second']['config']['type'] === $data['confirmSecond']['config']['type'])
                    {
                        return $data;
                    }
                }
            }
        }




        return [];

    }







}