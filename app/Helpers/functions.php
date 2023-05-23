<?php

function getCurrentUser() {
    $user = [];
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();
    } elseif (Auth::guard('production')->check()) {
        $user = Auth::guard('production')->user();
    } elseif (Auth::guard('quality')->check()) {
        $user = Auth::guard('quality')->user();
    } elseif (Auth::guard('store')->check()) {
        $user = Auth::guard('store')->user();
    } elseif (Auth::guard('warehouse')->check()) {
        $user = Auth::guard('warehouse')->user();
    }
    return $user;
}

function get_category(){
    return array();
}