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
        'tags' => 'business setup, UAE, Dubai', 'fax' => '0',
        // Contact details used until they are changed in the admin panel.
        'email' => 'bettercallfahim@gmail.com', 'phone' => '+971 52 521 5982', 'mobile' => '+971 52 521 5982',
        'whatsapp' => 'https://wa.me/971525215982',
        'lat' => 'https://www.google.com/maps?q=Dubai%2C%20United%20Arab%20Emirates&output=embed',
        'facebook' => '', 'twitter' => '', 'google' => '', 'youtube' => '', 'instagram' => '',
        'currency' => 'AED', 'vat_rate' => 5, 'base' => 1890, 'branches' => 12, 'structure' => 50, 'mantis' => 60,
    ];

    /** The settings row, or unsaved defaults when the table is still empty. */
    public static function current(): self
    {
        static $site;

        return $site ??= static::query()->first() ?? (new static)->forceFill(static::DEFAULTS);
    }

    /** Square mark used in the header, admin and favicon. */
    public function logoUrl(): string
    {
        return $this->fileUrl('logo', 'brand/mark.png');
    }

    /** Light logo shown on dark backgrounds (footer, admin login). */
    public function footerLogoUrl(): string
    {
        return $this->fileUrl('footer', 'brand/logo-light.png');
    }

    private function fileUrl(string $field, string $fallback): string
    {
        $file = $this->$field;

        return asset($file && is_file(public_path($file)) ? $file : $fallback).'?v='.substr(md5((string) $file), 0, 6);
    }

    /** Uploads live in public/; the bundled brand files are never deleted. */
    private function dropFile(?string $file): void
    {
        if ($file && ! str_starts_with($file, 'brand/')) {
            File::delete(public_path($file));
        }
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
            $this->dropFile($site->logo);
            $site->logo = $logo;
        }
        if ($video) {
            $this->dropFile($site->video);
            $site->video = $video;
        }
        
        if ($first) {
            $this->dropFile($site->first);
            $site->first = $first;
        }
        if ($second) {
            $this->dropFile($site->second);
            $site->second = $second;
        }
        if ($third) {
            $this->dropFile($site->third);
            $site->third = $third;
        }
        if ($footer) {
            $this->dropFile($site->footer);
            $site->footer = $footer;
        }
        return $site->save();
    }
}
