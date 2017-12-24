<template>
    <div>
        <textarea :id="id" :value="value"></textarea>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'tiny-mce',
        props: {
            id: {
                type: String,
                default: 'editor'
            },
            plugins: {
                default: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking table contextmenu directionality emoticons paste textcolor responsivefilemanager"
            },
            value: {
                type: String,
                default: ''
            },
            toolbar: {
                default: "undo redo | fontsizeselect bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor table | link unlink anchor | image media | preview code "
            },
            menubar: {
                default: false
            },
            uploadDir: {
                default: '/uploads/tinymce/'
            },
            uploadBase: {
                default: '/api/upload/image'
            },
            otherProps: {
                default: ''
            },
            baseURL: {
                type: String,
                default: '/js/tinymce'
            },
        },
        data() {
            return {}
        },
        mounted() {
            let self = this
            tinymce.baseURL = this.baseURL;
            tinymce.init({
                relative_urls: false,
                selector: `#${this.id}`,
                language: 'zh_TW',
                toolbar: this.toolbar,
                image_advtab: true,
                image_title: true,
                menubar: this.menubar,
                plugins: this.plugins,
                external_filemanager_path: "/filemanager/",
                filemanager_title: "檔案管理",
                filemanager_access_key: "AaBbCc69feksjvfjedklfvmkld98",
                external_plugins: {
                    "filemanager": "/filemanager/plugin.min.js"
                },
                init_instance_callback: (editor) => {
                    editor.on('KeyUp', (e) => {
                        this.$emit('input', editor.getContent());
                    });

                    editor.on('Change', (e) => {
                        this.$emit('input', editor.getContent());
                    });

                    editor.setContent(this.value);
                },
                ...this.otherProps
            })
        },
        updated() {
            // tinymce.get(this.id).setContent(this.value);
        },
        destroyed() {
            tinymce.get(this.id).destroy();
        }
    }
</script>