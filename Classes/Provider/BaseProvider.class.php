<?php

/*
 * Copyright (c) 2010 Romain Ruetschi <romain.ruetschi@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Source file containing class RRoEmbed_Provider_BaseProvider.
 * 
 * @package     RRoEmbed
 * @license     http://opensource.org/licenses/mit-license.html MIT License
 * @author      Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version     0.1
 * @see         RRoEmbed_Provider_BaseProvider
 */

/**
 * Class RRoEmbed_Provider_BaseProvider.
 * 
 * @todo        Description for class RRoEmbed_Provider_BaseProvider.
 *
 * @package     RRoEmbed
 * @license     http://opensource.org/licenses/mit-license.html MIT License
 * @author      Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version     0.1
 * @author      Laurent Cherpit <laurent.cherpit@gmail.com>
 * @version     0.2
 */
class RRoEmbed_Provider_BaseProvider
{
    /**
     * JSON format.
     */
    const RESPONSE_FORMAT_JSON    = 'json';

    /**
     * XML format.
     */
    const RESPONSE_FORMAT_XML     = 'xml';

    /**
     * Default format.
     */
    const RESPONSE_FORMAT_DEFAULT = self::RESPONSE_FORMAT_JSON;

    /**
     * Name
     *
     * @var string
     */
    protected $_name     = '';
    
    /**
     * URL
     *
     * @var string
     */
    protected $_url      = '';
    
    /**
     * URL Scheme
     *
     * @var RRoEmbed_URLScheme[]
     */
    protected $_schemes  = array();
    
    /**
     * API Endpoint
     *
     * @var string
     */
    protected $_endpoint = '';

    /**
     * API Response format XML or JSON
     *
     * @var string
     */
    protected $_requestedFormat = '';

    /**
     * QueryString Parameters Object storage. 
     *
     * @var RRoEmbed_Provider_Arguments[]
     */
    protected $_optionalParameterObj = NULL;

    /**
     * List of optional available parameters to the corresponding provider API
     *
     * @var array
     */
    private $_ApiOptionalParameters = array();

    
    /**
     * Create a new RRoEmbed_Provider_BaseProvider instance.
     *
     * @param string                        $endpoint The provider's endpoint URL.
     * @param RRoEmbed_Provider_Arguments[] $optionalParameters additional QueryString params 
     * @param array                         $schemes The schemes the providers match.
     * @param string                        $url    The URL of provider's website.
     * @param string                        $name   The name of the provider.
     * @param string                        $format The format of the data to fetch.
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     * @version 0.1
     * @author  Laurent Cherpit <laurent.cherpit@gmail.com>
     * @version 0.2
     */
    public function __construct(
        $endpoint,
        array $optionalParameters = array(),
        array $schemes = array(),
        $url = '',
        $name = '',
        $format = self::RESPONSE_FORMAT_DEFAULT
    )
    {
        foreach( $schemes as $key => $scheme )
        {
            if( !is_object( $scheme ) || !( $scheme instanceof RRoEmbed_URLScheme ) )
            {
                if( is_string( $scheme ) )
                {
                    $schemes[ $key ] = new RRoEmbed_URLScheme( $scheme );
                }
                else
                {
                    unset( $schemes[ $key ] );
                }
            }
        }

        $this->_setOptionalParametersObj( $optionalParameters );
        $this->_endpoint        = $endpoint;
        $this->_schemes         = $schemes;
        $this->_url             = $url;
        $this->_name            = $name;
        $this->_requestedFormat = $format;
    }
    
    /**
     * Check whether the given URL match one of the provider's schemes.
     *
     * @param string $url The URL to check against.
     * @return boolean
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function match( $url )
    {
        if( !$this->_schemes )
        {
            return TRUE;
        }
        
        foreach( $this->_schemes as $scheme )
        {
            if( $scheme->match( $url ) )
            {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    /**
     * Get the provider's name.
     *
     * @return string
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Get the provider's URL.
     *
     * @return string
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Get the provider's URL schemes.
     *
     * @return RRoEmbed_URLScheme[]
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getSchemes()
    {
        return $this->_schemes;
    }
    
    /**
     * Get the provider's API endpoint.
     *
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getEndpoint()
    {
        return $this->_endpoint;
    }

    public function getRequestedFormat()
    {
        return $this->_requestedFormat;
    }

    /**
     * Get Filtered Additional queryString parameters as Object Array
     *
     * @param  $optionalParameters
     * @return RRoEmbed_Provider_Arguments[]
     */
    public function getOptionalParametersObj()
    {
        return $this->_optionalParameterObj;
    }

    /**
     * Set Filtered Additional queryString parameters as Object Array
     *
     * @param  $optionalParameters
     * @return void
     */
    protected function _setOptionalParametersObj( array $optionalParameters )
    {
        if( !isset( $this->_optionalParameterObj ) )
        {
            try
            {
                $this->_optionalParameterObj = new RRoEmbed_Provider_Arguments( $this->_ApiOptionalParameters );

                foreach( $optionalParameters as $param => $value )
                {
                    $this->_optionalParameterObj[ $param ] = $value;
                }
            }
            catch( RRoEmbed_Exception $e )
            {
                echo 'Error: ' . $e->getMessage() . ' in file: ' . substr( $e->getTraceAsString(), strrpos( $e->getTraceAsString(), '#', -10 ) );
            }
        }

        return $this->_optionalParameterObj;
    }

    protected function _setApiOptionalParameters( array $apiOptionalParameters = array() )
    {
        $this->_ApiOptionalParameters = $apiOptionalParameters;
    }

}
