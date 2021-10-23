<?php

namespace Tinkle\Database\Access\Rules;

use Tinkle\Helpers\Helper;
use Tinkle\Helpers\REGEX;
use Tinkle\Library\Essential\Helpers\RegexHandler;

class RuleResolver
{

    private array $givenRule=[];
    public array|object $format=[];

    public function __construct(array $ruleDetail)
    {
        $this->givenRule = $ruleDetail;
        $this->resolveGivenRules();
    }

    public function getFormat()
    {
        return $this->format;
    }

    // PROCESS N RESOLVE


    private function resolveGivenRules()
    {


        foreach ($this->givenRule as $key => $ruleDetail)
        {
            if(Helper::REGEX()->verify($ruleDetail,'/required/'))
            {
                $this->format[$key]['require'] = true;
            }else{
                $this->format[$key]['require'] = false;
            }
          //  dryDump($ruleDetail,"Rule Details");
            $this->format[$key]['type'] = $this->getMatch($ruleDetail);

            $this->format[$key]['max'] = $this->getMaxSize($ruleDetail);
            $this->format[$key]['min'] = $this->getMinSize($ruleDetail);
            $this->format[$key]['same'] = $this->getSame($ruleDetail);



        }


    }





















    // Check N Match


    private function getMinSize(mixed $value)
    {
        $minPart = Helper::REGEX()->findMatch($value,'/min:\d+/');
        if(!empty($minPart))
        {
            $minPart = explode(":",$minPart);
            return $minPart[1];
        }
    }

    private function getMaxSize(mixed $value)
    {
        $minPart = Helper::REGEX()->findMatch($value,'/max:\d+/');
        if(!empty($minPart))
        {
            $minPart = explode(":",$minPart);
            return $minPart[1];
        }
    }



    private function getMatch(mixed $value)
    {
        if(Helper::REGEX()->verify($value,'/email/'))
        {
            return RegexHandler::REGEX_EMAIL;
        }elseif(Helper::REGEX()->verify($value,'/password/'))
        {
            return RegexHandler::REGEX_ALPHA_NUMERIC;
        }elseif(Helper::REGEX()->verify($value,'/date/'))
        {
            return RegexHandler::REGEX_ALPHA_NUMERIC;
        }else{
            return 'unknown';
        }
    }


    private function is_matchType(mixed $value)
    {
        if(Helper::REGEX()->verify($value,'/email/'))
        {
            return RegexHandler::REGEX_EMAIL;
        }elseif(Helper::REGEX()->verify($value,'/password/'))
        {
            return RegexHandler::REGEX_ALPHA_NUMERIC;
        }elseif(Helper::REGEX()->verify($value,'/date/'))
        {
            return RegexHandler::REGEX_ALPHA_NUMERIC;
        }else{
            return 'unknown';
        }

    }

    private function getSame(mixed $ruleDetail)
    {
        $samePart = Helper::REGEX()->findMatch($ruleDetail,'/same:\w+/');
        if(!empty($samePart))
        {
            $samePart = explode(":",$samePart);
            $part = $samePart[1];

            if(key_exists($part,$this->givenRule))
            {
                return $part;
            }else{
                return null;
            }

        }
        return null;
    }


}