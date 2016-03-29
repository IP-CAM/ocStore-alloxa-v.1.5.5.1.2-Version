</div>
<script type="text/javascript"><!--
        $(document).ready(function() {
        $(".list tr:even").css("background-color", "#F4F4F8");

        var $window = $(window), $navigation = $("#button-L");
        $window.scroll(function() {
                if (!$navigation.hasClass("fixed") && ($window.scrollTop()+10 > $navigation.offset().top)) {
                        $navigation.addClass("fixed").data("top", $navigation.offset().top);
                } else if ($navigation.hasClass("fixed") && ($window.scrollTop()+10 < $navigation.data("top"))) {
                        $navigation.removeClass("fixed");
                }
        });
        });
</script>
<div id="footer"><?php echo $text_footer; ?></div>
</body></html>