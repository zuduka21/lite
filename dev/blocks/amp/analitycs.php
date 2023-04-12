<?php

$_SERVER["HTTP_REFERER"] = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
 
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$yadro_url = '//counter.yadro.ru/hit?t52.6;r'.$_SERVER["HTTP_REFERER"].';u'.$actual_link.'h'.$cur_title.';'.rand();
?>

<amp-pixel  src="//counter.yadro.ru/hit?t52.6;r<?php echo $_SERVER["HTTP_REFERER"]; ?>;u"  layout="nodisplay"></amp-pixel>

<amp-analytics type="metrika">
    <script type="application/json">
        {
            "vars": {
                "counterId": "53943307"
            }
        }
    </script>
</amp-analytics>

<amp-analytics type="gtag" data-credentials="include">
	<script type="application/json">
		{
		  "vars" : {
		    "gtag_id": "UA-47915019-7",
		    "config" : {
		      "UA-47915019-7": { "groups": "default" }
		    }
		  }
		}
	</script>
</amp-analytics>

<amp-analytics type="topmailru" id="topmailru">
<script type="application/json">
{
      "vars": {
            "id": "2856632"
      }
}
</script>
</amp-analytics>
