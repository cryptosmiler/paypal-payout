<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Language;

class AppLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            [
                'type'  => 'app', 
                'key'   => 'delete', 
                'en'    => 'Delete', 
                'he'    => 'מחק', 
                'ar'    => 'احذف'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'confirm', 
                'en'    => 'Confirm', 
                'he'    => 'אישור', 
                'ar'    => 'أكد'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'cancel', 
                'en'    => 'Cancel', 
                'he'    => 'לְבַטֵל', 
                'ar'    => 'الإلغاء'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'update', 
                'en'    => 'Update', 
                'he'    => 'לְעַדְכֵּן', 
                'ar'    => 'التحديث'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'welcome_to_dali', 
                'en'    => 'Welcome to Dali', 
                'he'    => 'ברוך הבא לדאלי', 
                'ar'    => 'مرحبا بكم في دالي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'what_is_your_phone_number', 
                'en'    => 'What is your phone number?', 
                'he'    => 'מה מספר הטלפון שלך?', 
                'ar'    => 'ما هو رقم هاتفك؟'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'please_confirm_your_country_code_and_enter_your_phone_number', 
                'en'    => 'Please confirm your country code and enter your phone number.', 
                'he'    => 'אנא אשר את קידומת המדינה שלך והזן את מספר הטלפון שלך.', 
                'ar'    => 'يرجى تأكيد رمز البلد الخاص بك وإدخال رقم هاتفك.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'phone_is_not_valid', 
                'en'    => 'Phone is not valid.', 
                'he'    => 'הטלפון לא תקף.', 
                'ar'    => 'الهاتف غير صالح.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'send_verification_code', 
                'en'    => 'Send Verification Code', 
                'he'    => 'שלח קוד אימות', 
                'ar'    => 'إرسال رمز التحقق'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'please_enter_verification_code', 
                'en'    => 'Please enter verification code.', 
                'he'    => 'נא להזין קוד אימות.', 
                'ar'    => 'الرجاء إدخال رمز التحقق.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'we_have_sent_an_sms_with_an_activation_code_to_your_phone', 
                'en'    => "We've sent an SMS with an activation code to your phone", 
                'he'    => 'שלחנו הודעת SMS עם קוד הפעלה לטלפון שלך', 
                'ar'    => 'لقد أرسلنا رسالة نصية قصيرة تحتوي على رمز التفعيل إلى هاتفك'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'otp_invalid_or_expired', 
                'en'    => 'OTP Invalid or Expired', 
                'he'    => 'OTP לא חוקי או פג תוקף', 
                'ar'    => 'OTP غير صالح أو منتهي الصلاحية'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'resend_otp', 
                'en'    => 'Resend OTP', 
                'he'    => 'שלח שוב OTP', 
                'ar'    => 'إعادة إرسال OTP'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'you_can_request_a_new_code_in', 
                'en'    => 'You can request a new code in', 
                'he'    => 'אתה יכול לבקש קוד חדש ב', 
                'ar'    => 'يمكنك طلب رمز جديد في'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'verify_otp', 
                'en'    => 'Verify OTP', 
                'he'    => 'אמת OTP', 
                'ar'    => 'التحقق من كلمة مرور OTP'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'what_topic_would_you_like_to_learn', 
                'en'    => 'What topic would you like to learn?', 
                'he'    => 'איזה נושא היית רוצה ללמוד?', 
                'ar'    => 'ما الموضوع الذي ترغب في تعلمه؟'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'subject_wise_list', 
                'en'    => 'Subject Wise List', 
                'he'    => 'רשימה נבונה בנושא', 
                'ar'    => 'قائمة الموضوع الحكيمة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'recommended', 
                'en'    => 'Recommended', 
                'he'    => 'מוּמלָץ', 
                'ar'    => 'مُستَحسَن'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'my_selection', 
                'en'    => 'My selection', 
                'he'    => 'הבחירה שלי', 
                'ar'    => 'اختياري'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'most_popular', 
                'en'    => 'Most popular', 
                'he'    => 'הכי פופולארי', 
                'ar'    => 'الأكثر شعبية'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'most_viewed', 
                'en'    => 'Most viewed', 
                'he'    => 'הכי נצפה', 
                'ar'    => 'الأكثر مشاهدة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'recent_updated', 
                'en'    => 'Recent updated', 
                'he'    => 'עודכן לאחרונה', 
                'ar'    => 'تم التحديث مؤخرًا'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'filter_by', 
                'en'    => 'Filter By', 
                'he'    => 'סינון לפי', 
                'ar'    => 'تصفية حسب'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'last_seen', 
                'en'    => 'Last seen', 
                'he'    => 'נראה לאחרונה', 
                'ar'    => 'اخر ظهور'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'last_added', 
                'en'    => 'Last added', 
                'he'    => 'נוסף לאחרונה', 
                'ar'    => 'آخر يضاف'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'movies_i_already_saw', 
                'en'    => 'Movies I already saw', 
                'he'    => 'סרטים שכבר ראיתי', 
                'ar'    => 'الأفلام التي رأيتها بالفعل'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'previous_movie', 
                'en'    => 'Previous Movie', 
                'he'    => 'מִבְחָן', 
                'ar'    => 'امتحان'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'next_movie', 
                'en'    => 'Next Movie', 
                'he'    => 'הסרט הבא', 
                'ar'    => 'الفيلم القادم'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'easy', 
                'en'    => 'Easy', 
                'he'    => 'קַל', 
                'ar'    => 'سهل'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'medium', 
                'en'    => 'Medium', 
                'he'    => 'בינוני', 
                'ar'    => 'واسطة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'hard', 
                'en'    => 'Hard', 
                'he'    => 'קָשֶׁה', 
                'ar'    => 'صعب'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'distribution', 
                'en'    => 'Distribution', 
                'he'    => 'הפצה', 
                'ar'    => 'توزيع'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'home', 
                'en'    => 'Home', 
                'he'    => 'בית', 
                'ar'    => 'بيت'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'billings', 
                'en'    => 'Billings', 
                'he'    => 'חיובים', 
                'ar'    => 'الفواتير'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'my_balance', 
                'en'    => 'My Wallet', 
                'he'    => 'הארנק שלי', 
                'ar'    => 'محفظتى'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'promo_code', 
                'en'    => 'Promo Code', 
                'he'    => 'קוד קופון', 
                'ar'    => 'رمز ترويجي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'saved_cards', 
                'en'    => 'Saved Cards', 
                'he'    => 'כרטיסים שמורים', 
                'ar'    => 'البطاقات المحفوظة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'add_new_card', 
                'en'    => 'Add New Card', 
                'he'    => 'הוסף כרטיס חדש', 
                'ar'    => 'إضافة بطاقة جديدة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'card_detail', 
                'en'    => 'Card Detail', 
                'he'    => 'פרטי כרטיס', 
                'ar'    => 'تفاصيل البطاقة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'card_holder_name', 
                'en'    => 'Card Holder Name', 
                'he'    => 'שם בעל הכרטיס', 
                'ar'    => 'إسم صاحب البطاقة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'card_number', 
                'en'    => 'Card Number', 
                'he'    => 'מספר כרטיס', 
                'ar'    => 'رقم بطاقة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'expiry_date', 
                'en'    => 'Expiry Date', 
                'he'    => 'תאריך תפוגה', 
                'ar'    => 'تاريخ الانتهاء'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'save_card_deatils', 
                'en'    => 'Save Card Details', 
                'he'    => 'שמור פרטי כרטיס', 
                'ar'    => 'حفظ تفاصيل البطاقة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'add_new_promo_code', 
                'en'    => 'Add New Promo Code', 
                'he'    => 'הוסף קוד קידום חדש', 
                'ar'    => 'إضافة رمز ترويجي جديد'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'promotion_offers', 
                'en'    => 'Promotion Offers', 
                'he'    => 'הצעות קידום', 
                'ar'    => 'عروض الترويج'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'title_for_promo_code', 
                'en'    => 'Title for Promo Code', 
                'he'    => 'כותרת לקוד קידום', 
                'ar'    => 'عنوان للرمز الترويجي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'promocode', 
                'en'    => 'Promocode', 
                'he'    => 'קוד קופון', 
                'ar'    => 'رمز ترويجي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'add_promo_code', 
                'en'    => 'Add Promo Code', 
                'he'    => 'הוסף קוד קידום', 
                'ar'    => 'أضف الرمز الترويجي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'change_promo_code', 
                'en'    => 'Change Promo Code', 
                'he'    => 'שנה קוד קידום', 
                'ar'    => 'تغيير الرمز الترويجي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'are_you_sure_you_want_to_delete_this_item', 
                'en'    => 'Are you sure you want to delete this item?', 
                'he'    => 'מִבְחָן', 
                'ar'    => 'امتحان'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'policy', 
                'en'    => 'Welcome to the MOFET application (hereinafter, the application). The application was designed and designed for the MOFET family with an emphasis on providing a professional-social response to our students. For reasons of convenience only, the ceremony below is written in the masculine language, however, the text is addressed to both our female and male students.

Using the MOFET application you can get a professional-social answer to your questions in physics, mathematics and in general. The application allows you to distribute a question as text (written question), as a video or as a picture and ask for an answer from the other applet users - this is the social characteristic of the applet. That is, without necessarily knowing someone The second, you are invited to answer the questions asked and thus help others by contributing your knowledge and understanding.

However, as in any virtual, Internet or cellular system, there are users who may abuse the platform, so we invite you to be aware of the content of the questions and answers. If you come across content distributed in the application that is inappropriate, whether it is a video, image, offensive text or even a thread of questions and answers that is inappropriate, click on the "abuse" button and the user(s) will be blocked immediately, pending a thorough examination of the content published by editorial team.

The MOFET team wishes all our students a pleasant use and look forward to the application and good luck in your further studies.', 
                'he'    => 'ברוכים הבאים לאפליקציית MOFET (להלן, האפליקציה). האפליקציה תוכננה ועוצבה עבור משפחת MOFET תוך שימת דגש על מתן מענה מקצועי-חברתי לתלמידים שלנו. מטעמי נוחות בלבד, הטקס להלן כתוב בלשון זכר, אולם הטקסט מופנה לתלמידותינו ולתלמידותינו כאחד.

באמצעות אפליקציית MOFET תוכלו לקבל מענה מקצועי-חברתי לשאלותיכם בפיזיקה, מתמטיקה ובכלל. האפליקציה מאפשרת להפיץ שאלה כטקסט (שאלה כתובה), כסרטון או כתמונה ולבקש תשובה משאר משתמשי היישומון - זה המאפיין החברתי של היישומון. כלומר, מבלי להכיר מישהו בהכרח. השני, אתם מוזמנים לענות על השאלות שנשאלו ובכך לעזור לאחרים על ידי תרומה מהידע וההבנה שלכם.

עם זאת, כמו בכל מערכת וירטואלית, אינטרנטית או סלולרית, ישנם משתמשים שעלולים לעשות שימוש לרעה בפלטפורמה, ולכן אנו מזמינים אתכם להיות מודעים לתוכן השאלות והתשובות. אם נתקלתם בתוכן המופץ באפליקציה שאינו הולם, בין אם מדובר בסרטון, תמונה, טקסט פוגעני או אפילו שרשור שאלות ותשובות שאינו הולם, לחצו על כפתור "התעללות" והמשתמש/ים יהיו נחסם באופן מיידי, עד לבדיקה יסודית של התוכן שפורסם על ידי צוות המערכת.

צוות MOFET מאחל לכל תלמידינו שימוש נעים ומצפה ליישום ובהצלחה בהמשך הלימודים.', 
                'ar'    => 'مرحبًا بك في تطبيق MOFET (يشار إليه فيما بعد بالتطبيق). تم تصميم التطبيق وتصميمه لعائلة MOFET مع التركيز على توفير استجابة مهنية واجتماعية لطلابنا. ولأسباب التيسير فقط، تم كتابة الحفل أدناه باللغة المذكرة، إلا أن النص موجه إلى طلابنا وطلابنا على حد سواء.

باستخدام تطبيق MOFET يمكنك الحصول على إجابة مهنية واجتماعية لأسئلتك في الفيزياء والرياضيات وبشكل عام. يتيح لك التطبيق توزيع سؤال كنص (سؤال مكتوب)، أو كفيديو أو كصورة وطلب الإجابة من مستخدمي التطبيق الصغير الآخرين - وهذه هي الخاصية الاجتماعية للتطبيق الصغير. أي دون بالضرورة أن تعرف شخصًا ما. والثاني، أنت مدعو للإجابة على الأسئلة المطروحة وبالتالي مساعدة الآخرين من خلال المساهمة بمعرفتك وفهمك.

ومع ذلك، كما هو الحال في أي نظام افتراضي أو إنترنت أو خلوي، هناك مستخدمون قد يسيئون استخدام المنصة، لذلك ندعوك إلى أن تكون على دراية بمحتوى الأسئلة والأجوبة. إذا صادفت محتوى غير لائق تم توزيعه في التطبيق، سواء كان مقطع فيديو أو صورة أو نصًا مسيءًا أو حتى سلسلة من الأسئلة والأجوبة غير لائقة، فانقر على زر "إساءة الاستخدام" وسيتم حذف المستخدم (المستخدمين) تم حظره على الفور، في انتظار إجراء فحص شامل للمحتوى المنشور من قبل فريق التحرير.

يتمنى فريق MOFET لجميع طلابنا استخدامًا ممتعًا ويتطلع إلى التطبيق ونتمنى لك حظًا سعيدًا في دراساتك الإضافية.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'privacy_policy', 
                'en'    => 'Privacy Policy', 
                'he'    => 'מדיניות הפרטיות', 
                'ar'    => 'سياسة الخصوصية'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'agree_policy', 
                'en'    => 'Agree Policy', 
                'he'    => 'מסכים למדיניות', 
                'ar'    => 'توافق على السياسة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'do_you_want_to_log_out_of_the_system', 
                'en'    => 'Do you want to log out of the system?', 
                'he'    => 'האם אתה רוצה להתנתק מהמערכת?', 
                'ar'    => 'هل تريد تسجيل الخروج من النظام؟'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'edit_profile', 
                'en'    => 'Edit Profile', 
                'he'    => 'עריכת פרופיל', 
                'ar'    => 'تعديل الملف الشخصي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'full_name', 
                'en'    => 'Full Name', 
                'he'    => 'שם מלא', 
                'ar'    => 'الاسم الكامل'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'email', 
                'en'    => 'Email', 
                'he'    => 'אימייל', 
                'ar'    => 'البريد الإلكتروني'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'avatar', 
                'en'    => 'Avatar', 
                'he'    => 'אווטאר', 
                'ar'    => 'أفاتار'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'policy_acceptance_date', 
                'en'    => 'Policy Acceptance Date', 
                'he'    => 'תאריך אישור הפוליסה', 
                'ar'    => 'تاريخ قبول السياسة'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'pay', 
                'en'    => 'Pay', 
                'he'    => 'לְשַׁלֵם', 
                'ar'    => 'يدفع'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'my_balance', 
                'en'    => 'My Balance', 
                'he'    => 'האיזון שלי', 
                'ar'    => 'رصيدي'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'sort_by', 
                'en'    => 'Sort By', 
                'he'    => 'מיין לפי', 
                'ar'    => 'صنف حسب'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'close', 
                'en'    => 'Close', 
                'he'    => 'קָרוֹב', 
                'ar'    => 'يغلق'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'successful', 
                'en'    => 'Successful !', 
                'he'    => 'מוצלח!', 
                'ar'    => 'ناجحة !'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'unsuccessful', 
                'en'    => 'Unsuccessful !', 
                'he'    => 'לא מוצלח!', 
                'ar'    => 'غير ناجح!'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'close', 
                'en'    => 'Close', 
                'he'    => 'קָרוֹב', 
                'ar'    => 'يغلق'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'your_bill_was_successfully', 
                'en'    => 'Your bill was successfully.', 
                'he'    => 'החשבון שלך עבר בהצלחה.', 
                'ar'    => 'لقد تمت فاتورتك بنجاح.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'we_were_unable_to_charge_your_card', 
                'en'    => 'We were unable to charge your card.', 
                'he'    => 'לא הצלחנו לחייב את הכרטיס שלך.', 
                'ar'    => 'لم نتمكن من شحن بطاقتك.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'please_re_check_billing_information', 
                'en'    => 'Please re-check billing information.', 
                'he'    => 'בדוק שוב את פרטי החיוב.', 
                'ar'    => 'يرجى إعادة التحقق من معلومات الفواتير.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'charged_for', 
                'en'    => 'charged for', 
                'he'    => 'מחויב עבור', 
                'ar'    => 'تم شحنه الى'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'you_should_add_a_card_and_set_the_default_card', 
                'en'    => 'You should add a card and set the default card.', 
                'he'    => 'עליך להוסיף כרטיס ולהגדיר את כרטיס ברירת המחדל.', 
                'ar'    => 'يجب عليك إضافة بطاقة وتعيين البطاقة الافتراضية.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'your_purchase_was_successful', 
                'en'    => 'Your purchase was successful.', 
                'he'    => 'הרכישה שלך הצליחה.', 
                'ar'    => 'عملية الشراء كانت ناجحة.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'your_purchase_was_unsuccessful', 
                'en'    => 'Your purchase was unsuccessful.', 
                'he'    => 'הרכישה שלך נכשלה.', 
                'ar'    => 'عملية الشراء الخاصة بك لم تكن ناجحة.'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'close', 
                'en'    => 'Close', 
                'he'    => 'קָרוֹב', 
                'ar'    => 'يغلق'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'close', 
                'en'    => 'Close', 
                'he'    => 'קָרוֹב', 
                'ar'    => 'يغلق'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'close', 
                'en'    => 'Close', 
                'he'    => 'קָרוֹב', 
                'ar'    => 'يغلق'
            ], 
            [
                'type'  => 'app', 
                'key'   => 'close', 
                'en'    => 'Close', 
                'he'    => 'קָרוֹב', 
                'ar'    => 'يغلق'
            ], 
        ]);
    }
}