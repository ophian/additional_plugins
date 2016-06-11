<?php

##########################################################################
#                                                                        #
# (c) 2003 Jannis Hermanns <J@hacked.it>                                 #
# http://www.jannis.to/programming/serendipity.html                      #
#                                                                        #
##########################################################################

$servicesdb = array(
            array(
              'name'       => 'Ping-o-Matic',
              'host'       => 'rpc.pingomatic.com',
              'path'       => '/',
              'extended'   => true,
              'supersedes' => array('blo.gs', 'blogrolling.com', 'technorati.com', 'weblogs.com', 'Yahoo!')
            ),

            array(
              'name'     => 'blo.gs',
              'host'     => 'ping.blo.gs',
              'path'     => '/',
              'extended' => true
            ),

            array(
              'name' => 'blogrolling.com',
              'host' => 'rpc.blogrolling.com',
              'path' => '/pinger/'
            ),

            array(
              'name' => 'technorati.com',
              'host' => 'rpc.technorati.com',
              'path' => '/rpc/ping'
            ),

            array(
              'name' => 'weblogs.com',
              'host' => 'rpc.weblogs.com',
              'path' => '/RPC2'
            ),

            array(
              'name' => 'ge.bloggt.org',
              'host' => 'ping.ge.bloggt.org',
              'path' => '/'
            ),

            array(
              'name' => 'Yahoo!',
              'host' => 'api.my.yahoo.com',
              'path' => '/RPC2'
            ),

            array(
              'name' => 'Google',
              'host' => 'blogsearch.google.com',
              'path' => '/ping/RPC2'
            ),
);

?>