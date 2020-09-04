<?php
/**
*  @package        :  Tracking Master
*  @author         :  Tompidev
*  @website        :  https://github.com/tompidev
*  @email          :  support@tompidev.com
*  @license        :  MIT
*
*  @last-modified  :  2020-09-04 22:19:18 CET
*  @release        :  1.1.0
**/

class pluginTrackingMaster extends Plugin {

  public function init() {
    $this->dbFields = array(
		'ga-select'=>'no',              // Google select
		'ga-id'=>'',                    // Google analytics account number
		'clicky-select'=>'no',          // Clicky select
		'clicky-js'=>'async',           // Clicky javascript code type
		'clicky-id'=>'',                // Clicky website ID
		'woopra-select'=>'no',          // Woopra select
		'woopra-id'=>'',                // Woopra website domain
		'histats-select'=>'no',         // Histats select
		'histats-js'=>'async',          // Histats javascript code
		'histats-id'=>''                // Histats website ID
    );

    define('HTML_PATH_ASSETS', HTML_PATH_PLUGINS.'tracking-master/assets/');
  }

	public function form()
	{
		global $L;
		global $site;

        /*
        * Show the description of the plugin in the settings
        */
		$html  = PHP_EOL.'<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
        $html .= '</div>'.PHP_EOL;

        /*
        * Show warning message about new plugin release
        * upgrade is necessary
        * controlled by ajax
        */
        $html .= '<div id="tmVersionAlert" class="alert alert-light alert-dismissible border-danger text-danger d-none" role="alert">' . $L->g('new-release-warning') . '' . PHP_EOL;
        $html .= '<a id="learnMore" type="button" class="btn btn-danger btn-sm text-light ml-2" data-toggle="modal" data-target="#versionModal">' . $L->g('Learn more') . '</a>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;

        /*
        * Google analytics
        */
		$html .= '<div class="card mt-3">'.PHP_EOL;
		$html .= '<div class="card-body">'.PHP_EOL;
		$html .= '<h3><span><img src="'.HTML_PATH_ASSETS.'img/ga-logo.jpg"></span>Google analytics</h3>'.PHP_EOL;
		$html .= '<p class="no-account mt-1">'.$L->get('Do not have an account yet? Register here').': <a href="https://analytics.google.com/" target="_blank"><span class="fa fa-external-link"></span></a></p>'.PHP_EOL;
		$html .= '<div class="form-group">'.PHP_EOL;
		$html .= '<label>'.$L->get('Do you want to use this service?').'</label>'.PHP_EOL;
		$html .= '<select class="col-6 col-lg-3" name="ga-select" id="ga-select">'.PHP_EOL;
		$html .= '<option value="no" '.($this->getValue('ga-select')==='no'?'selected':'').'>'.$L->g('No').'</option>'.PHP_EOL;
		$html .= '<option value="yes" '.($this->getValue('ga-select')==='yes'?'selected':'').'>'.$L->g('Yes').'</option>'.PHP_EOL;
		$html .= '</select>'.PHP_EOL;
		$html .= '<div id="ga-div" class="d-none mt-1">'.PHP_EOL;
		$html .= '<label>Google Analytics '.$L->get('account number').'</label>'.PHP_EOL;
		$html .= '<input id="ga-id" class="col-xl-6" name="ga-id" type="text" value="'.$this->getValue('ga-id').'">'.PHP_EOL;
		$html .= '<span class="tip">'.$L->get('Please enter your Google Analytics account number e.g.').' UA-012345678-9</span>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

        /*
        * Clicky
        */
		$html .= '<div class="card mt-2">'.PHP_EOL;
		$html .= '<div class="card-body">'.PHP_EOL;
		$html .= '<div class="form-group">'.PHP_EOL;
		$html .= '<h3><span><img src="'.HTML_PATH_ASSETS.'img/clicky-logo.jpg"></span>Clicky</h3>'.PHP_EOL;
		$html .= '<p class="no-account mt-1">'.$L->get('Do not have an account yet? Register here').': <a href="https://clicky.com" target="_blank"><span class="fa fa-external-link"></span></a></p>'.PHP_EOL;
		$html .= '<label>'.$L->get('Do you want to use this service?').'</label>'.PHP_EOL;
		$html .= '<select class="col-6 col-lg-3" name="clicky-select" id="clicky-select">'.PHP_EOL;
		$html .= '<option value="no" '.($this->getValue('clicky-select')==='no'?'selected':'').'>'.$L->g('No').'</option>'.PHP_EOL;
		$html .= '<option value="yes" '.($this->getValue('clicky-select')==='yes'?'selected':'').'>'.$L->g('Yes').'</option>'.PHP_EOL;
		$html .= '</select>'.PHP_EOL;
		$html .= '<div id="clicky-div" class="d-none mt-1">'.PHP_EOL;
		$html .= '<label>'.$L->get('Please choose a tracking code type').'</label>'.PHP_EOL;
		$html .= '<select class="col-6 col-lg-3" name="clicky-js" id="clicky-js">'.PHP_EOL;
		$html .= '<option value="async" '.($this->getValue('clicky-js')==='async'?'selected':'').'>'.$L->g('Async').'</option>'.PHP_EOL;
		$html .= '<option value="nojs" '.($this->getValue('clicky-js')==='nojs'?'selected':'').'>'.$L->g('No Javascript').'</option>'.PHP_EOL;
		$html .= '</select>'.PHP_EOL;
		$html .= '<span id="clicky-code-type-hint" class="js-tip text-primary"></span>'.PHP_EOL;
		$html .= '<label>'.$L->get('Clicky website ID').'</label>'.PHP_EOL;
		$html .= '<input id="clicky-id" class="col-xl-6 mt-1" name="clicky-id" type="text" value="'.$this->getValue('clicky-id').'">'.PHP_EOL;
		$html .= '<span class="tip">'.$L->get('Please enter your Clicky.com website ID number e.g.').' 1234567</span>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
        $html .= '</div>'.PHP_EOL;

        /*
        * Histats
        */
		$html .= '<div class="card mt-2">'.PHP_EOL;
		$html .= '<div class="card-body">'.PHP_EOL;
		$html .= '<div class="form-group">'.PHP_EOL;
		$html .= '<h3><span><img src="'.HTML_PATH_ASSETS.'img/histats-logo.jpg"></span>Histats</h3>'.PHP_EOL;
		$html .= '<p class="no-account mt-1">'.$L->get('Do not have an account yet? Register here').': <a href="https://histats.com" target="_blank"><span class="fa fa-external-link"></span></a></p>'.PHP_EOL;
		$html .= '<label>'.$L->get('Do you want to use this service?').'</label>'.PHP_EOL;
		$html .= '<select class="col-6 col-lg-3" name="histats-select" id="histats-select">'.PHP_EOL;
		$html .= '<option value="no" '.($this->getValue('histats-select')==='no'?'selected':'').'>'.$L->g('No').'</option>'.PHP_EOL;
		$html .= '<option value="yes" '.($this->getValue('histats-select')==='yes'?'selected':'').'>'.$L->g('Yes').'</option>'.PHP_EOL;
		$html .= '</select>'.PHP_EOL;
		$html .= '<div id="histats-div" class="d-none mt-1">'.PHP_EOL;
		$html .= '<label>'.$L->get('Please choose a tracking code type').'</label>'.PHP_EOL;
		$html .= '<select class="col-6 col-lg-3" name="histats-js" id="histats-js">'.PHP_EOL;
		$html .= '<option value="async" '.($this->getValue('histats-js')==='async'?'selected':'').'>'.$L->g('Async').'</option>'.PHP_EOL;
		$html .= '<option value="nojs" '.($this->getValue('histats-js')==='nojs'?'selected':'').'>'.$L->g('No Javascript').'</option>'.PHP_EOL;
		$html .= '</select>'.PHP_EOL;
		$html .= '<span id="histats-code-type-hint" class="js-tip text-primary"></span>'.PHP_EOL;
		$html .= '<label>'.$L->get('Histats website ID').'</label>'.PHP_EOL;
		$html .= '<input id="histats-id" class="col-xl-6 mt-1" name="histats-id" type="text" value="'.$this->getValue('histats-id').'">'.PHP_EOL;
		$html .= '<span class="tip">'.$L->get('Please enter your Histats.com website ID number e.g.').' 1234567</span>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		/*
		* Displaying info about pasting tracking code
		*/
		$html .= '<div class="m-3">';
		$html .= '<span class="tip">'.$L->get('info').'</span>';
		$html .= '</div>'.PHP_EOL;

		/*
		* Displaying the plugin version
		*/
		$html .= PHP_EOL . '<div class="text-center pt-3 mt-4 border-top text-muted">' . PHP_EOL;
		$html .= $this->name() . ' - v' . $this->version() . ' @ ' . date('Y') . ' by ' .  $this->author() . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		$html .= '<div class="text-center">' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-globe" href="' . $this->website() . '" target="_blank" title="Visit TompiDev\'s Website"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-github" href="' . $site->github() . '" target="_blank" title="Visit TompiDev on Github"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-twitter" href="' . $site->twitter() . '" target="_blank" title="Visit TompiDev on Twitter"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-envelope" href="mailto:' . $this->email() . '?subject=Question%20about%20'.$this->name().'" title="Send me an email"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-cubes" href="https://www.tompidev.com/tracking-master" target="_blank" title="Plugin\'s website on tompidev.com"></a>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;

        /*
        * Modal for Release notes
        */
        $html .= '
<div class="modal fade" id="versionModal" tabindex="-1" aria-labelledby="versionModal" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
   <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title">' . $L->g('Release Notes') . '</h4>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <div calss="container">
            <div class="row">
                <div class="col-5 font-weight-bold">' . $L->g('Package') . ':</div>
                <div id="pluginPackageName"></div>
            </div>
            <div class="row">
                <div class="col-5 font-weight-bold">' . $L->g('Current version') . ':</div>
                <div id="pluginCurrentVersion"></div>
            </div>
            <div class="row">
                <div class="col-5 font-weight-bold">' . $L->g('New version') . ':</div>
                <div id="pluginNewVersion"></div>
            </div>
            <div class="row">
                <div class="col-5 font-weight-bold pr-1">' . $L->g('Release date') . ':</div>
                <div id="pluginReleaseDate"></div>
            </div>
       </div>
       <div id="bdaReleaseNotes" class="mt-3 pt-3 border-top"></div>
       <div id="usufelLinks" class="mt-3 pt-3 border-top">
       <h5>' . $L->g("Useful Links") . '</h5>
           <a href="http://demo.tompidev.com/" target="_blank">Demo website<span class="fa fa-external-link ml-2"></span></a>(' . $L->g('Try Tompidev plugins and themes') . ')<br>
           <a href="https://tompidev.com/" target="_blank">Developer\'s website<span class="fa fa-external-link ml-2"></span></a>(' . $L->g('All plugins and themes from Tompidev') . ')
       </div>
     </div>
     <div class="modal-footer">
        <a id="downloadLink" class="btn btn-primary" href="" target="_blank"><i class="fa fa-download"></i>' . $L->g('Download release') . '</a>
        <a id="changelogLink" class="btn btn-primary" href="" target="_blank"><i class="fa fa-info-circle"></i>' . $L->g('Changelog') . '</a>
        <a id="github" class="btn btn-primary" href="" target="_blank"><i class="fa fa-github"></i>Github</a>
       <button type="button" class="btn btn-secondary" data-dismiss="modal">' . $L->g('Close') . '</button>
     </div>
   </div>
 </div>
</div>
        ' . PHP_EOL;

		return $html;
    }

    public function siteHead(){

        /*
        * Google Analytics code
        */
        if($this->getValue('ga-select') === 'yes'){
            $html = '
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id='.$this->getValue('ga-id').'"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag("js", new Date());

        gtag("config", "'.$this->getValue('ga-id').'");
    </script>
            '.PHP_EOL;
        }

        /*
        * Clicky code
        */
        if($this->getValue('clicky-select') === 'yes'){
            if($this->getValue('clicky-js')==='async'){
            $html .= '
    <!-- Clicky tracking code -->
    <script>var clicky_site_ids = clicky_site_ids || [];clicky_site_ids.push('.$this->getValue('clicky-id').');</script>
    <script async src="//static.getclicky.com/js"></script>'
    .PHP_EOL;
        }
        }

 		return $html;
    }

    public function siteBodyEnd()
    {

        /*
        * Clicky code
        */
        if($this->getValue('clicky-select') === 'yes'){
            if($this->getValue('clicky-js')==='nojs'){
            $html = '
    <!-- Clicky tracking code -->
    <script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push('.$this->getValue('clicky-id').');</script>
    <script async src="//static.getclicky.com/js"></script>
    <noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/'.$this->getValue('clicky-id').'ns.gif" /></p></noscript>'
    .PHP_EOL;
        }
        }

        /*
        * Histats standard code
        */
        if($this->getValue('histats-select') === 'yes'){
        if($this->getValue('histats-js')==='async'){
            $html .= '
    <!-- Histats standard tracking code -->
    <script>
    var _Hasync= _Hasync|| [];
    _Hasync.push(["Histats.start", "1,'.$this->getValue('histats-id').',4,0,0,0,00010000"]);
    _Hasync.push(["Histats.fasi", "1"]);
    _Hasync.push(["Histats.track_hits", ""]);
    (function() {
    var hs = document.createElement("script"); hs.type = "text/javascript"; hs.async = true;
    hs.src = ("//s10.histats.com/js15_as.js");
    (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(hs);
    })();
    </script>
    <noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?'.$this->getValue('histats-id').'&101" alt="" border="0"></a></noscript>'
    .PHP_EOL;
        }else{
        /*
        * Histats No-Javascript code
        */
            $html .= '
    <!-- Histats.com  START (hidden counter) -->
    <a href="/" alt="" target="_blank" >
    <img  src="//sstatic1.histats.com/0.gif?'.$this->getValue('histats-id').'&101" alt="" border="0">
    <!-- Histats.com  END  -->';
        }
        }

 		return $html;

    }

    public function adminHead()
    {
        $html = '<link rel="stylesheet" type="text/css" href="'.HTML_PATH_ASSETS.'css/style.css">'.PHP_EOL;

        return $html;
    }

    public function adminBodyEnd()
    {
        global $L;

        $scripts = PHP_EOL.'<script>'.PHP_EOL;

        /*
        * Google analytics
        */
        if($this->getValue('ga-select')==='yes'){
        $scripts .= '$("#ga-div").removeClass("d-none");'.PHP_EOL;
        }
        $scripts .= '$("#ga-select").change(function(){'.PHP_EOL;
        $scripts .= 'if ($(this).val() == "yes"){'.PHP_EOL;
        $scripts .= '$("#ga-div").removeClass("d-none");'.PHP_EOL;
        $scripts .= '$("#ga-id").attr("required", true);'.PHP_EOL;
        $scripts .= '}else{'.PHP_EOL;
        $scripts .= '$("#ga-div").addClass("d-none");'.PHP_EOL;
        $scripts .= '$("#ga-id").attr("required", false);'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;
        $scripts .= '$("#ga-id").change(function(){'.PHP_EOL;
        $scripts .= 'if($("#ga-id").val() == ""){;'.PHP_EOL;
        $scripts .= '$("#ga-id").attr("required", true);'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;

        /*
        * Clicky
        */
        if($this->getValue('clicky-select')==='yes'){
        $scripts .= '$("#clicky-div").removeClass("d-none");'.PHP_EOL;
        }
        $scripts .= '$("#clicky-select").change(function(){'.PHP_EOL;
        $scripts .= 'if ($(this).val() == "yes"){'.PHP_EOL;
        $scripts .= '$("#clicky-div").removeClass("d-none");'.PHP_EOL;
        $scripts .= '$("#clicky-id").attr("required", true);'.PHP_EOL;
        $scripts .= '}else{'.PHP_EOL;
        $scripts .= '$("#clicky-div").addClass("d-none");'.PHP_EOL;
        $scripts .= '$("#clicky-id").attr("required", false);'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;
        $scripts .= '$("#clicky-id").change(function(){'.PHP_EOL;
        $scripts .= 'if($("#clicky-id").val() == ""){;'.PHP_EOL;
        $scripts .= '$("#clicky-id").attr("required", true);'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;

        if($this->getValue('clicky-js')==='async'){
        $scripts .= '$("#clicky-code-type-hint").html("'.$L->g('async-code').'");'.PHP_EOL;
        }else{
        $scripts .= '$("#clicky-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        }
        $scripts .= '$("#clicky-js").change(function(){'.PHP_EOL;
        $scripts .= 'if($("#clicky-js").val() == "async"){;'.PHP_EOL;
        $scripts .= '$("#clicky-code-type-hint").html("'.$L->g('async-code').'");'.PHP_EOL;
        $scripts .= '}else{'.PHP_EOL;
        $scripts .= '$("#clicky-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;

        /*
        * Histats
        */
        if($this->getValue('histats-select')==='yes'){
        $scripts .= '$("#histats-div").removeClass("d-none");'.PHP_EOL;
        }
        $scripts .= '$("#histats-select").change(function(){'.PHP_EOL;
        $scripts .= 'if ($(this).val() == "yes"){'.PHP_EOL;
        $scripts .= '$("#histats-div").removeClass("d-none");'.PHP_EOL;
        $scripts .= '$("#histats-id").attr("required", true);'.PHP_EOL;
        $scripts .= '}else{'.PHP_EOL;
        $scripts .= '$("#histats-div").addClass("d-none");'.PHP_EOL;
        $scripts .= '$("#histats-id").attr("required", false);'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;
        $scripts .= '$("#histats-id").change(function(){'.PHP_EOL;
        $scripts .= 'if($("#histats-id").val() == ""){;'.PHP_EOL;
        $scripts .= '$("#histats-id").attr("required", true);'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;

        if($this->getValue('histats-js')==='async'){
        $scripts .= '$("#histats-code-type-hint").html("'.$L->g('async-code').'");'.PHP_EOL;
        }else{
        $scripts .= '$("#histats-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        }
        $scripts .= '$("#histats-js").change(function(){'.PHP_EOL;
        $scripts .= 'if($("#histats-js").val() == "async"){;'.PHP_EOL;
        $scripts .= '$("#histats-code-type-hint").scripts("'.$L->g('async-code').'");'.PHP_EOL;
        $scripts .= '}else{'.PHP_EOL;
        $scripts .= '$("#histats-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        $scripts .= '}'.PHP_EOL;
        $scripts .= '});'.PHP_EOL;

        $scripts .= '</script>'.PHP_EOL;

        /*
        * Version check script
        */
        $scripts .= '<script>
        function checkTMVersion() {

            console.log("[INFO] [Tracking Master PLUGIN VERSION] Getting list of versions of Tracking Master plugin.");

            $.ajax({
                url: "http://tompidev.com/downloads/release-info/json/bl-plugin-tm.json",
                method: "GET",
                dataType: "json",
                success: function(json) {
                    console.log("[INFO] [Tracking Master PLUGIN VERSION] New Tracking Master plugin version is available: v" + json.trackingMaster.newVersion);

                    // show alert and disable all the function in the plugin if theme version upgrade is necessary

                    if (json.trackingMaster.newVersion > json.trackingMaster.currentVersion) {
                        $("#pluginPackageName").html(json.trackingMaster.package);
                        $("#pluginCurrentVersion").html(json.trackingMaster.currentVersion);
                        $("#pluginNewVersion").html( json.trackingMaster.newVersion );
                        $("#pluginReleaseDate").html( json.trackingMaster.releaseDate );
                        var changelogObj, i, j, x = "";
                        changelogObj = [ json.trackingMaster.changelog ];
                        console.log(changelogObj);
                        for (i in json.trackingMaster.changelog) {
                            x += "<h5>" + json.trackingMaster.changelog[i].action + "</h5>";
                            for (j in json.trackingMaster.changelog[i].items) {
                            x += "<span class=\"fa fa-arrow-right ml-2\"></span>" + json.trackingMaster.changelog[i].items[j] + "<br>";
                            }
                        }
                        $("#bdaReleaseNotes").html( x );
                        $("#tmVersionAlert").removeClass("d-none");
                        $("#downloadLink").attr("href",  json.trackingMaster.downloadLink );
                        $("#changelogLink").attr("href", json.trackingMaster.changelogLink );
                        $("#github").attr("href", json.trackingMaster.github );
                    }else{
                    $("#formContent").removeClass("d-none");
                    }
                },
                error: function(json) {
                    console.log("[WARN] [Tracking Master PLUGIN VERSION] There is some issue to get the version status of Tracking Master plugin.");
                }
            });
        }
        checkTMVersion();
        </script>' . PHP_EOL;

        return $scripts;
    }


}
