<?php

##########################################################################
#                                                                        #
# (c) 2003 Jannis Hermanns <J@hacked.it>                                 #
# http://www.jannis.to/programming/serendipity.html                      #
#                                                                        #
#                                                                        #
# Translated by                                                          #
# (c) 2004-2005 CapriSkye <admin@capriskye.com>                          #
#               http://open.38.com                                       #
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
      'name' => 'Yahoo!',
      'host' => 'api.my.yahoo.com',
      'path' => '/RPC2'
    ),
    array(
      'name' => 'Blogbot.dk',
      'host' => 'blogbot.dk',
      'path' => '/io/xml-rpc.php')
);

?>