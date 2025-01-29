<?php

if (!function_exists('setActiveClass')) {
    function setActiveClass($routeName)
    {
        return request()->routeIs($routeName) ? 'active' : '';
    }
}