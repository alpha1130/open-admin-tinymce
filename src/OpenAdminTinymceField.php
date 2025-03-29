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
        '//cdn.jsdelivr.net/npm/uuid@latest/dist/umd/uuidv4.min.js',
        '//cdn.jsdelivr.net/npm/tinymce@7.7.1/tinymce.min.js',
        '//cdn.jsdelivr.net/npm/cos-js-sdk-v5/dist/cos-js-sdk-v5.min.js',
        '/vendor/alpha1130/open-admin-tinymce/tinymce.editor.js',
    ];

    public function render()
    {

        if(!isset($this->variables['tinymceConfig']) || $this->variables['tinymceConfig'] == null) {
            throw new \Exception('tinymceConfig is required');
        }
        $tinymceConfig = json_encode($this->variables['tinymceConfig']);

        $cosConfig = 'null';
        if(isset($this->variables['cosConfig']) && $this->variables['cosConfig'] != null) {
            $cosConfig = json_encode(OpenAdminTinymceHelper::buildQCSTempKeys($this->variables['cosConfig']));
        }

        $this->script = "new TinymceEditor('{$this->getId()}', {$tinymceConfig}, {$cosConfig});";

        return parent::render();
    }
}