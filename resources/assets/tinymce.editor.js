class TinymceEditor {
    constructor(selector, tinymceConfig, cosConfig) {
        tinymceConfig.selector = `.tinymce-editor-${selector}`;

        if(!!cosConfig) {
            this.initCos(tinymceConfig, cosConfig);
        }

        tinymce.remove();
        tinymce.init(tinymceConfig);
    }

    initCos(tinymceConfig, cosConfig) {
        tinymceConfig.file_picker_callback = (callback, value, meta) => {
            const fileInput = document.createElement('input');
            fileInput.setAttribute('type', 'file');
            fileInput.setAttribute('accept', 'image/png, image/jpeg');
            fileInput.style.display = 'none';
            fileInput.addEventListener('change', () => {
                const files = fileInput.files;

                if (!files || !files.length) {
                    return;
                }

                const suffix = files[0].name.match(/[A-Za-z0-9]+$/)[0];

                (new COS({
                    SecretId: cosConfig.credentials.tmpSecretId,
                    SecretKey: cosConfig.credentials.tmpSecretKey,
                    SecurityToken: cosConfig.credentials.sessionToken,
                    StartTime: cosConfig.startTime,
                    ExpiredTime: cosConfig.expiredTime,
                })).uploadFile({
                    Bucket: cosConfig.bucket,
                    Region: cosConfig.region,
                    Key: cosConfig.keyPrefix + uuidv4() + suffix,
                    Body: files[0],
                    onProgress: (progressData) => {
                        NProgress.set(progressData.percent)
                    }
                }, (err, data) => {
                    NProgress.done()
                    if (err) {
                        console.log(err);
                    } else {
                        const url = 'https://' + (
                            cosConfig.publishDomain 
                            ? data.Location.replace(/^[^\/]+/, cosConfig.publishDomain) 
                            : data.Location);
                        callback(url)
                    }
                    fileInput.value = '';
                })
            });

            fileInput.click();
        }
    }

}