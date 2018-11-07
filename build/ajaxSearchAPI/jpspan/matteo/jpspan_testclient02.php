<?php
// $Id: testclient.php,v 1.4 2005/06/03 15:10:36 harryf Exp $
require_once '../JPSpan.php';
require_once JPSPAN . 'Include.php';
JPSpan_Include_Register('encode/php.js');
JPSpan_Include_Register('encode/xml.js');
JPSpan_Include_Register('request/get.js');
JPSpan_Include_Register('request/post.js');
JPSpan_Include_Register('request/rawpost.js');
JPSpan_Include_Register('util/data.js');

header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header( "Cache-Control: no-cache, must-revalidate" ); 
header( "Pragma: no-cache" );

function path() {
    $basePath = explode('/',$_SERVER['SCRIPT_NAME']);
    $script = array_pop($basePath);
    $basePath = implode('/',$basePath);
    /*if ( isset($_SERVER['HTTPS']) ) {
        $scheme = 'https';
    } else {
        $scheme = 'http';
    }*/
	$scheme = 'http';
    echo $scheme.'://'.$_SERVER['SERVER_NAME'].$basePath;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> HttpClient Test Page </title>
<style type="text/css">
<!--
body {
	margin:0px;
	padding:0px;
	font-family:verdana, arial, helvetica, sans-serif;
	color:#333;
	background-color:white;
	}
h1 {
	margin:0px 0px 0px 0px;
	padding:0px;
	font-size:24px;
	line-height:24px;
	font-weight:900;
	color:#ccc;
	}
h2 {
	margin:0px 0px 0px 0px;
	padding:0px;
	font-size:16px;
	line-height:16px;
	font-weight:500;
	}
p {
	font:11px/20px verdana, arial, helvetica, sans-serif;
	margin:0px 0px 16px 0px;
	padding:0px;
	}
#Content>p {margin:0px;}
#Content>p+p {text-indent:30px;}

input, select {
	font:11px/20px verdana, arial, helvetica, sans-serif;
	margin:0px 0px 0px 0px;
	padding:0px;
	}

a {
	color:#09c;
	font-size:11px;
	text-decoration:none;
	font-weight:600;
	font-family:verdana, arial, helvetica, sans-serif;
	}
a:link {color:#09c;}
a:visited {color:#07a;}
a:hover {background-color:#eee;}
#Header {
	margin:50px 0px 10px 0px;
	padding:17px 0px 0px 20px;
	/* For IE5/Win's benefit height = [correct height] + [top padding] + [top and bottom border widths] */
	height:33px; /* 14px + 17px + 2px = 33px */
	line-height:11px;
	voice-family: "\"}\"";
	voice-family:inherit;
	height:14px; /* the correct height */
	}
body>#Header {height:14px;}
#Content {
	margin:0px 50px 50px 300px;
	padding:10px;
	}

#Menu {
	position:absolute;
	top:100px;
	left:20px;
	width:172px;
	padding:10px;
	line-height:17px;
	font-size:11px;
	voice-family: "\"}\"";
	voice-family:inherit;
	width:250px;
	}
body>#Menu {width:250px;}

#goo-results .sentence {
		background:#CCFF66;
		border: 1 px solid #CCCCCC;
		padding: 2px;
		margin-bottom: 4px;
	}
-->
</style>

<!--Google Search KEY-->
<script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&amp;key=ABQIAAAAJEZgazCxg-mkIInnslzBPBTZbOCVrw7JuujFhfgSl2g24yPDJRRvm--hxUymxwwftQdMSzSlyP-WVA" type="text/javascript"></script>

<script type="text/javascript">
//___________________________________________________________
//===================================================
// GOOGLE

    //<![CDATA[

	var searchControl; 

    function OnLoad() {
		searchControl =  new RawSearchControl();
    }

    /**
     * The RawSearchControl demonstrates how to use Searcher Objects
     * outside of the standard GSearchControl. This includes calling
     * searcher .execute() methods, reacting to search completions,
     * and if you had previously disabled html generation, how to generate
     * an html representation of the result.
     */
    function RawSearchControl() {
      // latch on to key portions of the document
      this.results = document.getElementById("goo-results");

      // create map of searchers as well as note the active searcher
      this.activeSearcher = "web";
      this.searchers = new Array();

      // wire up a raw GwebSearch searcher
      var searcher = new GwebSearch();
      searcher.setNoHtmlGeneration();
	  searcher.setResultSetSize(GSearch.LARGE_RESULTSET) ;// sets the size of results' object (large = 8 results)
      searcher.setSearchCompleteCallback(this, RawSearchControl.prototype.searchComplete, [searcher]); // sets the function to be called (+arguments) when a search is completed
      this.searchers["web"] = searcher;
    }

    /**
     * figure out which searcher is active by looking at the radio
     * button array
     */
    RawSearchControl.prototype.computeActiveSearcher = function() {
      for (var i=0; i<this.searcherform["searcherType"].length; i++) {
        if (this.searcherform["searcherType"][i].checked) {
          this.activeSearcher = this.searcherform["searcherType"][i].value;
          return;
        }
      }
    }

    /**
     * onSubmit - called when the search form is "submitted" meaning that someone pressed the search button or hit enter. 
	 * value of the input box is passed as an argument
     */
	RawSearchControl.prototype.onSubmit = function(value) {
		if (value) this.searchers[this.activeSearcher].execute(value);
      	return false;
    }

    /**
     * onClear - called when someone clicks on the clear button (the little x)
     */
    RawSearchControl.prototype.onClear = function(form) {
      this.clearResults();
    }

    /**
     * searchComplete - called when a search completed. Note the searcher
     * that is completing is passes as an arg because thats what we arranged
     * when we called setSearchCompleteCallback
     */
    RawSearchControl.prototype.searchComplete = function(searcher) {
      // always clear old from the page
      this.clearResults();

      // if the searcher has results then process them
      if (searcher.results && searcher.results.length > 0) {
		
		var resultsArray = new Array();
		// print the result descriptions
		/*var div = createDiv("Result Descriptions", "header");
		this.results.appendChild(div); */
        for (var i=0; i<searcher.results.length; i++) {
			var resultArray = new Array();
          	var result = searcher.results[i];
          	var content = result.content;
		  	var url = result.url;
		  	var linkSentence = "<a href='"+url+"' target='_blank' >"+content+"</a>";
			var div = createDiv(linkSentence, "sentence");
          	this.results.appendChild(div);
			
			resultArray["content"] = content;
			resultArray["url"] = url;
			resultArray["pagerank"] = i;
			
			resultsArray[i]=resultArray;
			
        }
		
		// pass results' data object to php application
		//gooAsyncPost(searcher.results);
		gooAsyncPost(resultsArray);
      }
    }

    /**
     * clearResults - clear out any old search results
     */
    RawSearchControl.prototype.clearResults = function() {
      removeChildren(this.results);
    }

    /**
     * Static DOM Helper Functions
     */
    function removeChildren(parent) {
      while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
      }
    }
    function createDiv(opt_text, opt_className) {
      var el = document.createElement("div");
      if (opt_text) {
        el.innerHTML = opt_text;
      }
      if (opt_className) { el.className = opt_className; }
      return el;
    }
	


    // register to be called at OnLoad when the page loads
    GSearch.setOnLoadCallback(OnLoad);
    //]]>


//___________________________________________________________
//===================================================
// JPSPAN 

<?php JPSpan_Includes_Display(); ?>

var serverUrl = "<?php path();?>/printrresponse.php";
var requestUrl = "<?php path();?>/printrresponse.php?rencoding=xml";
var encoder = new JPSpan_Encode_Xml();

//-------------------------------------------------------------------------
// Utility functions for this example
function echo(string) {
    document.getElementById("ser-results").innerHTML += string;
}

function clear() {
    document.getElementById("ser-results").innerHTML = "";
}

function getTimeOut() {
    timeout = parseInt(document.getElementById("timeout").value);
    if ( !isNaN(timeout) ) {
        return timeout;
    }
    return 20000;
}

function setREncoding(value) {
    requestUrl = serverUrl + '?rencoding='+value;
    if ( value == 'php' ) {
        encoder = new JPSpan_Encode_PHP();
    } else {
        encoder = new JPSpan_Encode_Xml();
    }
}

function var_dump(data) {
    var Data = new JPSpan_Util_Data();
    return Data.dump(data);
}
//-------------------------------------------------------------------------
// ASYNC stuff
//-------------------------------------------------------------------------
function asyncPost() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Post(encoder);
    r.timeout = getTimeOut();
    
    r.serverurl = requestUrl;
    r.addArg('method','POST');
    r.addArg('x','foo');
    r.addArg('y','bar');
    r.addArg('z',new Array(1,2,3));
    c.asyncCall(r, BasicHandler);
}

function gooAsyncPost(obj) {
	var client = new JPSpan_HttpClient();
	var request = new JPSpan_Request_Post(encoder);
	
	request.timeout = 5000;
	request.serverurl = requestUrl;
	request.addArg('method', 'POST');
	request.addArg('results', obj);
	
	client.asyncCall(request, BasicHandler);
}

function asyncGet() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.timeout = getTimeOut();
    r.serverurl = requestUrl;
    r.addArg('method','GET');
    r.addArg('x','foo');
    r.addArg('y','bar');
    r.addArg('z',new Array(1,2,3));
    c.asyncCall(r, BasicHandler);
}

function asyncRawPost() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_RawPost(encoder);
    r.timeout = getTimeOut();
    r.serverurl = requestUrl;
    r.addArg('method','RawPOST');
    r.addArg('x','foo');
    r.addArg('y','bar');
    r.addArg('z',new Array(1,2,3));
    c.asyncCall(r, BasicHandler);
}

var BasicHandler = {
    onLoad: function(result) {
        echo("<pre>"+var_dump(result)+"</pre>");
    },
    onError: function(e) {
        alert(e.name+': '+e.message+' (JPSpan Code: '+e.code+')');
    }
}

var EvalHandler = {
    onLoad: function(result) {
        try {
            result = eval(result);
            result = result();
            echo("<pre>"+var_dump(result)+"</pre>");
        } catch(e) {
            this.onError(e);
        }
    },
    onError: function(e) {
        alert(e.name+': '+e.message+"\n [File: "+e.file+', line: '+e.line+"]\n (JPSpan Code: "+e.code+')');
    }
}

//-------------------------------------------------------------------------
// SYNC Stuff
//-------------------------------------------------------------------------
function syncPost() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Post(encoder);
    r.serverurl = requestUrl;
    r.addArg('method','POST');
    r.addArg('x','foo');
    r.addArg('y','bar');
    r.addArg('z',new Array(1,2,3));
    try {
        echo('<pre>'+c.call(r)+'</pre>');
    } catch ( e ) {
        echo (e.message);
    }
}

function syncGet() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = requestUrl;
    r.addArg('method','GET');
    r.addArg('x','foo');
    r.addArg('y','bar');
    r.addArg('z',new Array(1,2,3));
    try {
        echo('<pre>'+c.call(r)+'</pre>');
    } catch ( e ) {
        echo (e.message);
    }
}

function syncRawPost() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_RawPost(encoder);
    r.serverurl = requestUrl;
    r.addArg('method','RawPOST');
    r.addArg('x','foo');
    r.addArg('y','bar');
    r.addArg('z',new Array(1,2,3));
    try {
        echo('<pre>'+c.call(r)+'</pre>');
    } catch ( e ) {
        echo (e.message);
    }
}
//-------------------------------------------------------------------------

function notFound() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = 'http://localhost/pagenotfound_123567234.html';
    c.asyncCall(r,BasicHandler);
}

function permissionDenied() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = 'http://127.0.0.253/';
    try {
        c.asyncCall(r,BasicHandler);
    } catch(e) {
        BasicHandler.onError(e);
    }
}

function callInProgress() {
    var c = new JPSpan_HttpClient();

    for (var i=0; i<3; i++ ) {
    
        var r = new JPSpan_Request_Get(encoder);
        
        // Interesting... (try commenting then asyncGet then multiAsyncGet)
        r.reset();
        
        r.serverurl = requestUrl;
        r.addArg('requestNum','request number: '+i);
        try {
            c.asyncCall(r, BasicHandler);
        } catch (e) {
            alert('Request #'+i+' ['+e.code+'] '+e);
        }
    }
}

function requesttimeout() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.timeout = 1;
    r.serverurl= requestUrl+'&timeout=3';
    r.addArg('method','GET');
    r.addArg('x','foo');
    r.addArg('y','bar');
    r.addArg('z',new Array(1,2,3));
    c.asyncCall(r, BasicHandler);
}

function invalidParamName() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    try {
        r.addArg('%50','foo');
        c.asyncCall(r, BasicHandler);
    } catch (e) {
        BasicHandler.onError(e);
    }
}

function recursion() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = requestUrl;
    var a = new Object();
    var b = new Object();
    a.b = b;
    b.a = a;
    try {
        r.addArg('a',a);
        c.asyncCall(r, BasicHandler);
    } catch (e) {
        BasicHandler.onError(e);
    }
}
//-------------------------------------------------------------------------
function fopen() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = requestUrl+'&error=native';
    c.asyncCall(r, EvalHandler);
}

function notice() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = requestUrl+'&error=notice';
    c.asyncCall(r, EvalHandler);
}

function warning() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = requestUrl+'&error=warning';
    c.asyncCall(r, EvalHandler);
}

function error() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = requestUrl+'&error=error';
    c.asyncCall(r, EvalHandler);
}

function exception() {
    var c = new JPSpan_HttpClient();
    var r = new JPSpan_Request_Get(encoder);
    r.serverurl = requestUrl+'&error=exception';
    c.asyncCall(r, EvalHandler);
}
-->
</script>
</head>
<body>
<div id="Header">
<h1><acronym title="how to pass data objects from JS(GoogleSearch API) to PHP">( JS /\ PHP )</acronym></h1>
</div>
<div id="Content">
	<h2>Response from Google</h2>
    <div id="goo-results"></div>
	<br>
    <h2>Response from Server (what php received)</h2>
    <div id="ser-results"></div>
</div>
<div id="Menu">

	<table>
		<tr><td><input type="text" id="searchBox" value="" /></td></tr>	
		<tr><td><input type="button" onClick="searchControl.onSubmit(document.getElementById('searchBox').value);" value="Google Search" /></td></tr>	
    </table>
<!--	<br>
	<acronym title="Clean up the results"><a href="javascript:clear()">clear()</a></acronym><br>
	<form>
		<acronym title="Encoding for request">Encoding</acronym>: 
		<select onChange="setREncoding(this.options[selectedIndex].value);">
			<option>xml</option>
			<option>php</option>
		</select>
	</form>
	<br>
	<h2>Async</h2>
	<acronym title="Asynchronous HTTP POST request"><a href="javascript:asyncPost()">asyncPost()</a></acronym><br>
	<acronym title="Asynchronous HTTP GET request"><a href="javascript:asyncGet()">asyncGet()</a></acronym><br>
	<acronym title="Asynchronous raw HTTP POST request"><a href="javascript:asyncRawPost()">asyncRawPost()</a></acronym><br>
	<form>
		<acronym title="Try adding a sleep() to printrresponse.php to simulate"><label>Timeout [ms]</label></acronym>: 
		<input type="text" id="timeout" value="20000" size="5"><br>
	</form>
	 

<h2>Sync</h2>
<acronym title="Synchronous HTTP POST request"><a href="javascript:syncPost()">syncPost()</a></acronym><br>
<acronym title="Synchronous HTTP GET request"><a href="javascript:syncGet()">syncGet()</a></acronym><br>
<acronym title="Asynchronous raw HTTP POST request"><a href="javascript:syncRawPost()">syncRawPost()</a></acronym><br>
<br>
<h2>Client_Error</h2>
<acronym title="HTTP page not found"><a href="javascript:notFound()">notFound()</a></acronym><br>
<acronym title="Request to 127.0.0.253"><a href="javascript:permissionDenied()">permissionDenied()</a></acronym><br>
<acronym title="Attempt multiple calls to when request already in progress"><a href="javascript:callInProgress()">callInProgress()</a></acronym><br>
<acronym title="Request timed out before response received"><a href="javascript:requesttimeout()">requesttimeout()</a></acronym><br>
<acronym title="Invalid request parameter name"><a href="javascript:invalidParamName()">invalidParamName()</a></acronym><br>
<acronym title="Recursive references in request data"><a href="javascript:recursion()">recursion()</a></acronym><br>
<br>

<h2>Server_Error</h2>
<acronym title="A native PHP error resulting from failed fopen"><a href="javascript:fopen()">fopen()</a></acronym><br>
<acronym title="PHP E_USER_NOTICE from trigger_error()"><a href="javascript:notice()">notice()</a></acronym><br>
<acronym title="PHP E_USER_WARNING from trigger_error()"><a href="javascript:warning()">warning()</a></acronym><br>
<acronym title="PHP E_USER_ERROR from trigger_error()"><a href="javascript:error()">error()</a></acronym><br>
<acronym title="PHP5 Exception"><a href="javascript:exception()">exception()</a></acronym><br>-->

</div>

</body>
</html>
