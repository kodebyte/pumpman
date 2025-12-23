@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    
    <script>
        // 1. CKEDITOR SETUP (Tetap sama, tidak berubah)
        class MyUploadAdapter {
            constructor(loader) { this.loader = loader; }
            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
            }
            abort() { if (this.xhr) { this.xhr.abort(); } }
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('admin.media.upload') }}", true);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhr.responseType = 'json';
            }
            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;
                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }
                    resolve({ default: response.url });
                });
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }
            _sendRequest(file) {
                const data = new FormData();
                data.append('upload', file);
                this.xhr.send(data);
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        function initEditor(selector) {
            if(document.querySelector(selector)) {
                ClassicEditor.create(document.querySelector(selector), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: { items: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'undo', 'redo'] }
                }).catch(error => { console.error(error); });
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            initEditor('#description_en');
            initEditor('#description_id');

            initEditor('#content_en');
            initEditor('#content_id');
        });
    </script>

    <style>
        .ck-editor__editable_inline { min-height: 300px; }
        .ck-content ul { list-style-type: disc; padding-left: 20px; }
        .ck-content ol { list-style-type: decimal; padding-left: 20px; }
    </style>
@endpush