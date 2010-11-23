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
 * Abstract Class RRoEmbed_Provider_AbstractArguments.
 *
 * @todo       Description Abstract for class RRoEmbed_Provider_AbstractArguments.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Laurent Cherpit <laurent.cherpit@gmail.com>
 * @version    0.1
 */
Abstract class RRoEmbed_Provider_AbstractArguments implements ArrayAccess
{
    public function __construct( array $arguments = array() )
    {

    }

	public function offsetSet( $offset, $value )
	{

	}

	public function offsetGet( $offset )
	{

	}

	public function offsetUnSet()
	{

	}

	public function offsetExists( $offset )
	{

	}
}
