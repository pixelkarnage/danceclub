<?php
/**
 * Register options
 *
 * @package PlanT\Danceclub
 * @author  Samuel Scherer
 *

namespace PlanT\Danceclub;

/**
 * Register options
 *
 * @author Tim Lochmüller
 *

class Register
{

    /**
     * Get the autoloader configuration
     *
     * @return array
     *
    static public function getAutoloaderConfiguration()
    {
        return [
            'StaticTyposcript'
        ];
    }

    /**
     * Get the configuration
     *
     * @return array
     *
    static public function getConfiguration()
    {
        return [
            'uniqueRegisterKey' => 'Danceclub',
            'title'             => 'Dance Event',
            'modelName'         => 'PlanT\\Danceclub\\Domain\\Model\\Event',
            'partialIdentifier' => 'Event',
            'tableName'         => 'tx_danceclub_domain_model_event',
            'required'          => false,
        ];
    }

}