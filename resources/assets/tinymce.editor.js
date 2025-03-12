class TinymceEditor {
    constructor(selector, config) {
        this.config = config;
        this.config.tinymce.selector = `.tinymce-editor-${selector}`;
        this.config.tinymce.file_picker_callback = (callback, value, meta) => {
            const fileInput = document.createElement('input');
            fileInput.setAttribute('type', 'file');
            fileInput.setAttribute('accept', 'image/png, image/jpeg');
            fileInput.style.display = 'none';
            fileInput.addEventListener('change', () => {
                const files = fileInput.files;

                if (!files || !files.length) {
                    return;
                }

                (new COS({
                    SecretId: this.config.qcs.credentials.tmpSecretId,
                    SecretKey: this.config.qcs.credentials.tmpSecretKey,
                    SecurityToken: this.config.qcs.credentials.sessionToken,
                    StartTime: this.config.qcs.startTime,
                    ExpiredTime: this.config.qcs.expiredTime,
                })).uploadFile({
                    Bucket: this.config.qcs.bucket,
                    Region: this.config.qcs.region,
                    Key: this.config.qcs.keyPrefix + files[0].name,
                    Body: files[0],
                    onProgress: (progressData) => {
                        NProgress.set(progressData.percent)
                    }
                }, (err, data) => {
                    NProgress.done()
                    if (err) {
                        console.log(err);
                    } else {
                        callback('//' + data.Location)
                    }
                    fileInput.value = '';
                })
            });

            fileInput.click();
        }
        
        tinymce.remove();
        tinymce.init(this.config.tinymce);
    }

}