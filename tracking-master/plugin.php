<?php
/**
*  @package        :  Tracking Master
*  @author         :  Tompidev
*  @website        :  https://github.com/tompidev
*  @email          :  support@tompidev.com
*  @license        :  MIT
*
*  @last-modified  :  2020-09-04 16:29:08 CET
*  @release        :  1.0.1
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

        /*
        * Show the description of the plugin in the settings
        */
		$html  = PHP_EOL.'<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
        $html .= '</div>'.PHP_EOL;


        /*
        * Google analytics
        */
		$html .= '<div class="card">'.PHP_EOL;
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

		$html .= '<div class="m-3">';
		$html .= '<span class="tip">'.$L->get('info').'</span>';
        $html .= '</div>';

        /*
        * Displaying version of the plugin
        */
        $html .= PHP_EOL.'<div class="text-center pt-3 mt-5 border-top text-muted">'.PHP_EOL;
        $html .= $this->name();
        $html .= ' - v' .$this->version();
        $html .= ' @ '.date('Y').' <a href="'.$this->website().'" target="_blank">' .$this->author() . '</a> ';
        $html .= '</div>'.PHP_EOL;

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
    </script>'.PHP_EOL;
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

        $html = PHP_EOL.'<script>'.PHP_EOL;

        /*
        * Google analytics
        */
        if($this->getValue('ga-select')==='yes'){
        $html .= '$("#ga-div").removeClass("d-none");'.PHP_EOL;
        }
        $html .= '$("#ga-select").change(function(){'.PHP_EOL;
        $html .= 'if ($(this).val() == "yes"){'.PHP_EOL;
        $html .= '$("#ga-div").removeClass("d-none");'.PHP_EOL;
        $html .= '$("#ga-id").attr("required", true);'.PHP_EOL;
        $html .= '}else{'.PHP_EOL;
        $html .= '$("#ga-div").addClass("d-none");'.PHP_EOL;
        $html .= '$("#ga-id").attr("required", false);'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;
        $html .= '$("#ga-id").change(function(){'.PHP_EOL;
        $html .= 'if($("#ga-id").val() == ""){;'.PHP_EOL;
        $html .= '$("#ga-id").attr("required", true);'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;

        /*
        * Clicky
        */
        if($this->getValue('clicky-select')==='yes'){
        $html .= '$("#clicky-div").removeClass("d-none");'.PHP_EOL;
        }
        $html .= '$("#clicky-select").change(function(){'.PHP_EOL;
        $html .= 'if ($(this).val() == "yes"){'.PHP_EOL;
        $html .= '$("#clicky-div").removeClass("d-none");'.PHP_EOL;
        $html .= '$("#clicky-id").attr("required", true);'.PHP_EOL;
        $html .= '}else{'.PHP_EOL;
        $html .= '$("#clicky-div").addClass("d-none");'.PHP_EOL;
        $html .= '$("#clicky-id").attr("required", false);'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;
        $html .= '$("#clicky-id").change(function(){'.PHP_EOL;
        $html .= 'if($("#clicky-id").val() == ""){;'.PHP_EOL;
        $html .= '$("#clicky-id").attr("required", true);'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;

        if($this->getValue('clicky-js')==='async'){
        $html .= '$("#clicky-code-type-hint").html("'.$L->g('async-code').'");'.PHP_EOL;
        }else{
        $html .= '$("#clicky-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        }
        $html .= '$("#clicky-js").change(function(){'.PHP_EOL;
        $html .= 'if($("#clicky-js").val() == "async"){;'.PHP_EOL;
        $html .= '$("#clicky-code-type-hint").html("'.$L->g('async-code').'");'.PHP_EOL;
        $html .= '}else{'.PHP_EOL;
        $html .= '$("#clicky-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;

        /*
        * Histats
        */
        if($this->getValue('histats-select')==='yes'){
        $html .= '$("#histats-div").removeClass("d-none");'.PHP_EOL;
        }
        $html .= '$("#histats-select").change(function(){'.PHP_EOL;
        $html .= 'if ($(this).val() == "yes"){'.PHP_EOL;
        $html .= '$("#histats-div").removeClass("d-none");'.PHP_EOL;
        $html .= '$("#histats-id").attr("required", true);'.PHP_EOL;
        $html .= '}else{'.PHP_EOL;
        $html .= '$("#histats-div").addClass("d-none");'.PHP_EOL;
        $html .= '$("#histats-id").attr("required", false);'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;
        $html .= '$("#histats-id").change(function(){'.PHP_EOL;
        $html .= 'if($("#histats-id").val() == ""){;'.PHP_EOL;
        $html .= '$("#histats-id").attr("required", true);'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;

        if($this->getValue('histats-js')==='async'){
        $html .= '$("#histats-code-type-hint").html("'.$L->g('async-code').'");'.PHP_EOL;
        }else{
        $html .= '$("#histats-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        }
        $html .= '$("#histats-js").change(function(){'.PHP_EOL;
        $html .= 'if($("#histats-js").val() == "async"){;'.PHP_EOL;
        $html .= '$("#histats-code-type-hint").html("'.$L->g('async-code').'");'.PHP_EOL;
        $html .= '}else{'.PHP_EOL;
        $html .= '$("#histats-code-type-hint").html("'.$L->g('nojs-code').'");'.PHP_EOL;
        $html .= '}'.PHP_EOL;
        $html .= '});'.PHP_EOL;

        $html .= '</script>'.PHP_EOL;

        return $html;
    }


}
