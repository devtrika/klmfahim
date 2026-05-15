<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use File;

class Site extends Model {

    protected $table = 'site';

    //
    public function getData() {
        return $this->first();
    }

    public function edit($data, $logo = false, $first = false, $second = false, $third = false, $footer = false,$video=false) {
        $site = $this->first();
        $site->ar_title = $data['ar_title'];
        $site->en_title = $data['en_title'];
        $site->ar_address = $data['ar_address'];
        $site->en_address = $data['en_address'];
        $site->ar__address = $data['ar__address'];
        $site->en__address = $data['en__address'];
        $site->tags = $data['tags'];
        $site->base = $data['base'];
        $site->branches = $data['branches'];
        $site->structure = $data['structure'];
        $site->mantis = $data['mantis'];
        $site->email = $data['email'];
        $site->phone = $data['phone'];
        $site->mobile = $data['mobile'];
        $site->fax = $data['fax'] ?? 0;
        $site->facebook = $data['facebook'];
        $site->twitter = $data['twitter'];
        $site->google = $data['google'];
        $site->youtube = $data['youtube'];
        $site->instagram = $data['instagram'];
        $site->linkedin = $data['linkedin'];
        $site->desc = $data['desc'];
        $site->whatsapp = $data['whatsapp'];
        $site->ar_footerword = $data['ar_footerword'];
        $site->en_footerword = $data['en_footerword'];
        $site->lat = $data['lat'];
        $site->lng = $data['lng'];
        $site->ar_office = $data['ar_office'];
        $site->en_office = $data['en_office'];
        $site->second = $data['second'];
        $site->first = $data['first'];
        if ($logo) {
            $path = public_path('upload/');
            $filename = $site->logo;
            File::Delete($path . $filename);
            $site->logo = $logo;
        }
        if ($video) {
            $path = public_path('upload/');
            $filename = $site->video;
            File::Delete($path . $filename);
            $site->video = $video;
        }
        
        if ($first) {
            $path = public_path('upload/');
            $filename = $site->first;
            File::Delete($path . $filename);
            $site->first = $first;
        }
        if ($second) {
            $path = public_path('upload/');
            $filename = $site->second;
            File::Delete($path . $filename);
            $site->second = $second;
        }
        if ($third) {
            $path = public_path('upload/');
            $filename = $site->third;
            File::Delete($path . $filename);
            $site->third = $third;
        }
        if ($footer) {
            $path = public_path('upload/');
            $filename = $site->$footer;
            File::Delete($path . $filename);
            $site->footer = $footer;
        }
        return $site->save();
    }
}
