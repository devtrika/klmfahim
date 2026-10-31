<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
Use File;

class Site extends Model {

    protected $table = 'site';

    /** Defaults used to create the settings row on a fresh database. */
    public const DEFAULTS = [
        'ar_title' => 'كلم فهيم', 'en_title' => 'Call Fahim',
        'ar_slogan' => 'تأسيس الشركات وخدمات الأعمال', 'en_slogan' => 'Business Formation & Setup',
        'ar_address' => 'دبي، الإمارات العربية المتحدة', 'en_address' => 'Dubai, United Arab Emirates',
        'ar_footerword' => 'كلم فهيم شريكك في تأسيس شركتك في الإمارات من أول فكرة لحد الرخصة والإقامة والحساب البنكي، بخطوات واضحة وأسعار شفافة.',
        'en_footerword' => 'Call Fahim is your partner for setting up a business in the UAE — from the first idea to the licence, residence visa and bank account, with clear steps and transparent pricing.',
        'tags' => 'business setup, UAE, Dubai', 'email' => '', 'phone' => '', 'mobile' => '', 'fax' => '0',
        'facebook' => '', 'twitter' => '', 'google' => '', 'youtube' => '', 'instagram' => '', 'whatsapp' => '',
        'currency' => 'AED', 'vat_rate' => 5, 'base' => 0, 'branches' => 0, 'structure' => 0, 'mantis' => 0,
    ];

    /** The settings row, or unsaved defaults when the table is still empty. */
    public static function current(): self
    {
        static $site;

        return $site ??= static::query()->first() ?? (new static)->forceFill(static::DEFAULTS);
    }

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
        foreach (['ar_slogan', 'en_slogan', 'trn', 'vat_rate'] as $field) {
            if (isset($data[$field])) {
                $site->$field = $data[$field];
            }
        }
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
