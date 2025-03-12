<?php

namespace Alpha1130\OpenAdminTinymce;

use OpenAdmin\Admin\Form\Field;

class OpenAdminTinymceField extends Field
{
    protected $view = 'open-admin-tinymce::field';

    protected static $css = [
        '//cdn.jsdelivr.net/npm/tinymce@7.7.1/skins/ui/oxide/content.min.css',
    ];

    protected static $js = [
        '//cdn.jsdelivr.net/npm/tinymce@7.7.1/tinymce.min.js',
        '//cdn.jsdelivr.net/npm/cos-js-sdk-v5/dist/cos-js-sdk-v5.min.js',
        '/vendor/alpha1130/open-admin-tinymce/tinymce.editor.js',
    ];

    public function render()
    {

        $config = config('tinymce');
        $config['qcs'] = OpenAdminTinymceHelper::buildQCSTempKeys($config['qcs']);
        $json = json_encode($config);

        $this->script = "new TinymceEditor('{$this->getId()}', {$json});";

        return parent::render();
    }
}