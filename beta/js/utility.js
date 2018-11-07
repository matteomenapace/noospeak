/** FUNZIONI */
var count = 0;
var searcher;
var results;
var query;
var gFilter;
var gInput;
var gType;
var nooStatus;

var months = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
var days = new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");



var callback = {
	getresponse : function(response){
		//alert('getresponse: ' + response);
		query = response;
		searcher.execute(query);
	},
	
	getranked : function(sentence){
		//alert('getranked: ' + sentence);
		gType='google';
		loadResponse(sentence[0],results[sentence[1]].url,gType);
		nooStatus.innerHTML = "NooSpeak wrote something. Now it's your turn";
		updateChatCloud(sentence[3]);
		gType='user';
		updateChatCloud(sentence[2]);
	},
	
	getresponseon : function(response) {
		//alert('getresponseon: ' + response);
		loadResponse(response[0],'#','alice');
		nooStatus.innerHTML = "NooSpeak wrote something. Now it's your turn";
		gType='google';
		updateChatCloud(response[2]);
		gType='user';
		updateChatCloud(response[1]);
	}
}

// this needs to be created after the callback object is declared
var remote = new myserver(callback);


function OnLoad() {
	

 searcher = new GwebSearch();

searcher.setResultSetSize(GSearch.LARGE_RESULTSET);
searcher.setNoHtmlGeneration();
searcher.setSearchCompleteCallback(null, OnWebSearch);

getElementById('inputStart').focus();
nooStatus = getElementById('status');

}

function search(input,filter,botname) {
	
	//alert('search: ' + botname);
	
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
	
	//alert('OnWebSearch: ' + searcher.results);

	results = searcher.results;

	desc = new Array();

	for(i=0;i<results.length;i++) desc[i]=results[i].content;
	
	//alert('OnWebSearch | query: ' + query + ' desc: ' + desc + ' gInput: ' + gInput);
	
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
	
function setRadioValue(form, value)
{
for (var i=0; i < form.filter.length; i++)
   {
   if (form.filter[i].value == value)
      {
      form.filter[i].checked = 1;
      }
	else
	  form.filter[i].checked = 0;
   }
}
///////////////////////////////////////////////////////////////////

function styleEntry(type,text,entryId,link,time,place,similarTopic) {
	var 	entry, name;
	if (!time)
	{
		stamp = new Date();
		time = days[stamp.getDay( )]+', '+stamp.getDate()+' '+months[stamp.getMonth()]+' at '+stamp.getHours()+':'+stamp.getMinutes();
	}
	if (!place) place='somewhere';
	if (!similarTopic) similarTopic='#';
	if(!link) link="#";
	if (type=='google') {
	name='NooSpeak:';
	entry = "<div class=\"last-entry\" id=\""+entryId+"\"><div class='name'>"+name+"</div><div class='content'><a href='"+link+"' target='_blank'>"+text+"</a></div><div class='time'>"+time+"</div> - <div class=\"place\"> "+"Mountain View (CA)"+"</div></div>";
	}
	
	else if(type=='user')
	{
		name='Me:';
		entry = "<div class=\"last-entry\" id=\""+entryId+"\"><div class='name'>"+name+"</div><div class='content'>"+text+"</div><div class='time'>"+time+"</div> - <div class=\"place\"> "+"London"+"</div></div>";

	}
	
	else
	{
		name='NooSpeak:';
		entry = "<div class=\"last-entry\" id=\""+entryId+"\"><div class='name'>"+name+"</div><div class='content'>"+text+"</div><div class='time'>"+time+"</div> - <div class=\"place\"> "+"Mountain View (CA)"+"</div></div>";
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
 
		start.style.display='none';
		conversation.style.display='inline';
		setRadioValue(document.forms[1],gFilter);
	
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