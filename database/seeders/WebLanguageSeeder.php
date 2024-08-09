<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Language;

class WebLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            [
                'type'  => 'web', 
                'key'   => 'test', 
                'en'    => 'test', 
                'he'    => 'מִבְחָן', 
                'ar'    => 'امتحان'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'dashboard_title', 
                'en'    => 'Welcome to Dali', 
                'he'    => 'ברוך הבא לדאלי', 
                'ar'    => 'مرحبا بكم في دالي'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'dashboard_content', 
                'en'    => 'Sub-hero message, not too long and not too short. Make it just right!', 
                'he'    => 'הודעת גיבור משנה, לא ארוכה מדי ולא קצרה מדי. תעשה את זה בדיוק כמו שצריך!', 
                'ar'    => 'رسالة البطل الفرعي، ليست طويلة جدًا وليست قصيرة جدًا. اجعلها صحيحة تمامًا!'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'you_need_to_email_verify', 
                'en'    => 'You need to email verify.', 
                'he'    => 'تحتاج إلى التحقق من البريد الإلكتروني.', 
                'ar'    => 'עליך לשלוח בדוא"ל אימות.'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'did_you_receive_verification_email_yet', 
                'en'    => 'Did you receive verification email yet?', 
                'he'    => 'האם קיבלת כבר אימייל אימות?', 
                'ar'    => 'هل تلقيت رسالة التحقق عبر البريد الإلكتروني حتى الآن؟'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'resend_email_verification', 
                'en'    => 'resend email verification', 
                'he'    => 'שלח שוב אימות דוא"ל', 
                'ar'    => 'إعادة إرسال التحقق من البريد الإلكتروني'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'login', 
                'en'    => 'Login', 
                'he'    => 'התחברות', 
                'ar'    => 'تسجيل الدخول'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'password', 
                'en'    => 'Password', 
                'he'    => 'סיסמה', 
                'ar'    => 'كلمة المرور'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'remember_me', 
                'en'    => 'Remember me', 
                'he'    => 'זכור אותי', 
                'ar'    => 'تذكرنى'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'forgot_your_password', 
                'en'    => 'Forgot your password?', 
                'he'    => 'שכחת ססמה?', 
                'ar'    => 'نسيت كلمة السر؟'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'sign_in', 
                'en'    => 'Sign in', 
                'he'    => 'להתחבר', 
                'ar'    => 'تسجيل الدخول'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'password_reset', 
                'en'    => 'Password Reset', 
                'he'    => 'איפוס סיסמא', 
                'ar'    => 'إعادة تعيين كلمة المرور'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'password_confirmation', 
                'en'    => 'Password Confirmation', 
                'he'    => 'אימות סיסמה', 
                'ar'    => 'تأكيد كلمة المرور'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'set_password', 
                'en'    => 'Set Password', 
                'he'    => 'הגדר סיסמא', 
                'ar'    => 'ضبط كلمة السر'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'you_need_to_phone_verify', 
                'en'    => 'You need to phone verify.', 
                'he'    => 'אתה צריך לאמת טלפונית.', 
                'ar'    => 'تحتاج إلى التحقق من الهاتف.'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'didnt_you_receive_verification_sms_yet', 
                'en'    => "Didn't you receive verification SMS yet?", 
                'he'    => 'עדיין לא קיבלת SMS אימות?', 
                'ar'    => 'لم تتلق رسالة التحقق القصيرة حتى الآن؟'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'resend_phone_verification', 
                'en'    => 'resend phone verification', 
                'he'    => 'שלח שוב אימות טלפוני', 
                'ar'    => 'إعادة إرسال التحقق من الهاتف'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'verification_code_here', 
                'en'    => 'verification code here', 
                'he'    => 'קוד אימות כאן', 
                'ar'    => 'رمز التحقق هنا'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'register_success', 
                'en'    => 'Register Success.', 
                'he'    => 'רישום הצלחה.', 
                'ar'    => 'سجل النجاح.'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'we_sent_you_an_email_to_complete_registration', 
                'en'    => 'We sent you an email to complete registration.', 
                'he'    => "שלחנו לך מייל להשלמת ההרשמה.", 
                'ar'    => "لقد أرسلنا لك بريدًا إلكترونيًا لإكمال التسجيل."
            ], 
            [
                'type'  => 'web', 
                'key'   => 'register', 
                'en'    => 'Register', 
                'he'    => 'הירשם', 
                'ar'    => 'يسجل'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'first_name', 
                'en'    => 'First Name', 
                'he'    => 'שם פרטי', 
                'ar'    => 'الاسم الأول'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'last_name', 
                'en'    => 'Last Name', 
                'he'    => 'שם משפחה', 
                'ar'    => 'اسم العائلة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'email', 
                'en'    => 'Email', 
                'he'    => 'אימייל', 
                'ar'    => 'بريد إلكتروني'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'phone_number', 
                'en'    => 'Phone Number', 
                'he'    => 'מספר טלפון', 
                'ar'    => 'رقم التليفون'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'reset_password', 
                'en'    => 'Reset Password', 
                'he'    => 'לאפס את הסיסמה', 
                'ar'    => 'إعادة تعيين كلمة المرور'
            ], 

        // MARK: - Nav Items
            [
                'type'  => 'web', 
                'key'   => 'logout', 
                'en'    => 'Logout', 
                'he'    => 'להתנתק', 
                'ar'    => 'تسجيل خروج'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'landing_item', 
                'en'    => 'Landing Item', 
                'he'    => 'פריט נחיתה', 
                'ar'    => 'البند الهبوط'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'profile', 
                'en'    => 'Profile', 
                'he'    => 'פּרוֹפִיל', 
                'ar'    => 'حساب تعريفي'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'language', 
                'en'    => 'Language', 
                'he'    => 'שפה', 
                'ar'    => 'لغة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'teacher', 
                'en'    => 'Teacher', 
                'he'    => 'מוֹרֶה', 
                'ar'    => 'مدرس'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'user', 
                'en'    => 'User', 
                'he'    => 'מִשׁתַמֵשׁ', 
                'ar'    => 'مستخدم'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'transaction', 
                'en'    => 'Transaction', 
                'he'    => 'עִסקָה', 
                'ar'    => 'عملية'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'subject', 
                'en'    => 'Subject', 
                'he'    => 'נושא', 
                'ar'    => 'موضوع'
            ], 


        // MARK: - Page
            [
                'type'  => 'web', 
                'key'   => 'save', 
                'en'    => 'Save', 
                'he'    => 'להציל', 
                'ar'    => 'يحفظ'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'add', 
                'en'    => 'Add', 
                'he'    => 'לְהוֹסִיף', 
                'ar'    => 'يضيف'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'cancel', 
                'en'    => 'Cancel', 
                'he'    => 'לְבַטֵל', 
                'ar'    => 'يلغي'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit', 
                'en'    => 'Edit', 
                'he'    => 'לַעֲרוֹך', 
                'ar'    => 'يحرر'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'show', 
                'en'    => 'Show', 
                'he'    => 'לְהַרְאוֹת', 
                'ar'    => 'تبين'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'delete', 
                'en'    => 'Delete', 
                'he'    => 'לִמְחוֹק', 
                'ar'    => 'يمسح'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'back', 
                'en'    => 'Back', 
                'he'    => 'חזור', 
                'ar'    => 'خلف'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'export', 
                'en'    => 'Export', 
                'he'    => 'יְצוּא', 
                'ar'    => 'يصدّر'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'delete_all', 
                'en'    => 'Delete All', 
                'he'    => 'מחק הכל', 
                'ar'    => 'حذف الكل'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'error', 
                'en'    => 'Error', 
                'he'    => 'שְׁגִיאָה', 
                'ar'    => 'خطأ'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'success', 
                'en'    => 'Success', 
                'he'    => 'הַצלָחָה', 
                'ar'    => 'نجاح'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'transfer', 
                'en'    => 'Transfer', 
                'he'    => 'לְהַעֲבִיר', 
                'ar'    => 'نقل'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'add_a_subject_of_your_own', 
                'en'    => 'Add a subject of your own', 
                'he'    => 'הוסף נושא משלך', 
                'ar'    => 'أضف موضوعًا خاصًا بك'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_profile', 
                'en'    => 'Edit Profile', 
                'he'    => 'ערוך פרופיל', 
                'ar'    => 'تعديل الملف الشخصي'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'landing_items', 
                'en'    => 'Landing Items', 
                'he'    => 'פריטי נחיתה', 
                'ar'    => 'عناصر الهبوط'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'create_landing_item', 
                'en'    => 'Create Landing Item', 
                'he'    => 'צור פריט נחיתה', 
                'ar'    => 'إنشاء عنصر الهبوط'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_landing_item', 
                'en'    => 'Edit Landing Item', 
                'he'    => 'تحرير العنصر المقصود', 
                'ar'    => 'ערוך פריט נחיתה'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'languages', 
                'en'    => 'Languages', 
                'he'    => 'שפות', 
                'ar'    => 'اللغات'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_language', 
                'en'    => 'Edit Language', 
                'he'    => 'ערוך שפה', 
                'ar'    => 'تحرير اللغة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'teachers', 
                'en'    => 'Teachers', 
                'he'    => 'מורים', 
                'ar'    => 'معلمون'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'users', 
                'en'    => 'Users', 
                'he'    => 'משתמשים', 
                'ar'    => 'المستخدمين'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'transactions', 
                'en'    => 'Transactions', 
                'he'    => 'עסקאות', 
                'ar'    => 'المعاملات'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'subjects', 
                'en'    => 'Subjects', 
                'he'    => 'נושאים', 
                'ar'    => 'المواضيع'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'create_subject', 
                'en'    => 'Create Subject', 
                'he'    => 'צור נושא', 
                'ar'    => 'إنشاء الموضوع'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_subject', 
                'en'    => 'Edit Subject', 
                'he'    => 'ערוך נושא', 
                'ar'    => 'تحرير الموضوع'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'add_course', 
                'en'    => 'Add Course', 
                'he'    => 'הוסף קורס', 
                'ar'    => 'إضافة دورة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'course', 
                'en'    => 'Course', 
                'he'    => 'קוּרס', 
                'ar'    => 'دورة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'courses', 
                'en'    => 'Courses', 
                'he'    => 'קורסים', 
                'ar'    => 'الدورات'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'create_course', 
                'en'    => 'Create Course', 
                'he'    => 'צור קורס', 
                'ar'    => 'إنشاء دورة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_course', 
                'en'    => 'Edit Course', 
                'he'    => 'ערוך קורס', 
                'ar'    => 'تحرير الدورة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'add_subject', 
                'en'    => 'Add Subject', 
                'he'    => 'הוסף נושא', 
                'ar'    => 'إضافة الموضوع'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'lecture', 
                'en'    => 'Lecture', 
                'he'    => 'הַרצָאָה', 
                'ar'    => 'محاضرة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'lectures', 
                'en'    => 'Lectures', 
                'he'    => 'הרצאות', 
                'ar'    => 'محاضرات'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'create_lecture', 
                'en'    => 'Create Lecture', 
                'he'    => 'צור הרצאה', 
                'ar'    => 'إنشاء محاضرة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_lecture', 
                'en'    => 'Edit Lecture', 
                'he'    => 'ערוך הרצאה', 
                'ar'    => 'تحرير المحاضرة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'question', 
                'en'    => 'Question', 
                'he'    => 'שְׁאֵלָה', 
                'ar'    => 'سؤال'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'questions', 
                'en'    => 'Questions', 
                'he'    => 'שאלות', 
                'ar'    => 'أسئلة'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'create_question', 
                'en'    => 'Create Question', 
                'he'    => 'צור שאלה', 
                'ar'    => 'إنشاء سؤال'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_question', 
                'en'    => 'Edit Question', 
                'he'    => 'ערוך שאלה', 
                'ar'    => 'تحرير السؤال'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'analysis', 
                'en'    => 'Analysis', 
                'he'    => 'אָנָלִיזָה', 
                'ar'    => 'تحليل'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'log', 
                'en'    => 'Log', 
                'he'    => 'עֵץ', 
                'ar'    => 'سجل'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'logs', 
                'en'    => 'Logs', 
                'he'    => 'יומנים', 
                'ar'    => 'السجلات'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'settings', 
                'en'    => 'Settings', 
                'he'    => 'ההגדרות', 
                'ar'    => 'إعدادات'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'setting', 
                'en'    => 'Setting', 
                'he'    => 'הגדרה', 
                'ar'    => 'ضبط'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'edit_setting', 
                'en'    => 'Edit Setting', 
                'he'    => 'ערוך הגדרה', 
                'ar'    => 'تحرير الإعداد'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'teacher_transaction', 
                'en'    => 'Teacher Transaction', 
                'he'    => 'עסקת מורה', 
                'ar'    => 'معاملات المعلم'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'teacher_transactions', 
                'en'    => 'Teacher Transactions', 
                'he'    => 'עסקאות מורים', 
                'ar'    => 'معاملات المعلم'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'transfer_money', 
                'en'    => 'Transfer Money', 
                'he'    => 'העבר כסף', 
                'ar'    => 'نقل الأموال'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'backup_db', 
                'en'    => 'Backup DB', 
                'he'    => 'גיבוי DB', 
                'ar'    => 'قاعدة بيانات احتياطية'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'restore_db', 
                'en'    => 'Restore DB', 
                'he'    => 'שחזר DB', 
                'ar'    => 'استعادة قاعدة بيانات'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'free_users', 
                'en'    => 'Free Users', 
                'he'    => 'משתמשים בחינם', 
                'ar'    => 'المستخدمين مجانا'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'free_user', 
                'en'    => 'Free User', 
                'he'    => 'משתמש חינמי', 
                'ar'    => 'مستخدم حر'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'download', 
                'en'    => 'Download', 
                'he'    => 'הורד', 
                'ar'    => 'تحميل'
            ], 
            [
                'type'  => 'web', 
                'key'   => 'details', 
                'en'    => 'Details', 
                'he'    => 'פרטים', 
                'ar'    => 'تفاصيل'
            ], 
        ]);
    }
}
