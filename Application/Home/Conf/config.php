<?php
return array(
	//'配置项'=>'配置值'
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' => array(
        '/^news$/'                  => 'Home/Cat/index?id=5',
        '/^sports$/'                => 'Home/Cat/index?id=4',
        '/^cars$/'                  => 'Home/Cat/index?id=3',
        '/^techs$/'                 => 'Home/Cat/index?id=7',
        '/^article\/(\d+)\/(\d+)$/' => 'Home/Detail/index?catid=:1&id=:2'
    ),
    'URL_MAP_RULES'   => array(

    )
);