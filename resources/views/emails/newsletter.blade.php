<?php
$lang = LaravelLocalization::getCurrentLocale() ;
if ($lang == "en") {
    $font = "Open Sans";
    $dir = "ltr";
    $img_right = "right";
    $img_left = "left";
} else {
    $font = "Tahoma";
    $dir = "rtl";
    $img_right = "left";
    $img_left = "right";
}
?>

@extends('emails.layout')

@section('content')

<h2><?php echo $title; ?></h2>

<p><?php echo $content ; ?></p>

<div class="br-30"></div>

@endsection
