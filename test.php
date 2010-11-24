<?php


// Include the autoloader.
require_once( dirname( __FILE__ ) . '/Classes/Autoloader.class.php' );

// Register the autoloader.
RRoEmbed_Autoloader::getInstance()->register();

// Create a new consumer.
$c = new RRoEmbed_Consumer();

// Call the "consume" method and supply it the URL of the resource you'd like
// to get the oEmbed representation of and the Provider instance.
//$o = $c->consume(
//	'http://www.flickr.com/photos/romac17/4101838222/',
//	new RRoEmbed_Provider_Flickr( array() )
//);
//
//print $o;


try
{
    $o = $c->consume(
        'http://vimeo.com/15952335',
        new RRoEmbed_Provider_Vimeo(
            array( 'width' => 350, 'byline' => 'false', 'title' => 'false' )
        )
    );

    print $o;
}
catch( RRoEmbed_Exception $e )
{
    echo 'Error: ' . $e->getMessage() . ' in file: ' . substr( $e->getTraceAsString(), strrpos( $e->getTraceAsString(), '#', -10 ) );
}



// DailyMotion
//try
//{
//    $o = $c->consume(
//        'http://www.dailymotion.com/video/xf02xp_uffie-difficult_music'
////        new RRoEmbed_Provider_Dailymotion()
//    );
//
//    print $o;
//}
//catch( RRoEmbed_Exception $e )
//{
//    echo 'Error: ' . $e->getMessage() . ' in file: ' . substr( $e->getTraceAsString(), strrpos( $e->getTraceAsString(), '#', -10 ) );
//}



// Notice you can also omit to specify the provider, if so the Consumer will try to
// automatically find a valid provider endpoint.
//$o = $c->consume( 'http://vimeo.com/15952335' );
//
//print $o;

 
