/** FUNZIONI */

function getElementById(id) {
	var element;
 	if(document.getElementById)	element = document.getElementById(id);
 	else element = document.all[id];
 	return element;
};
	
function assignXMLHttpRequest() {
	var XHR = null, 
	browser = navigator.userAgent.toUpperCase();
	// browser standard with native support: type of browser can be ignored
 	if(typeof(XMLHttpRequest) === "function" || typeof(XMLHttpRequest) === "object") {
		XHR = new XMLHttpRequest();
	}
	// INTERNET EXPLORER
 	// version 4 must be filtered out
 	else if(window.ActiveXObject && browser.indexOf("MSIE 4") < 0 ) {
		// version 6 has a different name for ActiveX object
  		if(browserUtente.indexOf("MSIE 5") < 0) XHR = new ActiveXObject("Msxml2.XMLHTTP");
  		// versions 5 and 5.5 instead have same name
		else XHR = new ActiveXObject("Microsoft.XMLHTTP");
	}
 	return XHR;
}

/////////////////////////////////////////////////////////////////////

function manageKeyPress(evt) {
  	var evt = (evt) ? evt : ((event) ? event : null);
  	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	var keyCode = evt.keyCode;
	// enter key
	if (keyCode == 13) {
		if (node.id=='inputStart' || node.id=='inputConversation') {
			loadResponse();
		} 
		return false;
	} 
}

function stopEnterKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

////////////////////////////////////////////////////////////////////

function validateRadioButton(button) {
	var count = -1;
	for (var i=button.length-1; i > -1; i--) {
		if (button[i].checked) {
			count = i; 
			i = -1;
		}
    }
    if (count > -1) return button[count].value;
    else return null;
}

/*function filteredSearchOff(){
	getElementById('filtered-toggle').innerHTML="<font size=-2>FilteredSpeak is Off - <a href=# onClick='filteredSearchOn()'>Turn it On</a></font>";	
}

function filteredSearchOn(){
	getElementById('filtered-toggle').innerHTML="<font size=-2>FilteredSpeak is On - <a href=# onClick='filteredSearchOff()'>Turn it Off</a></font>";	
}*/

////////////////////////////////////////////////////////////////////


function styleEntry(type,text,time,location,url) {
	var entry, name;
	if (type=='google') name='Google';
	else name='Me';
	if (!time) time= 'sometime';
	if (!location) location='somewhere';
	if (!url) url='#';
	entry = "<div class='"+type+"'><div class='name'>"+name+"</div><div class='text'>"+text+"</div><div class='info'>"+time+" "+location+" - <a href='"+url+"'>similar topic</a></div></div>";
	return entry;
}

function loadResponse(){
	var start = getElementById('start'),
	filterButton = document.forms['startForm']['filter'],
	conversation = getElementById('conversation'),
	inputBox = getElementById('inputConversation'),
	history = getElementById('leftbar'),
	status = getElementById('status'),
	botname = getElementById('botname').innerHTML,
	ajax = assignXMLHttpRequest(),
	input, filter, fileName;
	
	filter = validateRadioButton(filterButton);
	/*if (filter == null) alert('No filtering mode selected');
	else alert('Filtering mode: ' + filter);*/
	
	if (start.style.display!=='none') input= getElementById('inputStart').value;
	else input = getElementById('inputConversation').value;
	
	fileName = 'php/response.php?input='+input;
	fileName += '&botname='+botname;
	fileName += '&filter='+filter;

	// hide #start, show #conversation 
	start.style.display='none';
	conversation.style.display='block';
	
	inputBox.value="";
	inputBox.focus();
	
	// show user input in the chatHistory box
	var styledInput = styleEntry('user',input);
	history.innerHTML += styledInput;
	history.scrollTop = history.scrollHeight - history.clientHeight;

  	if(ajax) {
		//status.innerHTML = "ajax initialized";
		
		// set GET asinchronous request 
		ajax.open("get", fileName, true);
		
		// remove header "connection" as "keep alive"
    	ajax.setRequestHeader("connection", "close");
		
    	ajax.onreadystatechange = function() {
			if(ajax.readyState === readyState.INACTIVE) status.innerHTML = googleStatus.INACTIVE;
			if(ajax.readyState === readyState.INITIALIZED) status.innerHTML = googleStatus.INITIALIZED;
			if(ajax.readyState === readyState.SENT) status.innerHTML = googleStatus.SENT;
      		if(ajax.readyState === readyState.RECEIVED) status.innerHTML = googleStatus.RECEIVED;
      		if(ajax.readyState === readyState.LOADED) {
				status.innerHTML = googleStatus.LOADED;
        		if(statusText[ajax.status] === "OK") {
					var styledResponse = styleEntry('google',ajax.responseText);
					history.innerHTML += styledResponse;
				} else {
          			status.innerHTML = "Google cannot hear you! ";
          			status.innerHTML += "It's your fault, precisely: " + statusText[ajax.status];
					history.innerHTML += ajax.responseText;
        		}
				history.scrollTop = history.scrollHeight - history.clientHeight;
				updateChatCloud('users');
				updateChatCloud('google');
			} 
		}
  		ajax.send(null);
	}
	return false;
}

function updateChatCloud(id){
	var cloud = getElementById(id+'Cloud'),
	status = getElementById(id+'Status'),
	ajax = assignXMLHttpRequest(),
	fileName = 'php/chatCloud/cloud.php?id='+id;
	
	// hide cloud, show status
	cloud.style.display='none';
	status.style.display='block';
	
	if(ajax) {
		// set GET asinchronous request 
		ajax.open("get", fileName, true);
		// remove header "connection" as "keep alive"
    	ajax.setRequestHeader("connection", "close");
		
    	ajax.onreadystatechange = function() {
			if(ajax.readyState === readyState.INACTIVE) status.innerHTML = chatCloudStatus.INACTIVE;
			if(ajax.readyState === readyState.INITIALIZED) status.innerHTML = chatCloudStatus.INITIALIZED;
			if(ajax.readyState === readyState.SENT) status.innerHTML = chatCloudStatus.SENT;
      		if(ajax.readyState === readyState.RECEIVED) status.innerHTML = chatCloudStatus.RECEIVED;
      		if(ajax.readyState === readyState.LOADED) {
				status.innerHTML = chatCloudStatus.LOADED;
        		if(statusText[ajax.status] === "OK") {
					status.style.display='none';
					cloud.innerHTML = ajax.responseText;
					resizeClouds();
					cloud.style.display='block';
				} else {
          			status.innerHTML = "Google is enable to generate a chatCloud for you! ";
          			status.innerHTML += "It's your fault, precisely: " + statusText[ajax.status];
        		}
			} 
		}
  		ajax.send(null);
	}
}

function resizeClouds(){
	var padding=4, margin=4;
	resizeCloud('users', padding, margin);
	resizeCloud('google', padding, margin);
}

function resizeCloud(id, padding, margin) {
	var globalHeight=getElementById(id).offsetHeight,
	headerHeight=getElementById(id+'Header').offsetHeight,
	cloud=getElementById(id+'Cloud'),
	resizedHeight=globalHeight-headerHeight-padding*2-margin*2;
	cloud.style.height=resizedHeight+'px';
}


/** OGGETTI / ARRAY */

var chatCloudStatus= {
	INACTIVE: "Google is inactive.",
	INITIALIZED: "Google is about to generate a <b>chat-cloud</b>.",
	SENT: "Google is generating a <b>chat-cloud</b>.",
	RECEIVED: "Google is still generating a <b>chat-cloud</b> for you.",
	LOADED: "<b>Chat-cloud</b> generated. Now you can browse it!"
};

var googleStatus= {
	INACTIVE: "Google is inactive",
	INITIALIZED: "Google is thinking...",
	SENT: "Google is still thinking...",
	RECEIVED: "Google is typing..",
	LOADED: "Google wrote something. Now it's your turn."
};

// oggetto di verifica stato
var readyState = {
	INACTIVE:	0,
	INITIALIZED:	1,
	SENT:	2,
	RECEIVED:	3,
	LOADED:	4
};

// array descrittivo dei codici restituiti dal server
// [la scelta dell' array è per evitare problemi con vecchi browsers]
var statusText = new Array();
statusText[100] = "Continue";
statusText[101] = "Switching Protocols";
statusText[200] = "OK";
statusText[201] = "Created";
statusText[202] = "Accepted";
statusText[203] = "Non-Authoritative Information";
statusText[204] = "No Content";
statusText[205] = "Reset Content";
statusText[206] = "Partial Content";
statusText[300] = "Multiple Choices";
statusText[301] = "Moved Permanently";
statusText[302] = "Found";
statusText[303] = "See Other";
statusText[304] = "Not Modified";
statusText[305] = "Use Proxy";
statusText[306] = "(unused, but reserved)";
statusText[307] = "Temporary Redirect";
statusText[400] = "Bad Request";
statusText[401] = "Unauthorized";
statusText[402] = "Payment Required";
statusText[403] = "Forbidden";
statusText[404] = "Not Found";
statusText[405] = "Method Not Allowed";
statusText[406] = "Not Acceptable";
statusText[407] = "Proxy Authentication Required";
statusText[408] = "Request Timeout";
statusText[409] = "Conflict";
statusText[410] = "Gone";
statusText[411] = "Length Required";
statusText[412] = "Precondition Failed";
statusText[413] = "Request Entity Too Large";
statusText[414] = "Request-URI Too Long";
statusText[415] = "Unsupported Media Type";
statusText[416] = "Requested Range Not Satisfiable";
statusText[417] = "Expectation Failed";
statusText[500] = "Internal Server Error";
statusText[501] = "Not Implemented";
statusText[502] = "Bad Gateway";
statusText[503] = "Service Unavailable";
statusText[504] = "Gateway Timeout";
statusText[505] = "HTTP Version Not Supported";
statusText[509] = "Bandwidth Limit Exceeded";