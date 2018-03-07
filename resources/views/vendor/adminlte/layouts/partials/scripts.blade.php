<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<script src="{{ url ('/js/js.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('/bower_components/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.fancybox.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/ZeroClipboard.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/select2.full.min.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    $(function() {
        var _menu = Cookies.get('_menu');
        var animationSpeed = 500;

        var menu_item = $(".m_" + _menu);
        var checkElement = menu_item.parent();

        if (checkElement.hasClass("sidebar-menu")) {
            menu_item.addClass("active");
        } else if (checkElement.hasClass("treeview-menu")) {
            menu_item.addClass("active");
            checkElement.addClass("menu-open");
            checkElement.parent().addClass("active");
        }
    });
</script>