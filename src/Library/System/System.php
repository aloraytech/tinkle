<?php


namespace Tinkle\Library\System;


use Tinkle\Request;
use Tinkle\Response;
use Tinkle\System\Activity;

class System
{

    public System $system;
    public Activity $activity;
    public Sense $sense;


    /**
     * System constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request,Response $response)
    {
        $this->system = $this;
        $this->activity = new Activity();
        $this->sense = new Sense();

    }

    public function resolve()
    {
        $this->activity->resolve();
    }


    public function getActivity()
    {

    }

    public function getSense()
    {

    }










}