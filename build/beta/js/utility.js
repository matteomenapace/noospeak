/** FUNZIONI */
var count = 0;
var searcher;
var results;
var query;
var gFilter;
var nooStatus;
var gInput;
var gType;

var callback = {
	getresponse : function(response){
		query = response;
		searcher.execute(query);
	},
	
	getranked : function(sentence){
		gType='google';
		loadResponse(sentence[0],results[sentence[1]].url,gType);
		nooStatus.innerHTML = "NooSpeak wrote something. Now it's your turn";
		updateChatCloud(sentence[3]);
		gType='user';
		updateChatCloud(sentence[2]);
	},
	
	getresponseon : function(response) {
		loadResponse(response,'#','alice');
	}
}

var remote = new myserver(callback);

function print_r(theObj){
  if(theObj.constructor == Array ||
     theObj.constructor == Object){
    ("<ul>")
    for(var p in theObj){
      if(theObj[p].constructor == Array||
         theObj[p].constructor == Object){
("<li>["+p+"] => "+typeof(theObj)+"</li>");
        ("<ul>")
        print_r(theObj[p]);
        ("</ul>")
      } else {
("<li>["+p+"] => "+theObj[p]+"</li>");
      }
    }
    ("</ul>")
  }
}


function OnLoad() {

 searcher = new GwebSearch();

searcher.setResultSetSize(GSearch.LARGE_RESULTSET);
searcher.setNoHtmlGeneration();
searcher.setSearchCompleteCallback(null, OnWebSearch);

getElementById('inputStart').focus();
nooStatus = getElementById('status');

}

function search(input,filter,botname) {
	
	gType = 'user';
	gFilter = filter;
	gInput = input;
	loadResponse(input,'#',gType);
	nooStatus.innerHTML = 'NooSpeak is thinking...';
	
	if(filter=='on')
	remote.getresponseon(input,botname);
	
	else
	remote.getresponse(input,filter,botname);

}

function OnWebSearch() {

results = searcher.results;

desc = new Array();

for(i=0;i<results.length;i++)
{
	desc[i]=results[i].content;
}
	remote.getranked(query,desc,gInput);

searcher.clearResults();

}

function getElementById(id) {
	var element;
 	if(document.getElementById)	element = document.getElementById(id);
 	else element = document.all[id];
 	return element;
}

function getRadioValue(form)
{
for (var i=0; i < form.filter.length; i++)
   {
   if (form.filter[i].checked)
      {
      return form.filter[i].value;
      }
   }
}
	
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


////////////////////////////////////////////////////////////////////
// XML utilities

// function to read an XML node content
// ex: <node>content</node> returns "content" 
function readNodeContent(item, nodeName) {
  return item.getElementsByTagName(nodeName).item(0).firstChild.nodeValue;
};

function parseResponseXML(xml){
	
	var	response = xml.getElementsByTagName("response")[0],
		text = readNodeContent(response,"text"),
		time = 'sometime',
		place = 'somewhere',
		//url= readNodeContent(response,"url"),
		similarTopic='#',
		result = "valid XML!";
	
	result = "<div class='google'><div class='name'>Google</div><div class='text'>"+text+"</div><div class='info'>"+time+" "+place+" - <a href='"+similarTopic+"'>similar topic</a></div></div>";
	return result;
}

///////////////////////////////////////////////////////////////////

function styleEntry(type,text,entryId,link,time,place,similarTopic) {
	var 	entry, name;
	if (!time) time= 'sometime';
	if (!place) place='somewhere';
	if (!similarTopic) similarTopic='#';
	if(!link) link="#";
	if (type=='google') {
	name='NooSpeak:';
	entry = "<div class=\"last-entry\" id=\""+entryId+"\"><div class='name'>"+name+"</div><div class='content'><a href='"+link+"' target='_blank'>"+text+"</a></div><div class='time'>"+time+"</div> - <div class=\"place\"> "+place+"</div></div>";
	}
	
	else if(type=='user')
	{
		name='Me:';
		entry = "<div class=\"last-entry\" id=\""+entryId+"\"><div class='name'>"+name+"</div><div class='content'>"+text+"</div><div class='time'>"+time+"</div> - <div class=\"place\"> "+place+"</div></div>";

	}
	
	else
	{
		name='NooSpeak:';
		entry = "<div class=\"last-entry\" id=\""+entryId+"\"><div class='name'>"+name+"</div><div class='content'>"+text+"</div><div class='time'>"+time+"</div> - <div class=\"place\"> "+place+"</div></div>";
	}
	
	
	return entry;
}

function addEntry(element,input,link,type){
		if(count!=0)
		{
	    var lastEntry = "entry"+count;
		document.getElementById(lastEntry).className = "entry";
		}
		count++;
		var entryId = "entry"+count;
		if (type=='google')
		entry = styleEntry('google',input,entryId,link);
		else if(type=='user')
		entry = styleEntry('user',input,entryId);
		else
		entry = styleEntry('alice',input,entryId);
		
		element.innerHTML += entry;
	}
	
function getIframeWindowRef(iframeId) {
  if(document.getElementById && document.getElementById(iframeId) && 
    document.getElementById(iframeId).contentWindow)
      return document.getElementById(iframeId).contentWindow;
  else if(frames && frames[iframeId])
    return frames[iframeId];
  else return null;
}

function loadResponse(sentence,link,type){

		var start = getElementById('start'),
		conversation = getElementById('conversation'),
		inputBox = getElementById('inputConversation'),
		history = getElementById('chatLog');


	// hide #start, show #conversation 
	start.style.display='none';
	conversation.style.display='inline';
	getElementById('filterField').value = gFilter;
	
	inputBox.value="";
	inputBox.focus();
		
	addEntry(history,sentence,link,type);

	history.scrollTop = history.scrollHeight - history.clientHeight;
	return false;
}

function updateChatCloud(content){
	
	if (gType=='google') var cloudFrame = getIframeWindowRef('chatCloudContentBottom');
	else var cloudFrame = getIframeWindowRef('chatCloudContentTop');
	
	var cloudBox = cloudFrame.getElementById('chatCloud');
	
	cloudBox.innerHTML = content;

}


function onLoaded(object){}

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