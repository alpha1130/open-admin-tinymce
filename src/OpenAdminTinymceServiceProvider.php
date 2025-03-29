<?php

namespace Alpha1130\OpenAdminTinymce;

use Illuminate\Support\ServiceProvider;
use OpenAdmin\Admin\Form;

class OpenAdminTinymceServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(OpenAdminTinymce $extension)
    {
        if (! OpenAdminTinymce::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'open-admin-tinymce');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [
                    $assets => public_path('vendor/alpha1130/open-admin-tinymce'),
                ],
                'open-admin-tinymce'
            );
        }

        $this->app->booted(function () {
            Form::extend('tinymce', OpenAdminTinymceField::class);
        });
    }
}