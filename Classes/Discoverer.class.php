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
 * Source file containing class RRoEmbed_Discoverer.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Discoverer
 */

/**
 * Class RRoEmbed_Discoverer.
 * 
 * @todo       Description for class RRoEmbed_Discoverer.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @author Laurent Cherpit <laurent.cherpit@gmail.com>
 * @version    0.2 
 */
class RRoEmbed_Discoverer
{
    
    /**
     * Regex to get provided discover link. (link args aren't always in the same order)
     */
//    const LINK_REGEX = '#<link(?:[^>]*)type="(?P<Format>@formats@)\+oembed"(?P<Attributes>[^>]*)>#i';

    const LINK_REGEX = '#<link(?P<Link>[^>]+(?:@formats@\+oembed")[^>]+)>#i';

    const ARGS_REGEX = '/(
                            (?P<Argument>[a-zA-Z0-9:]+)=        # match argument
                            (?:
                                (?:"|\')
                                    (?P<quotedValue>            # match value
                                        [^"]*
                                        |
                                        [^\']*
                                    )
                                (?:"|\')
                            )
                            \s+
                            )+?
                        /ix';
    
    /**
     * Cached endpoints.
     *
     * @var string[]
     */
    protected $_cachedEndpoints = array();
    
    /**
     * Supported formats
     *
     * @var string
     */
    protected $_supportedFormats = array(
        'application/json',
        'application/xml',
        'text/json',
        'text/xml'
    );
    
    /**
     * Preferred format
     *
     * @var string
     */
    protected $_preferredFormat = 'json';

    /**
     * Matched format
     *
     * @var string
     */
    protected $_responseFormat = '';

    /**
     * Get the provider's endpoint URL for the supplied resource. 
     *
     * @param string $url The URL to get the endpoint's URL for.
     * 
     * @return void
     * 
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     * @author Laurent Cherpit <laurent.cherpit@gmail.com> 
     */
    public function getEndpointForUrl( $url )
    {
        if( !isset( $this->_cachedEndpoints[ $url ] ) )
        {
            $endPoint = $this->_fetchEndpointForUrl( $url );

            // just clean the QueryString. that will be rebuild after.
            $this->_cachedEndpoints[ $url ] = substr( $endPoint, 0, strpos( $endPoint, '?' ) );
        }
        
        return $this->_cachedEndpoints[ $url ];
    }

    /**
     * Get the format for the supplied resource that match. 
     *
     * @return string
     * @author Laurent Cherpit <laurent.cherpit@gmail.com>
     */
    public function getResponseFormat()
    {
        return $this->_responseFormat;
    }

    /**
     * Set the format for the supplied resource that match.
     *
     * @return void
     * @author Laurent Cherpit <laurent.cherpit@gmail.com>
     */
    protected function _setResponseFormat( $format )
    {
        $this->_responseFormat = $format;
    }

    /**
     * Get the format string (json | xml)
     *
     * @return string
     * @author Laurent Cherpit <laurent.cherpit@gmail.com>
     */
    protected function _getSimpleFormat( $format )
    {
        $begin = ( strpos( $format, '/' ) + 1 );
        $end   = strrpos( $format, '+' );
        $len   = $end - $begin; 

        return substr( $format, $begin, $len );
    }

    /**
     * Fetch the provider's endpoint URL for the supplied resource.
     *
     * @param string $url The provider's endpoint URL for the supplied resource.
     * 
     * @return string
     * 
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function _fetchEndpointForUrl( $url )
    {
        $request = new RRoEmbed_Request( $url );
        
        try
        {
            $body = $request->send();
        }
        catch( Exception $e )
        {
            throw new RRoEmbed_Exception(
                'Unable to fetch the page body for "' . $url . '".'
            );
        }
        
        $regEx = str_replace(
            '@formats@',
            implode( '|', $this->_supportedFormats ),
            self::LINK_REGEX
        );
        
        if( !preg_match_all( $regEx, $body, $matches, PREG_SET_ORDER ) )
        {
            throw new RRoEmbed_Exception(
                'No valid oEmbed links found on the document at "' . $url . '".'
            );
        }
        
        foreach( $matches as $match )
        {
            preg_match_all( self::ARGS_REGEX, $match[ 'Link' ], $matchesArgs, PREG_SET_ORDER );
            
            foreach( $matchesArgs as $matchesArg )
            {
                if( $matchesArg[ 'Argument' ] === 'type' )
                {
                    $this->_setResponseFormat( $this->_getSimpleFormat( $matchesArg[ 'quotedValue' ] ) );
                    
                    if( strpos( $matchesArg[ 'quotedValue' ], $this->_preferredFormat ) !== FALSE )
                    {
                        return $this->_extractEndpointFromAttributes( $matchesArgs );
                    }
                }
            }
        }

        return $this->_extractEndpointFromAttributes( $matchesArgs );
    }
    
    /**
     * Extract the endpoint's URL from the <link>'s tag attributes.
     *
     * @param  string $attributes The attributes of the <link> tag.
     * 
     * @return string
     * 
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function _extractEndpointFromAttributes( $matchesArgs )
    {

        foreach( $matchesArgs as $matchesArg )
        {
            if( $matchesArg[ 'Argument' ] === 'href' )
            {
                return $matchesArg[ 'quotedValue' ];
            }
        }
    }
    
}