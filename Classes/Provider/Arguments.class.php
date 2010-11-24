<?php

/*
 * Copyright (c) 2010 Laurent cherpit <laurent.cherpit@gmail.com>
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
 * Source file containing class ${CLASS}
 * @package     RRoEmbed
 * @license     http://opensource.org/licenses/mit-license.html MIT License
 * @author      Laurent cherpit <laurent.cherpit@gmail.com>
 * @date:       23 nov. 2010
 * @time:       15:52:01
 * @version:    0.1
 */

/**
 * Class RRoEmbed_Provider_Arguments.
 *
 * @todo       Description Abstract for class RRoEmbed_Provider_Arguments.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Laurent Cherpit <laurent.cherpit@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Provider_Arguments implements ArrayAccess
{
    /**
     * List of arguments
     *
     * @var array
     */
    private $_arguments = array();

    /**
     * List of optional parameters to the corresponding provider API
     *
     * @var array
     */
    private $_optionalParametersFromApi = array();

    
    public function __construct( array $optionalParametersFromApi = array() )
    {
        $this->_optionalParametersFromApi = $optionalParametersFromApi;
    }

    public function offsetSet( $offset, $value )
    {
        if( isset( $offset ) && is_string( $offset ) )
        {
            if( in_array( $offset, $this->_optionalParametersFromApi, TRUE ) )
            {
                $this->_arguments[ $offset ] = $value;
            }
            else
            {
                throw new RRoEmbed_Exception(
                    'Array key offset must be a valid parameter defined by the provider API'
                );
            }
        }
        else
        {
            throw new RRoEmbed_Exception(
                'Array key offset must be a String. ' . gettype( $offset ) . ' given.' . "\n" .
                'Avaiblable keys are: ( ' . implode( ",\n", $this->_optionalParametersFromApi ) . ' ) '

            );
        }
    }

    public function offsetGet( $offset )
    {
        return $this->offsetExists( $offset ) ? $this->_arguments[ $offset ] : NULL;
    }

    public function offsetUnSet( $offset )
    {
        if( $this->offsetExists( $offset ) )
        {
            unset( $this->_arguments[ $offset ] );
        }
    }

    public function offsetExists( $offset )
    {
        return isset( $this->_arguments[ $offset ] );
    }
}


//  property_exists