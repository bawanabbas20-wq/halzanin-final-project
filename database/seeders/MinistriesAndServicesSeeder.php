<?php

namespace Database\Seeders;

use App\Models\Ministry;
use App\Models\Service;
use Illuminate\Database\Seeder;

class MinistriesAndServicesSeeder extends Seeder
{
    public function run(): void
    {
        $ministries = [

            [
                'name'    => 'Civil Registry',
                'name_ku' => 'تۆماری مەدەنی',
                'slug'    => 'civil-registry',
                'color'   => '#1B4F8A',
                'order'   => 1,
                'services' => [
                    [
                        'name'        => 'National ID Card',
                        'name_ku'     => 'کارتی نیشتیمانی',
                        'slug'        => 'national-id',
                        'description' => 'Apply for a new National ID card, renew an existing one, or replace a lost or damaged card.',
                        'description_ku' => 'داواکاری کارتی نیشتیمانی نوێ، نوێکردنەوە، یان جێگرتنەوەی کارتی وەندابوو.',
                        'is_active'   => true,
                        'estimated_days' => 10,
                        'statuses'    => ['submitted', 'documents_verified', 'under_processing', 'ready_for_pickup', 'completed'],
                        'required_documents' => [
                            'Birth certificate (scanned copy)',
                            'Family registry book (scanned copy)',
                            'Passport-size photo (JPG or PNG)',
                            'Current ID card (if renewal or replacement)',
                        ],
                        'form_schema' => [
                            ['name' => 'full_name',    'label' => 'Full Name',              'label_ku' => 'ناوی تەواو',            'type' => 'text',     'required' => true],
                            ['name' => 'dob',          'label' => 'Date of Birth',           'label_ku' => 'ڕێکەوتی لەدایکبوون',   'type' => 'date',     'required' => true],
                            ['name' => 'reason',       'label' => 'Reason for Application',  'label_ku' => 'هۆکاری داواکاری',       'type' => 'select',   'required' => true,
                                'options' => ['New Card', 'Renewal', 'Lost / Stolen']],
                            ['name' => 'address',      'label' => 'Current Home Address',    'label_ku' => 'ناونیشانی نیشتەجێبوون', 'type' => 'textarea', 'required' => true],
                        ],
                    ],
                    [
                        'name'        => 'Birth Certificate',
                        'name_ku'     => 'بەڵگەنامەی لەدایکبوون',
                        'slug'        => 'birth-certificate',
                        'description' => 'Request an official birth certificate for registration, travel, or legal purposes.',
                        'description_ku' => 'داواکاری بەڵگەنامەی فەرمی لەدایکبوون بۆ تۆمارکردن، گەشت، یان مەبەستی یاسایی.',
                        'is_active'   => true,
                        'estimated_days' => 7,
                        'statuses'    => ['submitted', 'documents_verified', 'under_processing', 'ready_for_pickup', 'completed'],
                        'required_documents' => [
                            'Parents\' National ID cards (scanned copies)',
                            'Hospital birth record or midwife statement',
                            'Family registry book (scanned copy)',
                        ],
                        'form_schema' => [
                            ['name' => 'child_name',    'label' => 'Child\'s Full Name',     'label_ku' => 'ناوی تەوایی منداڵ',    'type' => 'text',     'required' => true],
                            ['name' => 'dob',           'label' => 'Date of Birth',           'label_ku' => 'ڕێکەوتی لەدایکبوون',   'type' => 'date',     'required' => true],
                            ['name' => 'birth_place',   'label' => 'Place of Birth',          'label_ku' => 'شوێنی لەدایکبوون',     'type' => 'text',     'required' => true],
                            ['name' => 'father_name',   'label' => 'Father\'s Full Name',     'label_ku' => 'ناوی تەوایی باوک',     'type' => 'text',     'required' => true],
                            ['name' => 'mother_name',   'label' => 'Mother\'s Full Name',     'label_ku' => 'ناوی تەوایی دایک',     'type' => 'text',     'required' => true],
                        ],
                    ],
                    ['name' => 'Passport Application',   'name_ku' => 'داواکاری پاسپۆرت',   'slug' => 'passport',           'is_active' => false, 'estimated_days' => 21, 'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Valid National ID card (original + scanned copy)', 'Birth certificate (original + scanned copy)', 'Two recent biometric passport photos', 'Previous passport (if renewing)'], 'form_schema' => []],
                    ['name' => 'Marriage Certificate',   'name_ku' => 'بەڵگەنامەی نکاح',    'slug' => 'marriage-certificate','is_active' => false, 'estimated_days' => 14, 'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Both spouses\' National ID cards (scanned copies)', 'Court or religious ceremony official record', 'Two witnesses\' National IDs', 'Medical fitness certificates for both spouses'], 'form_schema' => []],
                    ['name' => 'Death Certificate',      'name_ku' => 'بەڵگەنامەی مردن',    'slug' => 'death-certificate',  'is_active' => false, 'estimated_days' => 7,  'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Medical death notification from the hospital or clinic', 'Deceased person\'s National ID', 'Applicant\'s National ID (next of kin)', 'Family registry book (scanned copy)'], 'form_schema' => []],
                ],
            ],

            [
                'name'    => 'Traffic Police',
                'name_ku' => 'پۆلیسی ترافیک',
                'slug'    => 'traffic-police',
                'color'   => '#dc2626',
                'order'   => 2,
                'services' => [
                    [
                        'name'        => 'Driving License',
                        'name_ku'     => 'مۆڵەتی شوفێری',
                        'slug'        => 'driving-license',
                        'description' => 'Apply for a new driving license or renew an existing one. A medical certificate and passing theory and practical tests are required.',
                        'description_ku' => 'داواکاری مۆڵەتی شوفێری نوێ یان نوێکردنەوەی مۆڵەتی کۆن. بەڵگەی تەندروستی و دەرباز بوون لە تاقیکردنەوەی تیۆری و کارامەیی پێویستە.',
                        'is_active'   => true,
                        'estimated_days' => 21,
                        'statuses'    => ['submitted', 'documents_verified', 'theory_test_scheduled', 'theory_test_passed', 'practical_test_scheduled', 'license_ready', 'collected'],
                        'required_documents' => [
                            'National ID card (scanned copy)',
                            'Medical fitness certificate from an approved clinic',
                            'Passport-size photo (JPG or PNG)',
                            'Current license (if renewal)',
                        ],
                        'form_schema' => [
                            ['name' => 'license_type',       'label' => 'License Type',              'label_ku' => 'جۆری مۆڵەت',            'type' => 'select',   'required' => true,
                                'options' => ['Motorcycle', 'Car', 'Heavy Vehicle']],
                            ['name' => 'application_type',   'label' => 'Application Type',          'label_ku' => 'جۆری داواکاری',          'type' => 'select',   'required' => true,
                                'options' => ['New License', 'Renewal']],
                            ['name' => 'medical_clinic',     'label' => 'Medical Clinic Name',       'label_ku' => 'ناوی کلینیکی پزیشکی',   'type' => 'text',     'required' => true],
                            ['name' => 'emergency_contact',  'label' => 'Emergency Contact (Name & Phone)', 'label_ku' => 'پەیوەندی فریاکەوتن', 'type' => 'text', 'required' => true],
                        ],
                    ],
                    ['name' => 'Vehicle Registration',   'name_ku' => 'تۆمارکردنی ئۆتۆمبێل', 'slug' => 'vehicle-registration', 'is_active' => false, 'estimated_days' => 14, 'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Vehicle ownership document (original)', 'Customs clearance certificate', 'Valid insurance policy', 'National ID of the owner'], 'form_schema' => []],
                    ['name' => 'Traffic Fine Payment',   'name_ku' => 'پارەدانی سزای ترافیک', 'slug' => 'traffic-fine',         'is_active' => false, 'estimated_days' => 3,  'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Vehicle plate number', 'National ID of the owner', 'Fine reference number (if known)'], 'form_schema' => []],
                ],
            ],

            [
                'name'    => 'Electricity Directorate',
                'name_ku' => 'بەرپرسایەتی کارەبا',
                'slug'    => 'electricity',
                'color'   => '#d97706',
                'order'   => 3,
                'services' => [
                    [
                        'name'        => 'New Connection Application',
                        'name_ku'     => 'داواکاری پەیوەندی نوێی کارەبا',
                        'slug'        => 'electricity-connection',
                        'description' => 'Apply for a new electricity connection for your residential or commercial property. A site inspection will be scheduled after document review.',
                        'description_ku' => 'داواکاری پەیوەندی کارەبای نوێ بۆ موڵکی نیشتەجێبوون یان بازرگانی. پاش پشکنینی بەڵگەنامەکان سەردانی شوێن داڕێژراودەبێت.',
                        'is_active'   => true,
                        'estimated_days' => 30,
                        'statuses'    => ['submitted', 'documents_reviewed', 'inspection_scheduled', 'inspection_completed', 'fee_assessed', 'installation_scheduled', 'connected'],
                        'required_documents' => [
                            'National ID card (scanned copy)',
                            'Property deed or rental contract',
                            'Building completion certificate',
                        ],
                        'form_schema' => [
                            ['name' => 'address',         'label' => 'Property Address',          'label_ku' => 'ناونیشانی موڵک',         'type' => 'textarea', 'required' => true],
                            ['name' => 'property_type',   'label' => 'Property Type',             'label_ku' => 'جۆری موڵک',              'type' => 'select',   'required' => true,
                                'options' => ['Residential', 'Commercial', 'Industrial']],
                            ['name' => 'requested_load',  'label' => 'Requested Load (KW)',       'label_ku' => 'بارەی داواکراو (کیلۆوات)', 'type' => 'number',  'required' => true],
                            ['name' => 'ownership',       'label' => 'Ownership Status',          'label_ku' => 'دۆخی خاوەندارایەتی',    'type' => 'select',   'required' => true,
                                'options' => ['Owner', 'Tenant']],
                            ['name' => 'floor_apt',       'label' => 'Floor / Apartment Number',  'label_ku' => 'ژمارەی نهۆم / شووشە',   'type' => 'text',     'required' => false],
                        ],
                    ],
                    ['name' => 'Service Complaint',    'name_ku' => 'گەلایی خزمەتگوزاری',  'slug' => 'electricity-complaint', 'is_active' => false, 'estimated_days' => 7,  'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Subscriber account number', 'National ID', 'Description of the issue'], 'form_schema' => []],
                    ['name' => 'Meter Reading Issue',  'name_ku' => 'کێشەی خوێندنەوەی مەتر', 'slug' => 'electricity-meter',  'is_active' => false, 'estimated_days' => 7,  'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Subscriber account number', 'National ID', 'Recent photo of the meter'], 'form_schema' => []],
                ],
            ],

            [
                'name'    => 'Water Directorate',
                'name_ku' => 'بەرپرسایەتی ئاو',
                'slug'    => 'water',
                'color'   => '#0284c7',
                'order'   => 4,
                'services' => [
                    [
                        'name'        => 'New Connection Application',
                        'name_ku'     => 'داواکاری پەیوەندی نوێی ئاو',
                        'slug'        => 'water-connection',
                        'description' => 'Apply for a new water connection for your property. A site inspection is required to assess feasibility and distance from the main line.',
                        'description_ku' => 'داواکاری پەیوەندی ئاوی نوێ بۆ موڵکەکەت. سەردانی شوێن پێویستە بۆ هەڵسەنگاندنی گونجاوبوون.',
                        'is_active'   => true,
                        'estimated_days' => 30,
                        'statuses'    => ['submitted', 'documents_reviewed', 'site_inspection_scheduled', 'approved', 'installation_scheduled', 'connected'],
                        'required_documents' => [
                            'National ID card (scanned copy)',
                            'Property deed or rental contract',
                            'Location sketch or property map',
                        ],
                        'form_schema' => [
                            ['name' => 'address',           'label' => 'Property Address',              'label_ku' => 'ناونیشانی موڵک',             'type' => 'textarea', 'required' => true],
                            ['name' => 'property_type',     'label' => 'Property Type',                 'label_ku' => 'جۆری موڵک',                  'type' => 'select',   'required' => true,
                                'options' => ['Residential', 'Commercial', 'Agricultural']],
                            ['name' => 'usage_type',        'label' => 'Water Usage Type',              'label_ku' => 'جۆری بەکارهێنانی ئاو',       'type' => 'select',   'required' => true,
                                'options' => ['Drinking / Household', 'Irrigation', 'Industrial']],
                            ['name' => 'distance_estimate', 'label' => 'Approx. Distance from Main Line (meters)', 'label_ku' => 'دانزایی خەتی سەرەکی (مەتر)', 'type' => 'number', 'required' => false],
                        ],
                    ],
                    ['name' => 'Service Complaint', 'name_ku' => 'گەلایی خزمەتگوزاری', 'slug' => 'water-complaint', 'is_active' => false, 'estimated_days' => 7, 'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Subscriber account number', 'National ID', 'Address and description of the issue'], 'form_schema' => []],
                ],
            ],

            [
                'name'    => 'Business Registration',
                'name_ku' => 'تۆماری بازرگانی',
                'slug'    => 'business-registration',
                'color'   => '#059669',
                'order'   => 5,
                'services' => [
                    [
                        'name'        => 'Business License',
                        'name_ku'     => 'مۆڵەتی بازرگانی',
                        'slug'        => 'business-license',
                        'description' => 'Register a new business and obtain an official business license. Includes name availability check and legal review.',
                        'description_ku' => 'تۆمارکردنی بازرگانی نوێ و وەرگرتنی مۆڵەتی فەرمی. دەگرێتەوە پشکنینی بەردەستبوونی ناو و پێداچوونەوەی یاسایی.',
                        'is_active'   => true,
                        'estimated_days' => 21,
                        'statuses'    => ['submitted', 'name_availability_check', 'under_legal_review', 'approved', 'fee_pending', 'license_ready', 'completed'],
                        'required_documents' => [
                            'National ID card of all owners (scanned copies)',
                            'Business premises lease agreement',
                            'No-criminal-record certificate (all owners)',
                        ],
                        'form_schema' => [
                            ['name' => 'business_name_en',   'label' => 'Business Name (English)', 'label_ku' => 'ناوی بازرگانی (ئینگلیزی)',  'type' => 'text',     'required' => true],
                            ['name' => 'business_name_ku',   'label' => 'Business Name (Kurdish)', 'label_ku' => 'ناوی بازرگانی (کوردی)',     'type' => 'text',     'required' => true],
                            ['name' => 'business_type',      'label' => 'Business Type',           'label_ku' => 'جۆری بازرگانی',             'type' => 'select',   'required' => true,
                                'options' => ['Sole Trader', 'Partnership', 'LLC']],
                            ['name' => 'activity_description','label' => 'Business Activity Description', 'label_ku' => 'وەسفی چالاکیی بازرگانی', 'type' => 'textarea', 'required' => true],
                            ['name' => 'business_address',   'label' => 'Business Address',        'label_ku' => 'ناونیشانی بازرگانی',        'type' => 'textarea', 'required' => true],
                            ['name' => 'capital_amount',     'label' => 'Estimated Capital (IQD)', 'label_ku' => 'سەرمایەی خەمڵێندراو (دینار)', 'type' => 'number', 'required' => true],
                            ['name' => 'owner_details',      'label' => 'All Owner Names & National ID Numbers', 'label_ku' => 'ناو و ناسنامەی هەموو خاوەنەکان', 'type' => 'textarea', 'required' => true],
                        ],
                    ],
                    ['name' => 'Trade License Renewal', 'name_ku' => 'نوێکردنەوەی مۆڵەتی بازرگانی', 'slug' => 'trade-renewal', 'is_active' => false, 'estimated_days' => 14, 'statuses' => ['submitted', 'under_review', 'approved', 'rejected'], 'required_documents' => ['Current trade license', 'National ID of the owner', 'Tax clearance certificate'], 'form_schema' => []],
                ],
            ],
        ];

        foreach ($ministries as $ministryData) {
            $services = $ministryData['services'];
            unset($ministryData['services']);

            $ministry = Ministry::firstOrCreate(
                ['slug' => $ministryData['slug']],
                $ministryData
            );

            foreach ($services as $serviceData) {
                $payload  = array_merge($serviceData, ['ministry_id' => $ministry->id]);
                $existing = Service::where('slug', $serviceData['slug'])->first();

                if ($existing) {
                    // Refresh the service definition (documents, statuses, etc.) on
                    // re-seed, but preserve the admin's activation toggle.
                    unset($payload['is_active']);
                    $existing->update($payload);
                } else {
                    Service::create($payload);
                }
            }
        }
    }
}
