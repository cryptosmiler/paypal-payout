<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

use App\Models\Language;
use App\Models\Setting;


class LanguageProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind('language', function () {
            $locale = App::currentLocale();

            return Language::where('type', 'web')->pluck($locale, 'key')->toArray();
        });

        $this->app->bind('messages', function () {
            $locale = App::currentLocale();

            return Language::where('type', 'message')
                ->get()
                ->groupBy('key')
                ->map(function ($group) use ($locale) {

                    if(count($group) == 1) {
                        $val = "";
                        if($locale == "en") {
                            $val = $group[0]->en;
                        } else if ($locale == "he") {
                            $val = $group[0]->he;
                        } else if ($locale == "ar") {
                            $val = $group[0]->ar;
                        }

                        return $val;
                    }

                    return $group->mapWithKeys(function ($item) use ($locale) {
                        $val = "";
                        if($locale == "en") {
                            $val = $item->en;
                        } else if ($locale == "he") {
                            $val = $item->he;
                        } else if ($locale == "ar") {
                            $val = $item->ar;
                        }

                        return [$item->sub_key => $val];
                    });
                })
                ->toArray();
        });

        $this->app->bind('setting', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }
}
