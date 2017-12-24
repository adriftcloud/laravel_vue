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
                default: ["advlist autolink link image lists charmap print preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor"],
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
                selector: `#${this.id}`,
                toolbar: this.toolbar,
                language: 'zh_TW',
                branding: false,
                image_advtab: true,
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                menubar: this.menubar,
                plugins: this.plugins,
                images_upload_handler: function (blobInfo, success, failure) {
                    let canvas = document.createElement('canvas')
                    let context = canvas.getContext('2d')
                    let pngUrl
                    if (blobInfo.blob()) {
                        let temp = blobInfo.blob()
                        let FR = new FileReader()
                        FR.onload = function (e) {
                            let img = new Image()
                            img.onload = function () {
                                canvas.width = img.width
                                canvas.height = img.height
                                context.drawImage(img, 0, 0)
                                pngUrl = canvas.toDataURL('image/jpeg')

                                axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8'
                                let fd = new FormData()
                                fd.append('image', pngUrl)
                                fd.append('extension', '.jpg')
                                axios.post(self.uploadBase, fd).then(function (res) {
                                    let temp = self.uploadDir + res.data
                                    success(temp);
                                    self.$emit('input', tinymce.activeEditor.getContent());
                                }).catch(function (error) {
                                    console.warn(error)
                                })
                            }
                            img.src = e.target.result
                        }
                        FR.readAsDataURL(temp)
                    }
                },
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function () {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function () {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);
                            cb(blobInfo.blobUri(), {title: file.name});
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
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