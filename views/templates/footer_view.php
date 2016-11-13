
<section id="footer_top_area">
    <div class="clearfix wrapper footer_top">
        <div class="clearfix footer_top_container">
            <div class="clearfix single_footer_top floatleft">
                <h2>From Twitter</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <a href="">Lorem Ipsum has been the industry</a> standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            <div class="clearfix single_footer_top floatleft">
                <h2>Recent Post</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy <a href="">Lorem Ipsum has been the industry</a> text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            <div class="clearfix single_footer_top floatleft">
                <h2>Usefull Links</h2>
                <ul>
                    <li><a href="">Important links of this site</a></li>
                    <li><a href="">Important links of this site</a></li>
                    <li><a href="">Important links of this site</a></li>
                    <li><a href="">Important links of this site</a></li>
                    <li><a href="">Important links of this site</a></li>
                    <li><a href="">Important links of this site</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="footer_bottom_area">
    <div class="clearfix wrapper footer_bottom">
        <div class="clearfix copyright floatleft">
            <p> Copyright &copy; All rights reserved by <span>Tany</span></p>
        </div>
        <div class="clearfix social floatright">
            <ul>
                <li><a class="tooltip" title="Facebook" href=""><i class="fa fa-facebook-square"></i></a></li>
                <li><a class="tooltip" title="Twitter" href=""><i class="fa fa-twitter-square"></i></a></li>
                <li><a class="tooltip" title="Google+" href=""><i class="fa fa-google-plus-square"></i></a></li>
                <li><a class="tooltip" title="LinkedIn" href=""><i class="fa fa-linkedin-square"></i></a></li>
                <li><a class="tooltip" title="tumblr" href=""><i class="fa fa-tumblr-square"></i></a></li>
                <li><a class="tooltip" title="Pinterest" href=""><i class="fa fa-pinterest-square"></i></a></li>
                <li><a class="tooltip" title="RSS Feed" href=""><i class="fa fa-rss-square"></i></a></li>
                <li><a class="tooltip" title="Sitemap" href=""><i class="fa fa-sitemap"></i> </a></li>
            </ul>
        </div>
    </div>
</section>


<script type="text/javascript" src="<?= _URL_PATH?>js/jquery.tooltipster.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.tooltip').tooltipster();
    });
</script>
<script type="text/javascript" src="<?= _URL_PATH?>js/selectnav.min.js"></script>
<script type="text/javascript">
    selectnav('nav', {
        label: '-Navigation-',
        nested: true,
        indent: '-'
    });
</script>
<script src="<?= _URL_PATH?>js/pgwslider.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.pgwSlider').pgwSlider({

            intervalDuration: 5000

        });
    });
</script>
<script type="text/javascript" src="<?= _URL_PATH?>js/placeholder_support_IE.js"></script>

</body>
</html>