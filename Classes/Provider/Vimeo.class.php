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
 * Source file containing class RRoEmbed_Provider_Vimeo.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Provider_Vimeo
 */

/**
 * Class RRoEmbed_Provider_Vimeo.
 * 
 * @todo       Description for class RRoEmbed_Provider_Vimeo.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @author     Laurent Cherpit <laurent.cherpit@gmail.com>
 * @version    0.2
 */
class RRoEmbed_Provider_Vimeo extends RRoEmbed_Provider_BaseProvider
{
    /**
     * List of optional available parameters to the corresponding provider API
     *
     * @var array
     */
    protected $_ApiOptionalParameters = array(

        /**
         * The exact width of the video. Defaults to original size.
         */
        'width',

        /**
         * Same as width, but video will not exceed original size.
         */
        'maxwidth',

        /**
         * The exact height of the video. Defaults to original size.
         */
        'height',

        /**
         * Show the byline on the video. Defaults to true.
         */
        'byline',

        /**
         * Show the title on the video. Defaults to true.
         */
        'title',

        /**
         * Show the user's portrait on the video. Defaults to true.
         */
        'portrait',

        /**
         * Specify the color of the video controls.
         */
        'color',

        /**
         * When returning JSON, wrap in this function.
         */
        'callback',

        /**
         * Automatically start playback of the video. Defaults to false.
         */
        'autoplay',

        /**
         * Make the embed code XHTML compliant. Defaults to true.
         */
        'xhtml',

        /**
         * Enable the Javascript API for Moogaloop. Defaults to false.
         */
        'api',

        /**
         * Add the "wmode" parameter. Can be either transparent or opaque.
         */
        'wmode',

        /**
         * Use our new embed code. Defaults to true. NEW!
         */
        'iframe'
	);

    /**
     * @param array $optionalParameters
     * @return void
     */
    public function __construct( array $optionalParameters = array() )
    {
        $this->_setApiOptionalParameters( $this->_ApiOptionalParameters );
        
        parent::__construct(
            'http://www.vimeo.com/api/oembed.json',
            $this->_getOptionalParametersArray( $optionalParameters ),
            array(
                'http://*.vimeo.com/*',
                'http://*.vimeo.com/groups/*/*'
            ),
            'http://www.vimeo.com',
            'Vimeo'
        );
    }
}
