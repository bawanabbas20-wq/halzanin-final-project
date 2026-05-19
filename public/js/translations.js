/**
 * Halzanîn — Client-side Translation Engine
 * ------------------------------------------
 * Translates UI text between English and Kurdish (Soranî)
 * using data-i18n attributes on DOM elements.
 *
 * Usage:
 *   <span data-i18n="dashboard">Dashboard</span>
 *   <input data-i18n-placeholder="search" placeholder="Search...">
 */

window.HalzaninTranslations = {

    // ─── Layout / Sidebar / Nav ───────────────────────────────
    'Dashboard':                        'داشبۆرد',
    'Home':                             'سەرەتا',
    'Profile':                          'پرۆفایل',
    'Log Out':                          'چوونە دەرەوە',
    'All Applications':                 'هەموو داواکارییەکان',
    'User Management':                  'بەڕێوەبردنی بەکارهێنەران',
    'Application Queue':                'ڕیزی داواکارییەکان',
    'Book Appointment':                 'نۆرەی مێعاد',
    'Document Vault':                   'سندووقی بەڵگەنامەکان',
    'Track':                            'شوێنپێکردن',
    'Cancel':                           'پاشگەزبوونەوە',
    'Dash':                             'داشبۆرد',
    'Apps':                             'داواکارییەکان',
    'Users':                            'بەکارهێنەران',
    'Queue':                            'ڕیز',
    'Book':                             'نۆرە',
    'Vault':                            'سندووق',

    // ─── Logout Modal ─────────────────────────────────────────
    'Are you sure you want to end your session?': 'ئایا دڵنیایت دەتەوێت کۆتایی بە دانیشتنەکەت بهێنیت؟',

    // ─── Notifications ────────────────────────────────────────
    'Notifications':                    'ئاگاداریەکان',
    'Mark all read':                    'هەمووی بخوێنەوە',
    'No notifications yet':             'هێشتا هیچ ئاگاداریەک نییە',

    // ─── Welcome / Landing Page ───────────────────────────────
    'Kurdistan Passport Directorate':   'بەڕێوەبەرایەتی پاسپۆرتی کوردستان',
    'Services':                         'خزمەتگوزارییەکان',
    'Process':                          'پرۆسە',
    'Updates':                          'نوێکارییەکان',
    'Log In':                           'چوونە ژوورەوە',
    'Create Account':                   'دروستکردنی هەژمار',
    'Public Service Portal':            'دەروازەی خزمەتگوزاری گشتی',
    'Digital Passport Services for the Kurdistan Region': 'خزمەتگوزاری پاسپۆرتی دیجیتاڵی هەرێمی کوردستان',
    'Submit applications, upload required documents, and track your request status in one place. Designed to reduce waiting time and make government service access clear, secure, and fast.':
        'داواکارییەکان پێشکەش بکە، بەڵگەنامە پێویستەکان بار بکە، و دۆخی داواکارییەکەت لە شوێنێکدا بشوێنە. دیزاین کراوە بۆ کەمکردنەوەی کاتی چاوەڕوانی و ئاسانکردنی دەستکەوتنی خزمەتگوزاری حکومی بە شێوەیەکی ڕوون، پارێزراو، و خێرا.',
    'Go To Dashboard':                  'بڕۆ بۆ داشبۆرد',
    'Start Application':                'دەستکردن بە داواکاری',
    'Register Account':                 'تۆمارکردنی هەژمار',
    'Track Application':                'شوێنپێکردنی داواکاری',
    'Tracking Access':                  'دەستکەوتنی شوێنپێکردن',
    'For Citizens And Staff':           'بۆ هاوڵاتیان و ستاف',
    'Fast':                             'خێرا',
    'Digital Document Review':           'پێداچوونەوەی دیجیتاڵی بەڵگەنامە',
    'Main Services':                    'خزمەتگوزارییە سەرەکییەکان',
    'Halzanin is built around practical citizen workflows. From scheduling appointments to document upload and status tracking, each step is structured for clarity.':
        'هەڵزانین لە دەوری ڕێکاری پراکتیکی هاوڵاتیان بنیات نراوە. لە نۆرەدانی مێعادەوە بۆ بارکردنی بەڵگەنامە و شوێنپێکردنی دۆخ، هەر هەنگاوێک بۆ ڕوونی ڕێکخراوە.',
    'Appointments':                     'مێعادەکان',
    'Book With Calendar Slots':         'نۆرەدانی مێعاد بە ڕۆژ و کات',
    'Choose available dates and times, submit requests, and manage appointments through your citizen dashboard.':
        'ڕۆژ و کاتی بەردەست هەڵبژێرە، داواکاری پێشکەش بکە، و مێعادەکانت بەڕێوە ببە لە ڕێگەی داشبۆردی هاوڵاتییەوە.',
    'Tracking':                         'شوێنپێکردن',
    'Follow Progress By Code':          'شوێنپێکردنی پێشکەوتن بە کۆد',
    'Use your tracking code to check each status update from submission through review and final decision.':
        'کۆدی شوێنپێکردنەکەت بەکاربهێنە بۆ تەماشاکردنی هەر نوێکاریەکی دۆخ لە پێشکەشکردنەوە بۆ پێداچوونەوە و بڕیاری کۆتایی.',
    'Secure Upload And Storage':        'بارکردن و پاشکەوتکردنی پارێزراو',
    'Store required files in your vault and reuse them in supported application workflows.':
        'فایلە پێویستەکان لە سندووقەکەتدا پاشکەوت بکە و لە داواکارییەکاندا بیانبەکاربهێنەوە.',
    'How It Works':                     'چۆن کار دەکات',
    'Step 1':                           'هەنگاوی ١',
    'Step 2':                           'هەنگاوی ٢',
    'Step 3':                           'هەنگاوی ٣',
    'Create Your Account':              'هەژمارەکەت دروست بکە',
    'Register once, then access your dashboard to begin passport-related submissions and updates.':
        'تەنها یەکجار تۆمار بکە، پاشان بچۆ بۆ داشبۆردەکەت بۆ دەستپێکردنی پێشکەشکردنی پاسپۆرت و نوێکردنەوەکان.',
    'Submit Application':               'پێشکەشکردنی داواکاری',
    'Complete appointment details, attach required documents, and confirm your request.':
        'وردەکارییەکانی مێعاد تەواو بکە، بەڵگەنامە پێویستەکان هاوپێچ بکە، و داواکارییەکەت پشتڕاست بکەوە.',
    'Track And Receive Updates':        'شوێنپێکردن و وەرگرتنی نوێکارییەکان',
    'Monitor application status changes from staff review through final processing outcomes.':
        'گۆڕانکارییەکانی دۆخی داواکاری لە پێداچوونەوەی ستاف بۆ ئەنجامی کۆتایی بشوێنە.',
    'Latest Updates':                   'نوێترین نوێکارییەکان',
    'Service Availability':             'بەردەستبوونی خزمەتگوزاری',
    'Citizen portal is available daily for account access, application tracking, and profile updates.':
        'دەروازەی هاوڵاتیان بە ڕۆژانە بەردەستە بۆ دەستکەوتنی هەژمار، شوێنپێکردنی داواکاری، و نوێکردنەوەی پرۆفایل.',
    'Staff Review Queue':               'ڕیزی پێداچوونەوەی ستاف',
    'Applications are reviewed according to queue status and required documents submitted by citizens.':
        'داواکارییەکان بە پێی دۆخی ڕیز و بەڵگەنامە پێویستەکان کە لەلایەن هاوڵاتیانەوە پێشکەش کراون پێداچوونەوە دەکرێن.',
    'Digital Workflow':                  'ڕێکاری دیجیتاڵ',
    'Ongoing improvements continue to reduce manual handling and speed up passport-related processing.':
        'باشکردنەکان بەردەوامن بۆ کەمکردنەوەی کاری دەستی و خێراکردنی پرۆسەکانی پاسپۆرت.',
    'Built for transparent and efficient public service delivery':
        'بنیات نراوە بۆ پێشکەشکردنی خزمەتگوزاری گشتی بە شەفافیەت و کاریگەرانە',

    // ─── Auth Pages ───────────────────────────────────────────
    'Welcome back':                     'بەخێربێیتەوە',
    'Email Address':                    'ناونیشانی ئیمەیل',
    'Password':                         'وشەی نهێنی',
    'Remember me':                      'لە بیرم بمێنە',
    'Forgot password?':                 'وشەی نهێنیت بیرچووەتەوە؟',
    'Log in':                           'چوونە ژوورەوە',
    'or':                               'یان',
    "Don't have an account?":           'هەژمارت نییە؟',
    'Register':                         'تۆمارکردن',
    'Create your account':              'هەژمارەکەت دروست بکە',
    'Full Name':                        'ناوی تەواو',
    'Confirm Password':                 'دووبارەکردنەوەی وشەی نهێنی',
    'Already have an account?':         'پێشتر هەژمارت هەیە؟',

    // ─── Citizen Dashboard ────────────────────────────────────
    "Here's your upcoming appointments at a glance":
        'ئەمە مێعادە داهاتووەکانتە بە یەک تەماشاکردن',
    'Ready to visit the directorate?':  'ئامادەیت بۆ سەردانی بەڕێوەبەرایەتی؟',
    'Book a new appointment in minutes': 'لە چەند خولەکێکدا مێعادی نوێ نۆرە بکە',
    'Upcoming':                         'داهاتوو',
    'Confirmed':                        'پشتڕاستکراوە',
    'Pending':                          'چاوەڕوانی',
    'Upcoming Appointments':            'مێعادە داهاتووەکان',
    'No upcoming appointments':         'هیچ مێعادێکی داهاتوو نییە',
    'Book an appointment to visit the directorate.':
        'مێعادێک نۆرە بکە بۆ سەردانی بەڕێوەبەرایەتی.',

    // ─── Track Page ───────────────────────────────────────────
    'Track Your Application':           'شوێنپێکردنی داواکارییەکەت',
    'Real-time status updates for your document submission':
        'نوێکاری دۆخی ڕاستەوخۆ بۆ پێشکەشکردنی بەڵگەنامەکەت',
    'Enter tracking code (e.g. TRK-...)':
        'کۆدی شوێنپێکردن بنووسە (بۆ نموونە TRK-...)',
    'Track Now':                        'ئێستا بشوێنە',
    'OR':                               'یان',
    'Scan QR Code':                     'سکانی QR کۆد',
    'Applicant Name':                   'ناوی داواکار',
    'Document Type':                    'جۆری بەڵگەنامە',
    'Submitted Date':                   'ڕۆژی پێشکەشکردن',
    'Appointment Date':                 'ڕۆژی مێعاد',
    'Status Timeline':                  'هێڵی کاتی دۆخ',
    'Your document is ready! Please visit the Passport Directorate to collect it.':
        'بەڵگەنامەکەت ئامادەیە! تکایە سەردانی بەڕێوەبەرایەتی پاسپۆرت بکە بۆ وەرگرتنی.',
    'Your application was rejected. Please review the notes above and resubmit.':
        'داواکارییەکەت ڕەتکرایەوە. تکایە تێبینییەکانی سەرەوە پێداچوونەوە بکە و دووبارە پێشکەش بکە.',
    'Your application is being processed. Check back later for updates.':
        'داواکارییەکەت لە پرۆسەی چارەسەرکردندایە. دواتر بگەڕێوە بۆ نوێکارییەکان.',
    'Refresh Status':                   'نوێکردنەوەی دۆخ',
    'Login to your account':            'بچۆ بۆ هەژمارەکەت',
    'Point your camera at the QR code': 'کامێراکەت ببە بەرەو QR کۆدەکە',

    // ─── Staff Pages ──────────────────────────────────────────
    'Application Review':               'پێداچوونەوەی داواکاری',
    'Application Details':              'وردەکارییەکانی داواکاری',
    'Citizen Information':              'زانیاری هاوڵاتی',
    'Status':                           'دۆخ',
    'Actions':                          'کردارەکان',
    'Notes':                            'تێبینییەکان',
    'Approve':                          'پەسەندکردن',
    'Reject':                           'ڕەتکردنەوە',
    'Under Review':                     'لە پێداچوونەوەدا',
    'Approved':                         'پەسەندکراو',
    'Rejected':                         'ڕەتکراوەتەوە',
    'Submitted':                        'پێشکەش کراو',
    'submitted':                        'پێشکەش کراو',
    'under_review':                     'لە پێداچوونەوەدا',
    'approved':                         'پەسەندکراو',
    'rejected':                         'ڕەتکراوەتەوە',
    'No applications in queue':         'هیچ داواکارییەک لە ڕیزدا نییە',
    'Waiting for new submissions...':   'چاوەڕوانی پێشکەشکردنی نوێ...',
    'Today':                            'ئەمڕۆ',
    'This Week':                        'ئەم هەفتەیە',
    'Total':                            'کۆی گشتی',
    'Queue Management':                 'بەڕێوەبردنی ڕیز',
    'Completed':                        'تەواوبووە',
    'In Progress':                      'لە پرۆسەدا',
    'New':                              'نوێ',

    // ─── Staff Calendar ───────────────────────────────────────
    'Calendar':                         'ڕۆژژمێر',
    'Appointments for':                 'مێعادەکان بۆ',
    'No appointments for this date':    'هیچ مێعادێک بۆ ئەم بەروارە نییە',

    // ─── Admin Dashboard ──────────────────────────────────────
    'Admin Dashboard':                  'داشبۆردی بەڕێوەبەر',
    'System Overview':                  'پوختەی سیستەم',
    'Total Users':                      'کۆی بەکارهێنەران',
    'Total Applications':               'کۆی داواکارییەکان',
    'Pending Applications':             'داواکارییە چاوەڕوانەکان',
    'Approved Today':                   'ئەمڕۆ پەسەندکراو',
    'Citizens':                         'هاوڵاتیان',
    'Staff':                            'ستاف',
    'Admins':                           'بەڕێوەبەران',

    // ─── Admin Users ──────────────────────────────────────────
    'Manage Users':                     'بەڕێوەبردنی بەکارهێنەران',
    'Name':                             'ناو',
    'Email':                            'ئیمەیل',
    'Role':                             'ڕۆڵ',
    'Registered':                       'تۆمارکراو',
    'Search users...':                  'گەڕان بۆ بەکارهێنەران...',
    'admin':                            'بەڕێوەبەر',
    'staff':                            'ستاف',
    'citizen':                          'هاوڵاتی',
    'All Roles':                        'هەموو ڕۆڵەکان',
    'No users found':                   'هیچ بەکارهێنەرێک نەدۆزرایەوە',

    // ─── Profile ──────────────────────────────────────────────
    'Profile Information':              'زانیاری پرۆفایل',
    'Update your account profile information and email address.':
        'زانیاری پرۆفایل و ناونیشانی ئیمەیلەکەت نوێ بکەوە.',
    'Save':                             'پاشکەوتکردن',
    'Update Password':                  'نوێکردنەوەی وشەی نهێنی',
    'Ensure your account is using a long, random password to stay secure.':
        'دڵنیا بە لەوەی هەژمارەکەت وشەی نهێنی درێژ و هەڕەمەکی بەکاردەهێنێ بۆ پارێزراو مانەوە.',
    'Current Password':                 'وشەی نهێنی ئێستا',
    'New Password':                     'وشەی نهێنی نوێ',
    'Delete Account':                   'سڕینەوەی هەژمار',
    'Once your account is deleted, all of its resources and data will be permanently deleted.':
        'کاتێک هەژمارەکەت بسڕدرێتەوە، هەموو سەرچاوە و داتاکانی بۆ هەمیشە دەسڕدرێنەوە.',

    // ─── Citizen Upload ───────────────────────────────────────
    'Upload Documents':                 'بارکردنی بەڵگەنامەکان',
    'Upload':                           'بارکردن',
    'Drag and drop files here':         'فایلەکان بهێنە ئێرە',
    'Browse files':                     'گەڕان لە فایلەکان',
    'Supported formats':                'فۆرماتە پشتگیریکراوەکان',
    'Maximum file size':                'گەورەترین قەبارەی فایل',

    // ─── Citizen Vault ────────────────────────────────────────
    'My Documents':                     'بەڵگەنامەکانم',
    'Your Document Vault':              'سندووقی بەڵگەنامەکانت',
    'No documents yet':                 'هێشتا هیچ بەڵگەنامەیەک نییە',
    'Upload your first document to get started.':
        'یەکەم بەڵگەنامەکەت بار بکە بۆ دەستپێکردن.',
    'Upload Document':                  'بارکردنی بەڵگەنامە',
    'View':                             'بینین',
    'Download':                         'داگرتن',
    'Delete':                           'سڕینەوە',
    'Scan Document':                    'سکانی بەڵگەنامە',

    // ─── Citizen Appointment / Calendar ────────────────────────
    'Select a Date':                    'بەرواری هەڵبژێرە',
    'Select Time Slot':                 'کاتی مێعاد هەڵبژێرە',
    'Available':                        'بەردەست',
    'Full':                             'پڕ',
    'Continue':                         'بەردەوامبوون',
    'Back':                             'گەڕانەوە',
    'Confirm Appointment':              'پشتڕاستکردنەوەی مێعاد',
    'Your appointment has been booked!': 'مێعادەکەت نۆرەکرا!',
    'Preferred Date':                   'بەرواری ئارەزوومەند',
    'Time Slot':                        'کاتی مێعاد',
    'Document type':                    'جۆری بەڵگەنامە',
    'Passport - New':                   'پاسپۆرت - نوێ',
    'Passport - Renewal':               'پاسپۆرت - نوێکردنەوە',
    'National ID':                      'ناسنامەی نیشتمانی',
    'Full name':                        'ناوی تەواو',
    'Phone number':                     'ژمارەی تەلەفۆن',
    'Additional notes':                 'تێبینییەکانی زیادە',
    'Sun':                              'یەکشەممە',
    'Mon':                              'دووشەممە',
    'Tue':                              'سێشەممە',
    'Wed':                              'چوارشەممە',
    'Thu':                              'پێنجشەممە',
    'Fri':                              'هەینی',
    'Sat':                              'شەممە',
    'January':                          'کانوونی دووەم',
    'February':                         'شوبات',
    'March':                            'ئازار',
    'April':                            'نیسان',
    'May':                              'ئایار',
    'June':                             'حوزەیران',
    'July':                             'تەممووز',
    'August':                           'ئاب',
    'September':                        'ئەیلوول',
    'October':                          'تشرینی یەکەم',
    'November':                         'تشرینی دووەم',
    'December':                         'کانوونی یەکەم',
    'Off Day':                          'ڕۆژی پشوو',
    'Holiday':                          'بەیانیبەر',

    // ─── Admin Off Days ───────────────────────────────────────
    'Manage Off Days':                  'بەڕێوەبردنی ڕۆژانی پشوو',
    'Add Off Day':                      'زیادکردنی ڕۆژی پشوو',
    'Date':                             'بەروار',
    'Reason':                           'هۆکار',
    'No off days configured':           'هیچ ڕۆژی پشووێک دانەنراوە',

    // ─── QR Receipt ───────────────────────────────────────────
    'Appointment Receipt':              'وەسڵی مێعاد',
    'Print':                            'چاپکردن',
    'Save as PDF':                      'پاشکەوتکردن وەک PDF',

    // ─── General / Misc ───────────────────────────────────────
    'Loading...':                       'بارکردن...',
    'Search...':                        'گەڕان...',
    'Search':                           'گەڕان',
    'Submit':                           'پێشکەشکردن',
    'Close':                            'داخستن',
    'Yes':                              'بەڵێ',
    'No':                               'نەخێر',
    'Success':                          'سەرکەوتوو',
    'Error':                            'هەڵە',
    'Warning':                          'ئاگاداری',
    'Info':                             'زانیاری',
    'Confirm':                          'پشتڕاستکردنەوە',
    'Please fix the errors':            'تکایە هەڵەکان چاکبکەوە',
    'Check the highlighted fields below and try again.':
        'خانە نیشانکراوەکانی خوارەوە پشکنین بکە و دووبارە هەوڵ بدەوە.',
    'Check the highlighted fields and try again.':
        'خانە نیشانکراوەکان پشکنین بکە و دووبارە هەوڵ بدەوە.',
    'Profile Updated':                  'پرۆفایل نوێ کرایەوە',
    'Your profile has been saved successfully.':
        'پرۆفایلەکەت بە سەرکەوتوویی پاشکەوت کرا.',
    'Ask me anything...':               'هەر شتێک بپرسە...',
    'Online':                           'سەرهێڵ',

    // ─── Staff Application Review ─────────────────────────────
    'Application':                      'داواکاری',
    'Tracking Code':                    'کۆدی شوێنپێکردن',
    'Review Application':               'پێداچوونەوەی داواکاری',
    'Set Status':                       'دۆخ دابنێ',
    'Add Notes':                        'تێبینی زیاد بکە',
    'Update Status':                    'نوێکردنەوەی دۆخ',
    'Save Notes':                       'پاشکەوتکردنی تێبینییەکان',
    'Submitted Documents':              'بەڵگەنامە پێشکەشکراوەکان',
    'No documents submitted':           'هیچ بەڵگەنامەیەک پێشکەش نەکراوە',
    'Personal Information':             'زانیاری کەسی',
    'Phone':                            'تەلەفۆن',
    'Appointment Info':                 'زانیاری مێعاد',
    'Preferred date':                   'بەرواری ئارەزوومەند',
    'Time slot':                        'کاتی مێعاد',
    'Next in Queue':                    'دواتر لە ڕیز',
    'Previous':                         'پێشوو',
    'Next':                             'دواتر',
    'of':                               'لە',
    'Showing':                          'پیشاندان',
    'results':                          'ئەنجام',
    'No results':                       'هیچ ئەنجامێک نییە',
    'Filter':                           'فلتەر',
    'All':                              'هەموو',
    'Clear':                            'پاککردنەوە',

    // ─── Password Strength ────────────────────────────────────
    'Weak':                             'لاواز',
    'Fair':                             'مامناوەند',
    'Good':                             'باش',
    'Strong':                           'بەهێز',

    // ─── Empty state components ───────────────────────────────
    'Nothing here yet':                 'هێشتا هیچ شتێک نییە',

    // ─── Staff Application Detail ─────────────────────────────
    'Application Detail':               'وردەکاری داواکاری',
    'Back to Queue':                    'گەڕانەوە بۆ ڕیز',
    'Appointment Information':          'زانیاری مێعاد',
    'National ID Number':               'ژمارەی ناسنامەی نیشتمانی',
    'Submitted At':                     'لە کاتی پێشکەشکردن',
    'Applicant Notes':                  'تێبینییەکانی داواکار',
    'Uploaded Documents':               'بەڵگەنامە بارکراوەکان',
    'Files':                            'فایلەکان',
    'No documents uploaded yet.':       'هێشتا هیچ بەڵگەنامەیەک بار نەکراوە.',
    'Verified':                         'پشتڕاست کرایەوە',
    'Current Status':                   'دۆخی ئێستا',
    'Select Next Status':               'دۆخی دواتر هەڵبژێرە',
    'Choose...':                        'هەڵبژێرە...',
    'Add notes for the citizen...':     'تێبینی بۆ هاوڵاتی زیاد بکە...',
    'This will be visible on their public tracking page.':
        'ئەمە لە پەیجی شوێنپێکردنی گشتییان دا دەبینرێت.',
    'Status Finalized':                 'دۆخ کۆتایی پێهات',
    'This application has reached its final state. No further updates are possible.':
        'ئەم داواکارییە گەیشتە بە قۆناغی کۆتایی. هیچ نوێکاریەکی تر ناکرێت.',
    'Confirm Approval':                 'پشتڕاستکردنی پەسەند',
    'You are about to approve this application. The citizen will be notified by email. This action cannot be undone.':
        'تۆ لەسەرەوەی پەسەندکردنی ئەم داواکارییەیت. هاوڵاتییەکە بە ئیمەیل ئاگادار دەکرێتەوە. ئەم کارە ناگەڕێتەوە.',
    'Confirm Rejection':                'پشتڕاستکردنی ڕەتکردنەوە',
    'Are you sure you want to reject this application? This cannot be undone.':
        'ئایا دڵنیایت دەتەوێت ئەم داواکارییە ڕەت بکەیتەوە؟ ئەم کارە ناگەڕێتەوە.',
    'Rejection reason (required)':      'هۆکاری ڕەتکردنەوە (پێویستە)',
    'Please explain why this application is being rejected...':
        'تکایە ڕوونبکەوە بۆچی ئەم داواکارییە ڕەتدەکرێتەوە...',
    'Received':                         'وەرگیرا',
    'received':                         'وەرگیرا',

    // ─── Staff Queue ──────────────────────────────────────────
    'Search by name or tracking code...':
        'بگەڕێ بە ناو یان کۆدی شوێنپێکردن...',
    'No applications found':            'هیچ داواکارییەک نەدۆزرایەوە',
    'Try adjusting your search or filter to find what you\'re looking for.':
        'هەوڵ بدە گەڕان یان فلتەرەکەت بگۆڕیت بۆ دۆزینەوەی ئەوەی بەدوایدا دەگەڕێیت.',
    'Try adjusting your search or filter.':
        'هەوڵ بدە گەڕان یان فلتەرەکەت بگۆڕیت.',

    // ─── Staff Dashboard ──────────────────────────────────────
    'Welcome,':                         'بەخێربێیت،',
    "Here's the current overview of the application queue.":
        'ئەمە پوختەیەکی ئێستای ڕیزی داواکارییەکانە.',
    'Pending Review':                   'چاوەڕوانی پێداچوونەوە',
    'Review, process, and update the status of all submitted citizen applications in real-time.':
        'پێداچوونەوە، چارەسەرکردن، و نوێکردنەوەی دۆخی هەموو داواکارییە پێشکەشکراوەکانی هاوڵاتیان بە ڕاستەوخۆ.',
    'View Application Queue':           'بینینی ڕیزی داواکارییەکان',

    // ─── Admin Dashboard extras ───────────────────────────────
    "Today's Apps":                     'داواکارییەکانی ئەمڕۆ',
    'Applications This Week':           'داواکارییەکانی ئەم هەفتەیە',
    'Quick Actions':                    'کردارە خێراکان',
    'View All Applications':            'بینینی هەموو داواکارییەکان',
    'Recent Applications':              'داواکارییە نوێکان',
    'View All':                         'بینینی هەموو',
    'Applicant':                        'داواکار',
    'No recent applications.':          'هیچ داواکارییەکی نوێ نییە.',
    'Total Citizens':                   'کۆی هاوڵاتیان',

    // ─── Admin Users extras ───────────────────────────────────
    'Back to Dashboard':                'گەڕانەوە بۆ داشبۆرد',
    'You':                              'تۆ',
    'Cannot change own role':           'ناتوانیت ڕۆڵی خۆت بگۆڕیت',
    'Citizen':                          'هاوڵاتی',
    'Admin':                            'بەڕێوەبەر',
    'Update':                           'نوێکردنەوە',
    'Update User Role':                 'نوێکردنەوەی ڕۆڵی بەکارهێنەر',
    'This will change the user\'s access level.':
        'ئەمە ئاستی دەستکەوتنی بەکارهێنەرەکە دەگۆڕێت.',
    'Update Role':                      'نوێکردنەوەی ڕۆڵ',
    'No registered users match the current criteria.':
        'هیچ بەکارهێنەرێکی تۆمارکراو لەگەڵ مەرجەکانی ئێستا ناگونجێت.',

    // ─── Citizen Appointment Steps ────────────────────────────
    'Personal Info':                    'زانیاری کەسی',
    'Personal':                         'کەسی',
    'Pick Appointment':                 'مێعاد هەڵبژێرە',
    'Pick':                             'هەڵبژێرە',
    'Review & Submit':                  'پێداچوونەوە و پێشکەشکردن',
    'Review &':                         'پێداچوونەوە و',
    'Enter your full legal name':       'ناوی تەواوی یاسایی بنووسە',
    'Full name is required.':           'ناوی تەواو پێویستە.',
    'e.g. 1234567890':                  'بۆ نموونە ١٢٣٤٥٦٧٨٩٠',
    'National ID number is required.':  'ژمارەی ناسنامەی نیشتمانی پێویستە.',
    'Select a document type...':        'جۆری بەڵگەنامەیەک هەڵبژێرە...',
    'Please select a document type.':   'تکایە جۆری بەڵگەنامەیەک هەڵبژێرە.',
    'Passport Renewal':                 'نوێکردنەوەی پاسپۆرت',
    'New Passport':                     'پاسپۆرتی نوێ',
    'ID Card':                          'کارتی ناسنامە',
    'Birth Certificate':                'بڕوانامەی لەدایکبوون',
    'Other':                            'هی تر',
    'Filling up':                       'پڕدەبێت',
    'Almost full':                      'نزیکە پڕبێت',
    'Off day':                          'ڕۆژی پشوو',
    'Fully booked':                     'بە تەواوی نۆرەکراوە',
    'Loading available time slots...':  'بارکردنی کاتە بەردەستەکان...',
    'No slots available for this date.':
        'هیچ کاتێک بۆ ئەم بەروارە بەردەست نییە.',
    'Failed to load slots. Please try again.':
        'بارکردنی کاتەکان سەرکەوتوو نەبوو. تکایە دووبارە هەوڵ بدە.',
    'Appointment Summary':              'پوختەی مێعاد',
    'Document':                         'بەڵگەنامە',
    'Time':                             'کات',
    'Required Documents':               'بەڵگەنامە پێویستەکان',
    'For each document, select from your vault, upload a file, or confirm you\'ll bring it.':
        'بۆ هەر بەڵگەنامەیەک، لە سندووقەکەتەوە هەڵبژێرە، فایلێک بار بکە، یان پشتڕاست بکەوە دەیهێنیت.',
    'Loading required documents...':    'بارکردنی بەڵگەنامە پێویستەکان...',
    'Submit Appointment':               'پێشکەشکردنی مێعاد',
    'Submitting...':                    'پێشکەشکردن...',

    // ─── Citizen Upload Page ──────────────────────────────────
    '← Back to Dashboard':              '← گەڕانەوە بۆ داشبۆرد',
    'Uploading documents for application':
        'بارکردنی بەڵگەنامەکان بۆ داواکاری',
    'Requirements Checklist':           'لیستی پشکنینی پێداویستییەکان',
    'Check each box to confirm you have prepared the document, then select the file. All 3 must be checked before you can submit.':
        'هەر سندووقێک نیشانە بکە بۆ پشتڕاستکردنی ئامادەکردنی بەڵگەنامەکە، پاشان فایلەکە هەڵبژێرە. هەر ٣ دەبێت نیشانەکراو بن پێش پێشکەشکردن.',
    'Passport Photo':                   'وێنەی پاسپۆرت',
    'Check all 3 boxes to enable submission.':
        'هەر ٣ سندووق نیشانە بکە بۆ چالاککردنی پێشکەشکردن.',
    'Submit Documents':                 'پێشکەشکردنی بەڵگەنامەکان',

    // ─── QR Receipt ───────────────────────────────────────────
    'Application Submitted!':           'داواکاری پێشکەش کرا!',
    'Your QR receipt is ready — print it or save it':
        'وەسڵی QR ت ئامادەیە — چاپی بکە یان پاشکەوتی بکە',
    'Kurdistan Region — Passport Directorate':
        'هەرێمی کوردستان — بەڕێوەبەرایەتی پاسپۆرت',
    'Scan the QR code or visit':        'QR کۆدەکە سکان بکە یان سەردان بکە',
    'Please bring this receipt to your appointment.':
        'تکایە ئەم وەسڵە لەگەڵ خۆت بهێنە بۆ مێعادەکەت.',
    'Print Receipt':                    'چاپکردنی وەسڵ',
    'Back to Dashboard':                'گەڕانەوە بۆ داشبۆرد',

    // ─── Profile Page ─────────────────────────────────────────
    'My Profile':                       'پرۆفایلی من',
    'Manage your account settings and preferences.':
        'ڕێکخستنەکان و ئارەزووەکانی هەژمارەکەت بەڕێوە ببە.',
    'Phone Number (WhatsApp)':          'ژمارەی تەلەفۆن (واتسئاپ)',
    'Required to receive WhatsApp updates about your applications.':
        'پێویستە بۆ وەرگرتنی نوێکارییەکانی واتسئاپ دەربارەی داواکارییەکانت.',
    'Your email address is unverified.':
        'ناونیشانی ئیمەیلەکەت پشتڕاست نەکراوەتەوە.',
    'Click here to re-send the verification email.':
        'کرتە لێرە بکە بۆ نوێ ناردنەوەی ئیمەیلی پشتڕاستکردنەوە.',
    'A new verification link has been sent to your email address.':
        'بەستەرێکی پشتڕاستکردنەوەی نوێ نێردرا بۆ ناونیشانی ئیمەیلەکەت.',
    'Save Changes':                     'پاشکەوتکردنی گۆڕانکارییەکان',
    'Saved successfully.':              'بە سەرکەوتوویی پاشکەوت کرا.',
    'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.':
        'کاتێک هەژمارەکەت بسڕدرێتەوە، هەموو سەرچاوە و داتاکانی بۆ هەمیشە دەسڕدرێنەوە. پێش سڕینەوەی هەژمارەکەت، تکایە هەر داتایەک یان زانیارییەک دایبگرە کە دەتەوێت بیپارێزیت.',
    'Are you sure you want to delete your account?':
        'ئایا دڵنیایت دەتەوێت هەژمارەکەت بسڕیتەوە؟',
    'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.':
        'کاتێک هەژمارەکەت بسڕدرێتەوە، هەموو سەرچاوە و داتاکانی بۆ هەمیشە دەسڕدرێنەوە. تکایە وشەی نهێنییەکەت بنووسە بۆ پشتڕاستکردنەوەی سڕینەوەی هەمیشەیی هەژمارەکەت.',

    // ─── Vault ────────────────────────────────────────────────
    'Securely store your official documents.':
        'بەڵگەنامە فەرمییەکانت بە پارێزراوی پاشکەوت بکە.',
    'Your vault is empty':              'سندووقەکەت بەتاڵە',
    'Scan your passport or ID card to store it securely. Documents are encrypted and auto-delete after 100 days.':
        'پاسپۆرت یان ناسنامەکەت سکان بکە بۆ پاشکەوتکردنی پارێزراو. بەڵگەنامەکان شفرەکراون و دوای ١٠٠ ڕۆژ خۆکارانە دەسڕدرێنەوە.',
    'Expires in':                       'بەسەرچوونی لە',
    'PDF':                              'PDF',
    'Image':                            'وێنە',
    'Are you sure you want to permanently delete this document?':
        'ئایا دڵنیایت دەتەوێت ئەم بەڵگەنامەیە بۆ هەمیشە بسڕیتەوە؟',
    'Delete Securely':                  'سڕینەوەی پارێزراو',

    // ─── Vault Scan ───────────────────────────────────────────
    'What are you scanning?':           'چی سکان دەکەیت؟',
    'The frame will adjust to fit your document.':
        'چوارچێوەکە خۆی ڕێک دەخاتەوە بۆ گونجاندنی بەڵگەنامەکەت.',
    'Driver License':                   'مۆڵەتی شۆفێری',
    'Passport':                         'پاسپۆرت',
    'Front + back':                     'پێشەوە + پشتەوە',
    'Photo page':                       'پەڕەی وێنە',
    'Single page':                      'پەڕەیەکی تاک',
    'Open Camera':                      'کردنەوەی کامێرا',
    'Front':                            'پێشەوە',
    'Scanning front side':              'سکانی لای پێشەوە',
    'Flip document — scanning back side':
        'بەڵگەنامەکە بگێڕەوە — سکانی لای پشتەوە',
    'Position document within frame':   'بەڵگەنامەکە لەناو چوارچێوەکە دابنێ',
    'Retake':                           'دووبارە وێنەگرتنەوە',
    'Next: Scan Back':                  'دواتر: سکانی پشتەوە',
    'Save Securely':                    'پاشکەوتکردنی پارێزراو',
    'Original':                         'ئەسڵی',
    'Magic Scan ✨':                    'سکانی سیحری ✨',
    'B&W Doc 📝':                       'بەڵگەنامەی ڕەش و سپی 📝',
    'Flip your':                        'بگێڕەوە',
    'Front side saved. Now scan the back side to complete your document.':
        'لای پێشەوە پاشکەوت کرا. ئێستا لای پشتەوە سکان بکە بۆ تەواوکردنی بەڵگەنامەکەت.',
    'Skip (front only)':                'تێپەڕاندن (تەنها پێشەوە)',
    'Scan Back Side':                   'سکانی لای پشتەوە',

    // ─── Admin Off Days ───────────────────────────────────────
    'Off Days Management':              'بەڕێوەبردنی ڕۆژانی پشوو',
    'Add Off Days':                     'زیادکردنی ڕۆژانی پشوو',
    'Select one or multiple dates. Friday & Saturday are always off and don\'t need to be added here.':
        'یەک یان چەند بەروارێک هەڵبژێرە. هەینی و شەممە هەمیشە پشوون و پێویست ناکات لێرە زیاد بکرێن.',
    'Selected dates:':                  'بەروارە هەڵبژێردراوەکان:',
    'Add Selected Off Days':            'زیادکردنی ڕۆژانی پشووی هەڵبژێردراو',
    'Off Days in':                      'ڕۆژانی پشوو لە',
    'No custom off days for':           'هیچ ڕۆژی پشووی تایبەت نییە بۆ',
    'Friday & Saturday are automatically off every week.':
        'هەینی و شەممە خۆکارانە هەموو هەفتەیەک پشوون.',
    'custom off day(s) this year':      'ڕۆژی پشووی تایبەت ئەمساڵ',
    'Remove this off day?':             'ئەم ڕۆژی پشووە بسڕیتەوە؟',
    'Note:':                            'تێبینی:',
    'Friday and Saturday are automatically marked as off days for all citizens. Only add dates here for additional holidays or emergency closures.':
        'هەینی و شەممە خۆکارانە وەک ڕۆژی پشوو دیاری کراون بۆ هەموو هاوڵاتییەک. تەنها بەروارەکان لێرە زیاد بکە بۆ بەیانیبەرەکانی زیادە یان داخستنی کاتی لەناکاو.',

    // ─── Citizen Appointment (old form) ───────────────────────
    'Notes (Optional)':                 'تێبینییەکان (ئارەزوومەندانە)',
    'Select a time slot':               'کاتێکی مێعاد هەڵبژێرە',
    'Select document type':             'جۆری بەڵگەنامە هەڵبژێرە',
    'Summary':                          'پوختە',
    'You will receive a unique QR tracking code after submission.':
        'دوای پێشکەشکردن کۆدی شوێنپێکردنی QR ی تایبەت بەخۆت وەردەگریت.',
    'Confirm Submission':               'پشتڕاستکردنی پێشکەشکردن',
    'Please confirm your appointment details are correct. All uploaded documents and details will be sent for review.':
        'تکایە پشتڕاست بکەوە کە وردەکارییەکانی مێعادەکەت ڕاستن. هەموو بەڵگەنامە بارکراوەکان و وردەکارییەکان دەنێردرێن بۆ پێداچوونەوە.',
    'Go Back':                          'بگەڕێوە',
    'Submit Now':                       'ئێستا پێشکەش بکە',

    // ─── Staff Calendar ───────────────────────────────────────
    'Appointments Calendar':            'ڕۆژژمێری مێعادەکان',
    'off':                              'پشوو',
    'Open':                             'کراوە',
    'Filling':                          'پڕدەبێت',
    'Click a day to see appointments':  'کرتە لە ڕۆژێک بکە بۆ بینینی مێعادەکان',
    'No appointments for this day.':    'هیچ مێعادێک بۆ ئەم ڕۆژە نییە.',
    'appointment':                      'مێعاد',
    'appointments':                     'مێعاد',
    'Documents':                        'بەڵگەنامەکان',
    'Bringing':                         'دەیهێنێت',
    'Complete':                         'تەواوکردن',
    'Cancelled':                        'هەڵوەشێنرایەوە',

    // ─── Shared / legacy Breeze pages ─────────────────────────
    'User':                             'بەکارهێنەر',
    'Off Days':                         'ڕۆژانی پشووی',
    'Confirm':                          'پشتڕاستکردنەوە',
    'Delete Account':                   'سڕینەوەی هەژمار',
    'Email Password Reset Link':        'ناردنی بەستەری گۆڕینی وشەی نهێنی',
    'Reset Password':                   'گۆڕینی وشەی نهێنی',
    'Resend Verification Email':        'ناردنەوەی ئیمەیڵی پشتڕاستکردنەوە',
    'Profile Information':              'زانیاری پرۆفایل',
    'Update your account\'s profile information and email address.':
        'زانیاری پرۆفایل و ناونیشانی ئیمەیڵی هەژمارەکەت نوێ بکەوە.',
    'A new verification link has been sent to the email address you provided during registration.':
        'بەستەرێکی نوێی پشتڕاستکردنەوە نێردرا بۆ ئەو ناونیشانی ئیمەیڵەی لە کاتی تۆمارکردندا دابت ناوە.',
    'This is a secure area of the application. Please confirm your password before continuing.':
        'ئەمە ناوچەیەکی پارێزراوی ئەپلیکەیشنە. تکایە پێش بەردەوامبوون وشەی نهێنییەکەت پشتڕاست بکەرەوە.',
    'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.':
        'وشەی نهێنییەکەت بیرچووەتەوە؟ کێشە نییە. تەنها ناونیشانی ئیمەیڵەکەت بنووسە و بەستەری گۆڕینی وشەی نهێنی بۆت دەنێرین.',
    'Upload National ID (JPG, PNG, PDF — max 2MB)':
        'بارکردنی ناسنامەی نیشتمانی (JPG، PNG، PDF - زۆرترین ٢MB)',
    'Upload Passport Photo (JPG, PNG, PDF — max 2MB)':
        'بارکردنی وێنەی پاسپۆرت (JPG، PNG، PDF - زۆرترین ٢MB)',
    'Upload Birth Certificate (JPG, PNG, PDF — max 2MB)':
        'بارکردنی بڕوانامەی لەدایکبوون (JPG، PNG، PDF - زۆرترین ٢MB)',
    'You\'re logged in!':                'تۆ چوویتە ژوورەوە!',
    'Appointment':                      'مێعاد',
    'Booked':                           'نۆرەگیراو',
    'Scanned:':                         'سکانکراو:',
    '(optional)':                       '(هەڵبژاردەیی)',
    '07XX XXX XXXX':                    '07XX XXX XXXX',
    'Don\'t have an account?':          'هەژمارت نییە؟',
    'Halzanin | Kurdistan Passport Directorate':
        'هەڵزانین | بەڕێوەبەرایەتی پاسپۆرتی کوردستان',
    'Here\'s your upcoming appointments at a glance':
        'ئەمە مێعادە داهاتووەکانت بە یەک تەماشاکردنە',
    'Here\'s the current overview of the application queue.':
        'ئەمە پوختەی ئێستای ڕیزی داواکارییەکانە.',
    'This will change the user\'s access level.':
        'ئەمە ئاستی دەستگەیشتنی بەکارهێنەر دەگۆڕێت.',
    'Select one or multiple dates. Friday & Saturday are always off and don\'t need to be added here.':
        'یەک یان چەند بەروارێک هەڵبژێرە. هەینی و شەممە هەمیشە پشوون و پێویست ناکات لێرە زیاد بکرێن.',
    'e.g. National Holiday, Emergency closure…':
        'بۆ نموونە پشووی نیشتمانی، داخستنی لەناکاو...',
};


/**
 * Apply translations to the current page.
 * @param {string} [lang] – 'ku' for Kurdish, 'en' for English. Defaults to current doc lang.
 */
function applyTranslations(lang) {
    lang = lang || document.documentElement.lang || 'en';
    const T = window.HalzaninTranslations;
    const skipTags = new Set(['SCRIPT', 'STYLE', 'TEXTAREA', 'INPUT', 'SELECT', 'OPTION']);
    const normalizeKey = function(value) {
        return (value || '').replace(/\s+/g, ' ').trim();
    };

    // Translate text content
    document.querySelectorAll('[data-i18n]').forEach(function(el) {
        var key = el.getAttribute('data-i18n');
        var cleanKey = normalizeKey(key);

        // Store original English text on first run
        if (!el.hasAttribute('data-i18n-en')) {
            el.setAttribute('data-i18n-en', el.textContent.trim());
        }

        if (lang === 'ku') {
            if (T[key] || T[cleanKey]) {
                el.textContent = T[key] || T[cleanKey];
            }
        } else {
            // Restore English
            el.textContent = el.getAttribute('data-i18n-en');
        }
    });

    // Translate placeholders
    document.querySelectorAll('[data-i18n-placeholder]').forEach(function(el) {
        var key = el.getAttribute('data-i18n-placeholder');
        var cleanKey = normalizeKey(key);

        // Store original English placeholder on first run
        if (!el.hasAttribute('data-i18n-placeholder-en')) {
            el.setAttribute('data-i18n-placeholder-en', el.placeholder);
        }

        if (lang === 'ku') {
            if (T[key] || T[cleanKey]) {
                el.placeholder = T[key] || T[cleanKey];
            }
        } else {
            el.placeholder = el.getAttribute('data-i18n-placeholder-en');
        }
    });

    // Translate title attributes
    document.querySelectorAll('[data-i18n-title]').forEach(function(el) {
        var key = el.getAttribute('data-i18n-title');
        var cleanKey = normalizeKey(key);

        if (!el.hasAttribute('data-i18n-title-en')) {
            el.setAttribute('data-i18n-title-en', el.title);
        }

        if (lang === 'ku') {
            if (T[key] || T[cleanKey]) {
                el.title = T[key] || T[cleanKey];
            }
        } else {
            el.title = el.getAttribute('data-i18n-title-en');
        }
    });

    // Translate simple Blade-rendered text that was not explicitly tagged.
    document.querySelectorAll('body *').forEach(function(el) {
        if (skipTags.has(el.tagName) || el.hasAttribute('data-i18n')) {
            return;
        }

        var textNodes = Array.prototype.filter.call(el.childNodes, function(node) {
            return node.nodeType === Node.TEXT_NODE && normalizeKey(node.textContent);
        });

        if (textNodes.length !== 1 || Array.prototype.some.call(el.children, function(child) {
            return child.offsetParent !== null;
        })) {
            return;
        }

        var node = textNodes[0];
        if (!el.hasAttribute('data-i18n-auto-en')) {
            var original = normalizeKey(node.textContent);
            if (T[original]) {
                el.setAttribute('data-i18n-auto-en', original);
            }
        }

        var autoKey = el.getAttribute('data-i18n-auto-en');
        if (!autoKey) {
            return;
        }

        node.textContent = lang === 'ku' ? T[autoKey] : autoKey;
    });
}

function setHalzaninLanguage(lang) {
    lang = lang === 'ku' ? 'ku' : 'en';
    document.documentElement.dir = lang === 'ku' ? 'rtl' : 'ltr';
    document.documentElement.lang = lang;
    document.documentElement.classList.toggle('font-arabic', lang === 'ku');
    document.documentElement.classList.toggle('font-outfit', lang !== 'ku');
    localStorage.setItem('lang', lang);
    applyTranslations(lang);
    syncHalzaninLanguageToggle(lang);

    if (typeof window.updateChatQuickPrompts === 'function') {
        window.updateChatQuickPrompts(lang);
    }
}

function syncHalzaninLanguageToggle(lang) {
    lang = lang === 'ku' ? 'ku' : 'en';
    var enItems = document.querySelectorAll('#lang-en, [data-lang-en]');
    var kuItems = document.querySelectorAll('#lang-ku, [data-lang-ku]');

    enItems.forEach(function(el) {
        el.classList.toggle('bg-brand', lang === 'en');
        el.classList.toggle('text-white', lang === 'en');
        el.classList.toggle('text-brand', lang !== 'en');
    });

    kuItems.forEach(function(el) {
        el.classList.toggle('bg-brand', lang === 'ku');
        el.classList.toggle('text-white', lang === 'ku');
        el.classList.toggle('text-brand', lang !== 'ku');
    });
}

window.applyTranslations = applyTranslations;
window.setHalzaninLanguage = setHalzaninLanguage;
window.syncHalzaninLanguageToggle = syncHalzaninLanguageToggle;

// Auto-apply on page load
document.addEventListener('DOMContentLoaded', function() {
    var lang = localStorage.getItem('lang') || 'en';
    setHalzaninLanguage(lang);

    document.querySelectorAll('[data-hz-lang-toggle]').forEach(function(button) {
        if (!button || button.dataset.langReady === '1') {
            return;
        }

        button.dataset.langReady = '1';
        button.addEventListener('click', function() {
            setHalzaninLanguage(document.documentElement.lang === 'ku' ? 'en' : 'ku');
        });
    });
});
