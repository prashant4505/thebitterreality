import {
    ClassicEditor,
    Essentials,
    PasteFromOffice,
    Heading,
    FontFamily,
    FontSize,
    FontColor,
    FontBackgroundColor,
    Bold,
    Italic,
    Underline,
    Strikethrough,
    Subscript,
    Superscript,
    RemoveFormat,
    Alignment,
    List,
    Indent,
    IndentBlock,
    BlockQuote,
    Link,
    Image,
    ImageUpload,
    ImageToolbar,
    ImageStyle,
    ImageResize,
    ImageCaption,
    ImageTextAlternative,
    ImageInsertViaUrl,
    Table,
    TableToolbar,
    TableProperties,
    TableCellProperties,
    HorizontalLine,
    SpecialCharacters,
    SpecialCharactersEssentials,
    SourceEditing,
    FindAndReplace,
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

/* ── Custom upload adapter — posts to the existing /admin/upload-image route ──
   The controller already responds with { uploaded: 1, fileName, url }, which
   is compatible with the { default: <url> } shape CKEditor 5 expects. ── */
class AdminImageUploadAdapter {
    constructor(loader, uploadUrl, csrfToken) {
        this.loader = loader;
        this.uploadUrl = uploadUrl;
        this.csrfToken = csrfToken;
    }

    upload() {
        return this.loader.file.then((file) => new Promise((resolve, reject) => {
            const data = new FormData();
            data.append('upload', file);

            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', this.uploadUrl, true);
            xhr.responseType = 'json';
            xhr.setRequestHeader('X-CSRF-TOKEN', this.csrfToken);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.addEventListener('error', () => reject('Upload failed.'));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;
                if (!response || !response.url || xhr.status < 200 || xhr.status >= 300) {
                    reject((response && response.message) || 'Upload failed.');
                    return;
                }
                resolve({ default: response.url });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', (evt) => {
                    if (evt.lengthComputable) {
                        this.loader.uploadTotal = evt.total;
                        this.loader.uploaded = evt.loaded;
                    }
                });
            }

            xhr.send(data);
        }));
    }

    abort() {
        if (this.xhr) this.xhr.abort();
    }
}

function adminImageUploadAdapterPlugin(uploadUrl, csrfToken) {
    return function (editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) =>
            new AdminImageUploadAdapter(loader, uploadUrl, csrfToken);
    };
}

const EDITOR_CONFIG_BASE = {
    licenseKey: 'GPL',
    plugins: [
        Essentials, PasteFromOffice,
        Heading,
        FontFamily, FontSize, FontColor, FontBackgroundColor,
        Bold, Italic, Underline, Strikethrough, Subscript, Superscript, RemoveFormat,
        Alignment,
        List, Indent, IndentBlock,
        BlockQuote, Link,
        Image, ImageUpload, ImageToolbar, ImageStyle, ImageResize, ImageCaption, ImageTextAlternative, ImageInsertViaUrl,
        Table, TableToolbar, TableProperties, TableCellProperties,
        HorizontalLine, SpecialCharacters, SpecialCharactersEssentials,
        FindAndReplace, SourceEditing,
    ],
    toolbar: {
        items: [
            'undo', 'redo',
            '|', 'heading',
            '|', 'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor',
            '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'removeFormat',
            '|', 'alignment',
            '|', 'bulletedList', 'numberedList', 'outdent', 'indent',
            '|', 'blockQuote', 'link', 'insertImage', 'insertTable', 'horizontalLine', 'specialCharacters',
            '|', 'findAndReplace', 'sourceEditing',
        ],
        shouldNotGroupWhenFull: true,
    },
    image: {
        toolbar: [
            'imageTextAlternative', 'toggleImageCaption', '|',
            'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', '|',
            'resizeImage',
        ],
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties'],
    },
    fontFamily: { supportAllValues: true },
    fontSize: { options: [10, 12, 'default', 16, 18, 20, 24, 28], supportAllValues: true },
    link: { addTargetToExternalLinks: true },
};

/* ── Replace every `textarea.use-ckeditor` with a CKEditor 5 instance and
   keep the underlying textarea synced so form submissions carry the data ── */
function initAdminEditors() {
    const uploadUrl = document.body.dataset.uploadUrl;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const editors = [];

    document.querySelectorAll('textarea.use-ckeditor').forEach((textarea) => {
        ClassicEditor.create(textarea, {
            ...EDITOR_CONFIG_BASE,
            extraPlugins: [adminImageUploadAdapterPlugin(uploadUrl, csrfToken)],
        })
            .then((editor) => editors.push(editor))
            .catch((error) => console.error('CKEditor 5 failed to initialize:', error));
    });

    document.querySelectorAll('.ck-tabbed-form').forEach((form) => {
        form.addEventListener('submit', () => {
            editors.forEach((editor) => editor.updateSourceElement());
        });
    });
}

document.addEventListener('DOMContentLoaded', initAdminEditors);
