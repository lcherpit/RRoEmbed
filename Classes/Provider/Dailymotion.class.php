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
 * Source file containing class RRoEmbed_Provider_YouTube.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Provider_YouTube
 */

/**
 * Class RRoEmbed_Provider_YouTube.
 * 
 * @todo       Description for class RRoEmbed_Provider_Dailymotion.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @author     Laurent Cherpit <laurent.cherpit@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Provider_Dailymotion extends RRoEmbed_Provider_BaseProvider
{
    /**
     * List of optional available parameters to the corresponding provider API
     *
     * @var array
     */
    protected $_ApiOptionalParameters = array(

        /**
         * The maximum width of the embedded video can take on the destination page.
         */
        'maxwidth',

        /**
         * The maximum height the embedded video can take on the destination page.
         */
        'maxheight',

        /**
         * When returning JSON, wrap in this function
         * @see JSONP proposal <http://bob.pythonmac.org/archives/2005/12/05/remote-json-jsonp/> for more info
         */
        'callback'
	);

    public function __construct( array $optionalParameters = array() )
    {
        $this->_setApiOptionalParameters( $this->_ApiOptionalParameters );
        
        parent::__construct(
            'http://www.dailymotion.com/services/oembed',
            $optionalParameters,
            array(
	            'http://*.dailymotion.com/*',
                'http://*.dailymotion.com/video/*',
	            'http://*.dailymotion.com/swf/*'
            ),
            'http://www.dailymotion.com',
            'Dailymotion'
        );
    }
    
}
