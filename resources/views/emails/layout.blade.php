<!DOCTYPE html>
<?php
$site = \App\Site::first();
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
<!DOCTYPE html>
<html lang="ar" dir="rtl" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;">
    <head style="font-family: '<?php echo $font ; ?>', sans-serif;">
        <meta charset="utf-8" style="font-family: '<?php echo $font ; ?>', sans-serif;">
        <title style="font-family: '<?php echo $font ; ?>', sans-serif;">{{$site[$lang.'_title']}}</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css" style="font-family: '<?php echo $font ; ?>', sans-serif;">
        <style type="text/css" style="font-family: '<?php echo $font ; ?>', sans-serif;">

            @font-face{
                font-family:'<?php echo $font ; ?>';
                font-style:normal;
                font-weight:400;
                src:local('<?php echo $font ; ?>'),
                    local('OpenSans'),
                    url('http://fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3bO3LdcAZYWl9Si6vvxL-qU.woff') format('woff');
            }

            body {
                font-family: '<?php echo $font ; ?>', sans-serif;
            }
        </style>
    </head>
    <body style="font-family: '<?php echo $font ; ?>', sans-serif;font-family: '<?php echo $font ; ?>', sans-serif;direction: <?php echo $dir ; ?>;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;">
        <div class="all-wrapper" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;max-width: 600px;border: 1px solid #e4e4e4;overflow: hidden;">
            <div class="top-bar light-bg" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 20px 0;margin: 0px;border: 1px solid #e4e4e4;font-variant: normal;text-transform: none;speak: none;display: block;background-color: #f8f8f8;overflow: hidden;border-top: 0;text-align: center;-moz-border-radius: 0 0 99999px 99999px;-webkit-border-radius: 0 0 99999px 99999px;border-radius: 0 0 99999px 99999px;-moz-box-shadow: 0 0 20px 0 rgba(0,0,0,0.2);-webkit-box-shadow: 0 0 20px 0 rgba(0,0,0,0.2);box-shadow: 0 0 20px 0 rgba(0,0,0,0.2);">
                <div class="container clearfix" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;max-width: 100%;padding-right: 30px;padding-left: 30px;">
                    <a href="{{URL::to('/')}}" title="Eat Smart" class="logo" style="font-family: '<?php echo $font ; ?>', sans-serif;position: relative;color: #3d3d3d;outline: 0px;display: block;vertical-align: middle;margin: 0;text-decoration: none !important;"><img src="{{URL::to('emails')}}/images/logo.png" alt="Eat Smart" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;display: block;max-width: 100%;width: 40%;"></a>
                    <h1 style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: 700;font-style: inherit;font-size: 14px;line-height: 0.8;outline: 0px;padding: 0px;margin: 30px 0 0 0;border: 0px;font-variant: normal;text-transform: uppercase;speak: none;margin-bottom: 0;color: #9873a9;">Quick And Easy</h1>
                </div>
            </div>
            <!-- end of header -->

            <div class="main-contents  mini-50" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 50px 0;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;">
                <div class="container" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;max-width: 100%;padding-right: 30px;padding-left: 30px;">

                    @yield('content')

                </div>
            </div>
            <!-- end of main contents -->

            <div class="br-10" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;padding-bottom:1.6667%;"></div>
            <div class="footer" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 30px 0;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;display: block;text-align: center;background-color: #7ec244;">
                <div class="container" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;max-width: 100%;padding-right: 30px;padding-left: 30px;">
                    <div class="social" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;">
                        <a href="{{$site->facebook}}" style="font-family: '<?php echo $font ; ?>', sans-serif;position: relative;color: #fff;outline: 0px;font-size: 13px;font-style: italic;text-transform: uppercase;display: inline-block;vertical-align: middle;margin: 26px 10px;margin-top: 0;font-weight: 700;text-decoration: none !important;"><img src="{{URL::to('emails')}}/images/icon-facebook.png" alt="facebook" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;display: block;max-width: 100%;width: 20px;"></a>
                        <a href="{{$site->twitter}}" style="font-family: '<?php echo $font ; ?>', sans-serif;position: relative;color: #fff;outline: 0px;font-size: 13px;font-style: italic;text-transform: uppercase;display: inline-block;vertical-align: middle;margin: 26px 10px;margin-top: 0;font-weight: 700;text-decoration: none !important;"><img src="{{URL::to('emails')}}/images/icon-twitter.png" alt="twitter" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;display: block;max-width: 100%;width: 20px;"></a>
                        <a href="{{$site->instagram}}" style="font-family: '<?php echo $font ; ?>', sans-serif;position: relative;color: #fff;outline: 0px;font-size: 13px;font-style: italic;text-transform: uppercase;display: inline-block;vertical-align: middle;margin: 26px 10px;margin-top: 0;font-weight: 700;text-decoration: none !important;"><img src="{{URL::to('emails')}}/images/icon-instagram.png" alt="instagram" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;display: block;max-width: 100%;width: 20px;"></a>
                        <a href="{{$site->google}}" style="font-family: '<?php echo $font ; ?>', sans-serif;position: relative;color: #fff;outline: 0px;font-size: 13px;font-style: italic;text-transform: uppercase;display: inline-block;vertical-align: middle;margin: 26px 10px;margin-top: 0;font-weight: 700;text-decoration: none !important;"><img src="{{URL::to('emails')}}/images/icon-google.png" alt="google" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;display: block;max-width: 100%;width: 20px;"></a>
                        <a href="{{$site->youtube}}" style="font-family: '<?php echo $font ; ?>', sans-serif;position: relative;color: #fff;outline: 0px;font-size: 13px;font-style: italic;text-transform: uppercase;display: inline-block;vertical-align: middle;margin: 26px 10px;margin-top: 0;font-weight: 700;text-decoration: none !important;"><img src="{{URL::to('emails')}}/images/icon-youtube.png" alt="youtube" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: inherit;font-style: inherit;font-size: 100%;line-height: inherit;outline: 0px;padding: 0px;margin: 0 auto;border: 0px;font-variant: normal;text-transform: none;speak: none;display: block;max-width: 100%;width: 20px;"></a>
                    </div>
                    <p class="copyrights" style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: 400;font-style: inherit;font-size: 16px;line-height: 24px;outline: 0px;padding: 0px;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;color: #fff;margin-bottom: 0; "><strong style="font-family: '<?php echo $font ; ?>', sans-serif;vertical-align: baseline;font-weight: 700;font-style: inherit;font-size: inherit;line-height: inherit;outline: 0px;padding: 0px;margin: 0px;border: 0px;font-variant: normal;text-transform: none;speak: none;">Copyrights &copy; {{$site[$lang.'_title']}} {{date('Y')}}</strong></p>
                </div>
            </div>
            <!-- end of footer -->


        </div>
        <!-- end of all-wrapper -->

    </body>
</html>