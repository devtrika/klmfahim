<?php

namespace Database\Seeders;

use App\Models\CalculatorItem;
use App\Models\Client;
use App\Models\Feature;
use App\Models\Permission;
use App\Models\Service;
use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Starter content for the business-setup website. Safe to re-run: every
 * table it fills is only seeded while still empty.
 */
class BusinessSetupSeeder extends Seeder
{
    public function run(): void
    {
        $this->site();
        $this->services();
        $this->governmentServices();
        $this->features();
        $this->calculator();
        $this->partners();
        $this->opinions();
        $this->posts();
        $this->pages();
        $this->permissions();
        $this->fillUuids();
    }

    /** Rows inserted with DB::table() skip model events, so give them a uuid here. */
    private function fillUuids(): void
    {
        foreach (['services', 'clients', 'opinions'] as $table) {
            DB::table($table)->whereNull('uuid')->pluck('id')->each(
                fn ($id) => DB::table($table)->where('id', $id)->update(['uuid' => (string) \Illuminate\Support\Str::uuid()])
            );
        }
    }

    private function site(): void
    {
        // Fresh database: create the settings row and the top admin group.
        if (! Site::query()->exists()) {
            DB::table('site')->insert(Site::DEFAULTS + ['id' => 1, 'created_at' => now(), 'updated_at' => now()]);
        }
        $superGroup = (int) config('permissions.super_group');
        if (! DB::table('groups')->where('id', $superGroup)->exists()) {
            DB::table('groups')->insert(['id' => $superGroup, 'ar_name' => 'الإدارة العليا', 'en_name' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()]);
        }

        // Fill contact details and stats that are still blank or zero; values
        // already entered in the admin panel are left alone.
        $site = Site::query()->first();
        $blank = [];
        foreach (['email', 'phone', 'mobile', 'whatsapp', 'lat', 'base', 'branches', 'structure', 'mantis'] as $field) {
            if (blank($site->$field) || $site->$field === 0 || $site->$field === '0') {
                $blank[$field] = Site::DEFAULTS[$field];
            }
        }
        if ($blank) {
            DB::table('site')->where('id', $site->id)->update($blank);
        }

        // The header/footer logos come from the settings; until one is uploaded
        // (or while they still hold the original wide logo) use the brand files.
        foreach (['logo' => 'brand/mark.png', 'footer' => 'brand/logo-light.png'] as $field => $default) {
            if (blank($site->$field) || str_ends_with($site->$field, '.callFahim.png') || ! is_file(public_path($site->$field))) {
                DB::table('site')->where('id', $site->id)->update([$field => $default]);
            }
        }

        // First run only: after that the site settings belong to the admin panel.
        if (Site::query()->whereKey(1)->whereNotNull('en_slogan')->exists()) {
            return;
        }

        Site::query()->whereKey(1)->update([
            'ar_title' => 'كلم فهيم',
            'en_title' => 'Call Fahim',
            'ar_slogan' => 'تأسيس الشركات وخدمات الأعمال',
            'en_slogan' => 'Business Formation & Setup',
            'currency' => 'AED',
            'ar_address' => 'دبي، الإمارات العربية المتحدة',
            'en_address' => 'Dubai, United Arab Emirates',
            'ar_footerword' => 'كلم فهيم شريكك في تأسيس شركتك في الإمارات من أول فكرة لحد الرخصة والإقامة والحساب البنكي، بخطوات واضحة وأسعار شفافة.',
            'en_footerword' => 'Call Fahim is your partner for setting up a business in the UAE — from the first idea to the licence, residence visa and bank account, with clear steps and transparent pricing.',
            'base' => 1890,
            'branches' => 12,
            'structure' => 50,
            'mantis' => 60,
        ]);
    }

    private function services(): void
    {
        if (Service::query()->exists()) {
            return;
        }

        $rows = [
            ['setup', 'fa-solid fa-building-flag', 'تأسيس شركة في المنطقة الحرة', 'Free Zone Company Setup', 'ملكية أجنبية 100% وإعفاءات ضريبية وإجراءات سريعة.', '100% foreign ownership, tax benefits and fast processing.'],
            ['setup', 'fa-solid fa-city', 'تأسيس شركة في البر الرئيسي', 'Mainland Company Setup', 'اشتغل في كل أسواق الإمارات ومع الجهات الحكومية بدون قيود.', 'Trade anywhere in the UAE and work with government clients.'],
            ['setup', 'fa-solid fa-earth-americas', 'تأسيس شركة أوفشور', 'Offshore Company Setup', 'هيكل مثالي لحماية الأصول وإدارة الاستثمارات الدولية.', 'An ideal structure for asset protection and international holdings.'],
            ['setup', 'fa-solid fa-file-signature', 'إصدار وتجديد الرخص التجارية', 'Trade Licence Issuing & Renewal', 'نختار لك النشاط والرخصة المناسبة ونتابع التجديد في معاده.', 'We pick the right activity and licence and handle renewals on time.'],
            ['corporate', 'fa-solid fa-passport', 'التأشيرة الذهبية', 'Golden Visa', 'إقامة طويلة لـ 10 سنوات للمستثمرين ورواد الأعمال وعائلاتهم.', '10-year residency for investors, entrepreneurs and their families.'],
            ['government', 'fa-solid fa-id-card', 'الهوية الإماراتية', 'Emirates ID', 'تقديم طلب الهوية والبصمة والتجديد من غير زحمة.', 'Emirates ID application, biometrics and renewal without the queues.'],
            ['corporate', 'fa-solid fa-building-columns', 'فتح الحساب البنكي', 'Bank Account Opening', 'علاقات مع أكبر البنوك في الإمارات لفتح حساب شركتك بسرعة.', 'Strong ties with leading UAE banks to open your corporate account fast.'],
            ['corporate', 'fa-solid fa-calculator', 'المحاسبة ومسك الدفاتر', 'Accounting & Bookkeeping', 'تقارير مالية دقيقة ومتابعة شهرية بواسطة محاسبين معتمدين.', 'Accurate financial reporting and monthly follow-up by certified accountants.'],
            ['corporate', 'fa-solid fa-percent', 'الضريبة على الشركات وضريبة القيمة المضافة', 'Corporate Tax & VAT', 'تسجيل وإقرارات ضريبية متوافقة مع الهيئة الاتحادية للضرائب.', 'Registration and filings fully compliant with the Federal Tax Authority.'],
            ['corporate', 'fa-solid fa-user-tie', 'خدمات المندوب PRO', 'PRO Services', 'نخلص معاملاتك الحكومية بدل ما تضيع وقتك في الطوابير.', 'We handle your government paperwork so you never wait in line.'],
            ['corporate', 'fa-solid fa-copyright', 'تسجيل العلامات التجارية', 'Trademark Registration', 'احمِ اسمك وعلامتك التجارية داخل الإمارات وخارجها.', 'Protect your brand name and identity in the UAE and abroad.'],
            ['corporate', 'fa-solid fa-scale-balanced', 'الخدمات القانونية والامتثال', 'Legal & Compliance', 'عقود التأسيس، المستفيد الحقيقي UBO، والامتثال المستمر.', 'MOA drafting, UBO filings and ongoing compliance support.'],
        ];

        foreach ($rows as $i => [$category, $icon, $arTitle, $enTitle, $arShort, $enShort]) {
            DB::table('services')->insert([
                'category' => $category,
                'icon' => $icon,
                'ar_title' => $arTitle,
                'en_title' => $enTitle,
                'ar_short' => $arShort,
                'en_short' => $enShort,
                'ar_desc' => "<p>{$arShort}</p><p>فريق كلم فهيم بيتابع معاك كل خطوة من أول الاستشارة المجانية لحد استلام المستندات النهائية، مع مدير علاقة مخصص ليك.</p>",
                'en_desc' => "<p>{$enShort}</p><p>The Call Fahim team follows every step with you, from the free consultation to the final documents, with a dedicated relationship manager.</p>",
                'sort' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function governmentServices(): void
    {
        // First run only, so later category changes made in the admin stick.
        if (Service::query()->where('en_title', 'Residency & Visas (Amer)')->exists()) {
            return;
        }

        // Licensing, residency and PRO work are government transactions.
        Service::query()->whereIn('en_title', ['Trade Licence Issuing & Renewal', 'PRO Services'])
            ->update(['category' => 'government']);

        $rows = [
            ['fa-solid fa-passport', 'الإقامات والتأشيرات (عامر)', 'Residency & Visas (Amer)', 'إصدار وتجديد وإلغاء الإقامات وتأشيرات الدخول في دبي وكل الإمارات.', 'Issue, renew and cancel residence and entry visas in Dubai and all emirates.'],
            ['fa-solid fa-file-contract', 'عقود العمل وبطاقة المنشأة (تسهيل)', 'Labour Contracts & Establishment Card (Tasheel)', 'إصدار وتجديد وإلغاء عقود العمل وتسجيل المنشأة لدى وزارة الموارد البشرية.', 'Issue, renew and cancel labour contracts and register your company with MOHRE.'],
            ['fa-solid fa-stethoscope', 'الفحص الطبي للإقامة', 'Residency Medical Test', 'حجز وإنجاز الفحص الطبي للإقامة، مع إمكانية الفحص في مكانك.', 'Book and complete your residency medical test, with an at-your-door option.'],
            ['fa-solid fa-notes-medical', 'البطاقة الصحية وشهادات الميلاد', 'Health Cards & Birth Certificates', 'استخراج البطاقة الصحية وشهادات الميلاد والفحوصات الطبية للسفارات.', 'Health cards, birth certificates and embassy medical tests.'],
            ['fa-solid fa-stamp', 'تصديق المستندات', 'Document Attestation', 'تصديق الشهادات والمستندات من الخارجية والسفارات لكل الجنسيات.', 'Attestation of certificates and documents with MOFA and embassies for all nationalities.'],
            ['fa-solid fa-language', 'الترجمة القانونية المعتمدة', 'Certified Legal Translation', 'ترجمة قانونية معتمدة للمستندات الحكومية والتجارية والشخصية.', 'Certified legal translation of government, corporate and personal documents.'],
            ['fa-solid fa-car', 'خدمات المرور وهيئة الطرق', 'Traffic & RTA Services', 'تسجيل الملف المروري، تجديد رخص القيادة، وتصاريح إعلانات المركبات.', 'Traffic file registration, driving licence renewal and vehicle advertising permits.'],
            ['fa-solid fa-house-medical', 'تراخيص وزارة الصحة', 'Ministry of Health Licensing', 'ترخيص العيادات والصيدليات والمستودعات والمهنيين الصحيين.', 'Licensing for clinics, pharmacies, warehouses and healthcare professionals.'],
            ['fa-solid fa-building-user', 'خدمات العقارات وعقود الإيجار', 'Real Estate & Tenancy Services', 'تسجيل عقود الإيجار وخدمات الملاك والمستأجرين.', 'Tenancy contract registration and services for landlords and tenants.'],
            ['fa-solid fa-shield-heart', 'التأمين الصحي وتأمين الشركات', 'Health & Business Insurance', 'تأمين صحي إلزامي للموظفين وتأمين على الشركات والمركبات.', 'Mandatory employee health cover plus business and motor insurance.'],
        ];

        $sort = (int) Service::query()->max('sort');
        foreach ($rows as [$icon, $arTitle, $enTitle, $arShort, $enShort]) {
            DB::table('services')->insert([
                'category' => 'government',
                'icon' => $icon,
                'ar_title' => $arTitle,
                'en_title' => $enTitle,
                'ar_short' => $arShort,
                'en_short' => $enShort,
                'ar_desc' => "<p>{$arShort}</p><p>بنخلّص المعاملة بالنيابة عنك من غير ما تروح أي مركز، ونتابع معاك على واتساب لحد ما تستلم المستند النهائي.</p>",
                'en_desc' => "<p>{$enShort}</p><p>We complete the transaction on your behalf without you visiting any centre, and keep you updated on WhatsApp until you receive the final document.</p>",
                'sort' => ++$sort,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function features(): void
    {
        if (Feature::query()->exists()) {
            return;
        }

        $rows = [
            ['الرخصة التجارية (سنة)', 'Trade License (1 year)'],
            ['تسجيل الشركة', 'Company Registration'],
            ['استخراج تأشيرة الإقامة', 'Residence Visa Processing'],
            ['استخراج الهوية الإماراتية', 'Emirates ID Processing'],
            ['بطاقة المنشأة', 'Establishment Card'],
            ['بطاقة الهجرة', 'Immigration Card'],
            ['التسجيل في ضريبة الشركات', 'Corporate Tax Registration'],
            ['المساعدة في فتح الحساب البنكي', 'Bank Account Assistance'],
            ['خدمات المندوب والتواصل الحكومي', 'PRO Services & Govt Liaison'],
            ['تصديق المستندات', 'Document Attestation'],
            ['حجز الاسم التجاري', 'Trade Name Reservation'],
            ['صياغة عقد التأسيس والنظام الأساسي', 'MOA / AOA Drafting'],
            ['مدير علاقة مخصص', 'Dedicated Relationship Manager'],
            ['متابعة طلبك أول بأول على واتساب', 'Live Updates on WhatsApp'],
            ['مكتب افتراضي / مرن / فعلي', 'Virtual / Flexi / Physical Office'],
            ['دعم مستمر في الامتثال', 'Ongoing Compliance Support'],
        ];

        foreach ($rows as $i => [$ar, $en]) {
            Feature::create(['ar_title' => $ar, 'en_title' => $en, 'sort' => $i + 1]);
        }
    }

    private function calculator(): void
    {
        if (CalculatorItem::query()->exists()) {
            return;
        }

        $rows = [
            ['jurisdiction', 'منطقة حرة', 'Free Zone', 'ملكية 100% وتكلفة أقل', '100% ownership, lower cost', 5750],
            ['jurisdiction', 'البر الرئيسي', 'Mainland', 'اشتغل في كل الإمارات', 'Trade across the UAE', 12500],
            ['jurisdiction', 'أوفشور', 'Offshore', 'للاستثمار وحماية الأصول', 'Holding & asset protection', 9500],

            ['activity', 'تجاري', 'Commercial / Trading', 'استيراد، تصدير، تجارة عامة', 'Import, export, general trading', 0],
            ['activity', 'خدمي / مهني', 'Services / Professional', 'استشارات، تسويق، تقنية', 'Consulting, marketing, IT', 0],
            ['activity', 'صناعي', 'Industrial', 'تصنيع وتجميع', 'Manufacturing & assembly', 3500],
            ['activity', 'تجارة إلكترونية', 'E-commerce', 'متجر إلكتروني وبيع أونلاين', 'Online store & marketplace', 1500],

            ['office', 'مكتب افتراضي', 'Virtual Office', 'عنوان رسمي بدون مساحة', 'Official address, no space', 0],
            ['office', 'مكتب مرن (Flexi Desk)', 'Flexi Desk', 'مساحة عمل مشتركة', 'Shared co-working space', 4500],
            ['office', 'مكتب خاص', 'Private Office', 'مكتب مستقل لفريقك', 'Dedicated space for your team', 18000],

            ['visa', 'تأشيرة إقامة', 'Residence Visa', 'لكل تأشيرة مستثمر أو موظف', 'Per investor or employee visa', 3750],
            ['shareholder', 'شريك إضافي', 'Additional Shareholder', 'أول شريك مشمول في الرخصة', 'First shareholder included', 1500],

            ['extra', 'فتح حساب بنكي', 'Bank Account Opening', null, null, 1500],
            ['extra', 'التسجيل الضريبي', 'Corporate Tax & VAT Registration', null, null, 1200],
            ['extra', 'محاسبة سنوية', 'Annual Bookkeeping', null, null, 6000],
            ['extra', 'تسجيل علامة تجارية', 'Trademark Registration', null, null, 7500],
        ];

        foreach ($rows as $i => [$group, $ar, $en, $arHint, $enHint, $price]) {
            CalculatorItem::create([
                'group' => $group, 'ar_title' => $ar, 'en_title' => $en,
                'ar_hint' => $arHint, 'en_hint' => $enHint, 'price' => $price, 'sort' => $i + 1,
            ]);
        }
    }

    private function partners(): void
    {
        $rows = [
            ['دائرة الاقتصاد والسياحة بدبي', 'Dubai Economy & Tourism'],
            ['مركز دبي للسلع المتعددة', 'DMCC'],
            ['المنطقة الحرة بمدينة ميدان', 'Meydan Free Zone'],
            ['المنطقة الحرة لواحات دبي للسيليكون', 'IFZA'],
            ['منطقة رأس الخيمة الاقتصادية', 'RAKEZ'],
            ['مدينة الشارقة للإعلام', 'SHAMS'],
            ['المنطقة الحرة لجبل علي', 'JAFZA'],
            ['سوق أبوظبي العالمي', 'ADGM'],
            ['المنطقة الحرة بعجمان', 'Ajman Free Zone'],
            ['منطقة SPC الحرة', 'SPC Free Zone'],
        ];

        foreach ($rows as [$ar, $en]) {
            if (Client::query()->where('en_title', $en)->exists()) {
                continue;
            }
            DB::table('clients')->insert([
                'ar_title' => $ar, 'en_title' => $en, 'image' => null, 'href' => null,
                'ar_desc' => null, 'en_desc' => null, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    /** About / privacy / terms pages, first run only. "up" pages show in the header, "down" in the footer. */
    /** Sample testimonials, only while the table is empty — edit or replace them from the admin. */
    private function opinions(): void
    {
        if (DB::table('opinions')->exists()) {
            return;
        }

        $rows = [
            ['أحمد المنصوري', 'Ahmed Al Mansouri',
                'خدمة ممتازة من أول مكالمة. الأستاذ إسلام تعامل معانا كأخ وكان بيحاول يساعدنا في كل مشكلة لحد ما الرخصة طلعت.',
                'Excellent service from the very first call. Mr. Islam treated us like a brother and helped us through every problem until our licence was issued.'],
            ['James Whitmore', 'James Whitmore',
                'أسست شركتي في منطقة حرة بدون ما أسافر دبي ولا مرة. كل خطوة كانت واضحة والتكلفة زي ما اتقالت بالظبط.',
                'I set up my free zone company without flying to Dubai once. Every step was clear and the final cost matched the quote exactly.'],
            ['محمد عبد الرحمن', 'Mohamed Abdelrahman',
                'كنت قلقان من موضوع الإقامة والفيزا لعيلتي، لكن فريق كلم فهيم خلص كل الورق في وقت قياسي. شكراً أستاذ إسلام على المتابعة اليومية.',
                'I was worried about residency visas for my family, but the Call Fahim team finished all the paperwork in record time. Thank you Mr. Islam for the daily follow-up.'],
            ['Elena Petrova', 'Elena Petrova',
                'تعامل احترافي وسرعة في الرد على الواتساب. ساعدونا في فتح الحساب البنكي وده كان أصعب جزء.',
                'Professional and quick to answer on WhatsApp. They helped us open our corporate bank account, which was the hardest part.'],
            ['سارة الحمادي', 'Sara Al Hammadi',
                'نقلنا رخصتنا من البر الرئيسي وجددنا كل المعاملات الحكومية من غير ما نروح أي مركز. خدمة تستاهل كل درهم.',
                'We moved our mainland licence and renewed all our government transactions without visiting a single centre. Worth every dirham.'],
            ['Rahul Mehta', 'Rahul Mehta',
                'نصحوني بالكيان الأنسب لنشاطي ووفروا عليّ مصاريف كنت هدفعها على الفاضي. أنصح بيهم أي حد عاوز يبدأ في الإمارات.',
                'They advised the right entity for my activity and saved me costs I would have paid for nothing. I recommend them to anyone starting in the UAE.'],
        ];

        foreach ($rows as $i => [$arName, $enName, $ar, $en]) {
            DB::table('opinions')->insert([
                'ar_title' => $arName, 'en_title' => $enName, 'image' => '', 'href' => null,
                'ar_desc' => $ar, 'en_desc' => $en,
                'created_at' => now()->subDays(count($rows) - $i), 'updated_at' => now(),
            ]);
        }
    }

    private function pages(): void
    {
        if (DB::table('pages')->exists()) {
            return;
        }

        $rows = [
            ['up', 'من نحن', 'About us',
                '<p>كلم فهيم شركة متخصصة في تأسيس الشركات وخدمات الأعمال في الإمارات العربية المتحدة. بنساعد رواد الأعمال والمستثمرين يبدأوا شغلهم بسرعة ومن غير تعقيد، من اختيار النشاط والمنطقة المناسبة لحد استلام الرخصة والإقامة وفتح الحساب البنكي.</p><h3>رسالتنا</h3><p>إن تأسيس شركتك يبقى تجربة واضحة: أسعار معلنة، خطوات مفهومة، وفريق بيرد عليك في نفس اليوم.</p><h3>ليه كلم فهيم؟</h3><ul><li>خبرة في المناطق الحرة والبر الرئيسي والأوفشور.</li><li>إنجاز المعاملات الحكومية بالنيابة عنك.</li><li>مدير علاقة مخصص ومتابعة على واتساب.</li></ul>',
                '<p>Call Fahim specialises in company formation and business services in the United Arab Emirates. We help entrepreneurs and investors start trading quickly and without hassle, from choosing the right activity and zone to receiving the licence, residence visa and bank account.</p><h3>Our mission</h3><p>Make setting up your company a clear experience: published prices, understandable steps and a team that replies the same day.</p><h3>Why Call Fahim?</h3><ul><li>Experience across free zones, mainland and offshore.</li><li>Government transactions handled on your behalf.</li><li>A dedicated relationship manager and WhatsApp updates.</li></ul>'],
            ['down', 'سياسة الخصوصية', 'Privacy policy',
                '<p>بنجمع البيانات اللي بتبعتها لنا بنفسك بس، زي الاسم ورقم الموبايل والإيميل وتفاصيل حاسبة التكلفة، وبنستخدمها عشان نتواصل معاك ونجهز عرض السعر وننفذ الخدمات اللي طلبتها.</p><p>مش بنبيع بياناتك لأي طرف. ممكن نشاركها مع الجهات الحكومية أو المناطق الحرة أو البنوك بالقدر اللازم لإنجاز معاملتك فقط.</p><p>تقدر تطلب تعديل بياناتك أو مسحها في أي وقت عن طريق التواصل معانا.</p>',
                '<p>We only collect the data you send us yourself, such as your name, mobile number, email and cost calculator details, and use it to contact you, prepare your quote and deliver the services you request.</p><p>We never sell your data. We may share it with government authorities, free zones or banks only as far as needed to complete your transaction.</p><p>You can ask us to update or delete your data at any time by contacting us.</p>'],
            ['down', 'الشروط والأحكام', 'Terms & conditions',
                '<p>الأسعار المعروضة في حاسبة التكلفة تقديرية، والسعر النهائي بيتأكد في عرض سعر مكتوب بعد الاستشارة.</p><p>الرسوم الحكومية ورسوم المناطق الحرة بتتحدد من الجهات المختصة وممكن تتغير من وقت للتاني.</p><p>مدد الإنجاز تقريبية وبتعتمد على اكتمال المستندات وموافقات الجهات المختصة.</p>',
                '<p>Prices shown in the cost calculator are estimates; the final price is confirmed in a written quotation after your consultation.</p><p>Government and free zone fees are set by the relevant authorities and may change from time to time.</p><p>Processing times are approximate and depend on complete documents and approvals from the relevant authorities.</p>'],
        ];

        foreach ($rows as [$dept, $arTitle, $enTitle, $arDesc, $enDesc]) {
            DB::table('pages')->insert([
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
                'dept' => $dept, 'ar_title' => $arTitle, 'en_title' => $enTitle,
                'ar_desc' => $arDesc, 'en_desc' => $enDesc, 'image' => '',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    private function posts(): void
    {
        if (DB::table('blogs')->exists()) {
            return;
        }

        $rows = [
            [
                'كيف تختار بين المنطقة الحرة والبر الرئيسي؟',
                'Free Zone or Mainland: which one fits your business?',
                '<p>المنطقة الحرة بتديك ملكية أجنبية كاملة وتكلفة بداية أقل، وده مناسب للخدمات والتجارة الدولية والشركات الناشئة. البر الرئيسي بيسمحلك تبيع لأي عميل في الإمارات وتشتغل مع الجهات الحكومية بدون وسيط.</p><p>لو أغلب عملائك جوه الدولة أو محتاج محل فعلي، البر الرئيسي غالبًا الأنسب. ولو شغلك أونلاين أو مع عملاء برة الإمارات، المنطقة الحرة بتوفرلك كتير. احسب الاتنين في حاسبة التكلفة وقارن بنفسك.</p>',
                '<p>A free zone gives you full foreign ownership and a lower starting cost, which suits services, international trade and start-ups. A mainland company lets you sell to any customer in the UAE and work with government entities directly.</p><p>If most of your clients are inside the country or you need a physical shop, mainland is usually the better fit. If you work online or with clients abroad, a free zone saves a lot. Price both in the cost calculator and compare.</p>',
            ],
            [
                'خطوات استخراج تأشيرة الإقامة لمستثمر في الإمارات',
                'How the UAE investor residence visa works, step by step',
                '<p>بعد إصدار الرخصة والبطاقة المنشأة، بنقدّم على تصريح الدخول، وبعدها الفحص الطبي والبصمة للهوية الإماراتية، وفي الآخر بتتختم الإقامة.</p><p>العملية بتاخد في المتوسط من أسبوعين لتلات أسابيع، وفريقنا بيتابعها خطوة بخطوة ويبعتلك التحديثات على واتساب.</p>',
                '<p>Once the licence and establishment card are issued, we apply for the entry permit, then complete the medical test and Emirates ID biometrics, and finally the residence visa is stamped.</p><p>The process usually takes two to three weeks, and our team follows every step and sends you updates on WhatsApp.</p>',
            ],
            [
                'التسجيل في ضريبة الشركات: إيه المطلوب منك؟',
                'Corporate tax registration: what you need to know',
                '<p>كل شركة في الإمارات لازم تتسجل في ضريبة الشركات لدى الهيئة الاتحادية للضرائب، حتى لو أرباحها تحت الحد المعفى. التأخير في التسجيل عليه غرامة.</p><p>محتاج الرخصة التجارية وعقد التأسيس وبيانات الملاك، واحنا بنخلّص التسجيل والإقرارات بالنيابة عنك.</p>',
                '<p>Every company in the UAE must register for corporate tax with the Federal Tax Authority, even if its profit is below the exempt threshold, and late registration carries a penalty.</p><p>You need your trade licence, memorandum of association and owner details, and we can complete the registration and filings on your behalf.</p>',
            ],
        ];

        foreach ($rows as $i => [$arTitle, $enTitle, $arDesc, $enDesc]) {
            DB::table('blogs')->insert([
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
                'ar_title' => $arTitle, 'en_title' => $enTitle, 'ar_desc' => $arDesc, 'en_desc' => $enDesc,
                'image' => '', 'active' => 'yes', 'views' => 0,
                'created_at' => now()->subDays(3 - $i), 'updated_at' => now(),
            ]);
        }
    }

    private function permissions(): void
    {
        $modules = config('permissions.modules');
        $grant = function (int $groupId, array $permissions) {
            $have = Permission::query()->where('group_id', $groupId)->pluck('permission')->all();
            $rows = array_map(fn ($p) => ['group_id' => $groupId, 'permission' => $p, 'created_at' => now(), 'updated_at' => now()],
                array_values(array_diff(array_unique($permissions), $have)));
            DB::table('permissions')->insert($rows);
        };

        // The top admin group gets everything.
        $grant((int) config('permissions.super_group'), all_permissions());

        // Other groups keep what they could already open, now with that
        // module's add/edit/delete actions spelled out.
        $groups = \App\Models\Group::query()->pluck('id');
        foreach ($groups as $groupId) {
            $granted = [];
            foreach (Permission::query()->where('group_id', $groupId)->pluck('permission') as $p) {
                if (isset($modules[$p])) {
                    foreach ($modules[$p]['actions'] as $action) {
                        $granted[] = $p.'_'.$action;
                    }
                }
            }
            $grant($groupId, $granted);
        }
    }
}
