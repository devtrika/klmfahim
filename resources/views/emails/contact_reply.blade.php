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

<h5><?php echo $title; ?></h5>

<ul class="list clearfix">
    <li><p><strong></strong></p></li>
    <li><p><strong><?php echo trans('layout.reply'); ?> : </strong> <?php echo $reply; ?></p></li>
    <li><p><strong><?php echo trans('layout.name'); ?> : </strong> <?php echo $name; ?></p></li>
    <li><p><strong><?php echo trans('layout.email'); ?> : </strong> <?php echo $email; ?></p></li>
    <li><p><strong><?php echo trans('layout.phone'); ?> : </strong> <?php echo $phone; ?></p></li>
    <li><p><strong><?php echo trans('layout.message'); ?> : </strong> <?php echo $messagee; ?></p></li>
</ul>

<div class="br-30"></div>

@endsection