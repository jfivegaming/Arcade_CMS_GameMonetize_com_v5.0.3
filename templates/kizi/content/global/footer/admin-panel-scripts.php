<script type="text/javascript" src="{{CONFIG_THEME_PATH}}/js/admin/engine-admin.js"></script>
<script type="text/javascript" src="{{CONFIG_THEME_PATH}}/js/libs/owl/owl.carousel.min.js"></script>
<script type="text/javascript" src="{{CONFIG_THEME_PATH}}/js/libs/sweetalert.min.js"></script>
<script type="text/javascript" src="{{CONFIG_THEME_PATH}}/js/libs/bigscreen.min.js"></script>
<script type="text/javascript" src="{{CONFIG_THEME_PATH}}/js/libs/toast.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.9.2/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        if ($('.tinymce').length > 0) {
            tinymce.init({
                forced_root_block: '',
                force_br_newlines : false,
                force_p_newlines : false,
                selector: 'textarea.tinymce',
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [{
                        title: 'Title h1',
                        block: 'h1'
                    },
                    {
                        title: 'Title h2',
                        block: 'h2'
                    },
                    {
                        title: 'Title h3',
                        block: 'h3'
                    },
                    {
                        title: 'Bold text',
                        inline: 'b'
                    },
                    {
                        title: 'Table styles'
                    },
                    {
                        title: 'Table row 1',
                        selector: 'tr',
                        classes: 'tablerow1'
                    }
                ],
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave();
                    });
                    editor.on('init', function() {
                        $('.tox-edit-area__iframe').css('background-color','rgb(225 226 228)');
                        $('.tox-edit-area__iframe').css('color','#8a909');
                        $('.tox-toolbar__primary').css('background-color','#2b2f3c');
                        $('.tox-toolbar__primary').css('color','#8a909');
                        $('.tox-menubar').css('background-color','#2b2f3c');
                        $('.tox-menubar').css('color','#8a909');
                        $('.tox-mbtn__select-label').css('color','grey');
                        $('.tox-tbtn__select-label').css('color','grey');
                        $('.tox-tbtn__icon-wrap svg').css('fill','grey');
                        $('.tox-tbtn__select-chevron svg').css('fill','grey');
                        $('.mce-content-body').css('color','grey');
                    });
                },
                entity_encoding: 'raw',
            });
        }
        $('.select2').select2();
    });
</script>