<?php
	$analyticsID = elgg_get_plugin_setting('analytics', 'google_analytics');
?>

<!-- This website tracking code is to track a single domain (eg. www.yourdomain.com) . For more information, see http://code.google.com/apis/analytics/docs/tracking/asyncTracking.html -->

<!-- Google Analytics tracking Code-->
<script type="text/javascript">

	var _gaq = _gaq || [];
	var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
	_gaq.push(['_require', 'inpage_linkid', pluginUrl]);  
	_gaq.push(['_setAccount', '<?php echo $analyticsID; ?>']);
	_gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- Google Analytics tracking Code-->
<script type="text/javascript">
  var _kmq = _kmq || [];
  var _kmk = _kmk || '6c04c28767b71ee587eca1c9fc0c83f1eada7a3c';
  function _kms(u){
    setTimeout(function(){
      var d = document, f = d.getElementsByTagName('script')[0],
      s = d.createElement('script');
      s.type = 'text/javascript'; s.async = true; s.src = u;
      f.parentNode.insertBefore(s, f);
    }, 1);
  }
  _kms('//i.kissmetrics.com/i.js');
  _kms('//doug1izaerwt3.cloudfront.net/' + _kmk + '.1.js');
</script>
<!-- End KissMetrics tracking Code-->


