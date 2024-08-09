<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Language;


class MessageLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            [
                'type'      => 'message', 
                'key'       => 'required', 
                'sub_key'   => '', 
                'en'        => 'The :attribute field is required.', 
                'he'        => 'השדה :attribute נדרש.', 
                'ar'        => 'الحقل :attribute مطلوب.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'string', 
                'sub_key'   => '', 
                'en'        => 'The :attribute field must be a string.', 
                'he'        => 'השדה :attribute חייב להיות מחרוזת.', 
                'ar'        => 'يجب أن يكون الحقل :attribute عبارة عن سلسلة.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'max', 
                'sub_key'   => 'array', 
                'en'        => 'The :attribute field must not have more than :max items.', 
                'he'        => 'השדה :attribute לא יכול לכלול יותר מפריטים :max.', 
                'ar'        => 'يجب ألا يحتوي حقل :attribute على أكثر من :max من العناصر.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'max', 
                'sub_key'   => 'file', 
                'en'        => 'The :attribute field must not be greater than :max kilobytes.', 
                'he'        => 'השדה :attribute לא יכול להיות גדול מ-:max קילובייט.', 
                'ar'        => 'يجب ألا يكون حقل :attribute أكبر من :max كيلو بايت.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'max', 
                'sub_key'   => 'numeric', 
                'en'        => 'The :attribute field must not be greater than :max.', 
                'he'        => 'השדה :attribute לא יכול להיות גדול מ-:max.', 
                'ar'        => 'يجب ألا يكون حقل :attribute أكبر من :max.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'max', 
                'sub_key'   => 'string', 
                'en'        => 'The :attribute field must not be greater than :max characters.', 
                'he'        => 'השדה :attribute לא יכול להיות גדול מ- :max תווים.', 
                'ar'        => 'يجب ألا يكون الحقل :attribute أكبر من أحرف :max.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'email', 
                'sub_key'   => '', 
                'en'        => 'The :attribute field must be a valid email address.', 
                'he'        => 'השדה :attribute חייב להיות כתובת דוא"ל חוקית.', 
                'ar'        => 'يجب أن يكون الحقل:attribute عنوان بريد إلكتروني صالحًا.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'unique', 
                'sub_key'   => '', 
                'en'        => 'The :attribute has already been taken.', 
                'he'        => 'ה-:attribute כבר נלקח.', 
                'ar'        => 'لقد تم بالفعل أخذ :attribute.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'min', 
                'sub_key'   => 'array', 
                'en'        => 'The :attribute field must have at least :min items.', 
                'he'        => 'השדה :attribute חייב לכלול פריטים :min לפחות.', 
                'ar'        => 'يجب أن يحتوي حقل :attribute على عناصر :min على الأقل.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'min', 
                'sub_key'   => 'file', 
                'en'        => 'The :attribute field must be at least :min kilobytes.', 
                'he'        => 'השדה :attribute חייב להיות לפחות :min קילובייט.', 
                'ar'        => 'يجب أن يكون حقل :attribute على الأقل:min كيلو بايت.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'min', 
                'sub_key'   => 'numeric', 
                'en'        => 'The :attribute field must be at least :min.', 
                'he'        => 'השדה :attribute חייב להיות לפחות :min.', 
                'ar'        => 'يجب أن يكون الحقل:attribute على الأقل:min.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'min', 
                'sub_key'   => 'string', 
                'en'        => 'The :attribute field must be at least :min characters.', 
                'he'        => 'השדה :attribute חייב להיות לפחות תווים :min.', 
                'ar'        => 'يجب أن يحتوي حقل :attribute على الأقل على أحرف:min.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'confirmed', 
                'sub_key'   => '', 
                'en'        => 'The :attribute field confirmation does not match.', 
                'he'        => 'אישור השדה :attribute אינו תואם.', 
                'ar'        => 'تأكيد حقل :attribute غير متطابق.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'size', 
                'sub_key'   => 'array', 
                'en'        => 'The :attribute field must contain :size items.', 
                'he'        => 'השדה :attribute חייב להכיל פריטי :size.', 
                'ar'        => 'يجب أن يحتوي حقل :attribute على عناصر :size.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'size', 
                'sub_key'   => 'file', 
                'en'        => 'The :attribute field must be :size kilobytes.', 
                'he'        => 'השדה :attribute חייב להיות :size קילובייט.', 
                'ar'        => 'يجب أن يكون حقل :attribute :size بالكيلوبايت.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'size', 
                'sub_key'   => 'numeric', 
                'en'        => 'The :attribute field must be :size.', 
                'he'        => 'השדה :attribute חייב להיות :size.', 
                'ar'        => 'يجب أن يكون حقل :attribute :size.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'size', 
                'sub_key'   => 'string', 
                'en'        => 'The :attribute field must be :size characters.', 
                'he'        => 'השדה :attribute חייב להיות תווים :size.', 
                'ar'        => 'يجب أن يتكون حقل :attribute من أحرف :size.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'exists', 
                'sub_key'   => '', 
                'en'        => 'The selected :attribute is invalid.', 
                'he'        => 'ה-:attribute שנבחר אינו חוקי.', 
                'ar'        => ':attribute المحدد غير صالح.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'date', 
                'sub_key'   => '', 
                'en'        => 'The :attribute field must be a valid date.', 
                'he'        => 'השדה :attribute חייב להיות תאריך חוקי.', 
                'ar'        => 'يجب أن يكون الحقل:attribute تاريخًا صالحًا.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'mimes', 
                'sub_key'   => '', 
                'en'        => 'The :attribute field must be a file of type: :values.', 
                'he'        => 'השדה :attribute חייב להיות קובץ מסוג: :values.', 
                'ar'        => 'يجب أن يكون الحقل:attribute ملفًا من النوع: :values.'
            ], 
            [
                'type'      => 'message', 
                'key'       => 'logs', 
                'sub_key'   => '', 
                'en'        => 'Logs', 
                'he'        => 'יומנים', 
                'ar'        => 'السجلات'
            ], 
        ]);
    }
}
