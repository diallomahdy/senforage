// JavaScript Document

function supprimerContenu(element) {
	if (element != null) {
		while(element.firstChild)
		element.removeChild(element.firstChild);
	}
}
function remplacerContenu(id, texte) {
	var element = document.getElementById(id);
	if (element != null) {
		supprimerContenu(element);
		var nouveauContenu = document.createTextNode(texte);
		element.appendChild(nouveauContenu);
	}
}

function creationXHR() {
	var resultat=null;
	try { // Test pour les navigateurs : Mozilla, Opera...
		resultat= new XMLHttpRequest();
	}
	catch (Error) {
		try { // Test pour les navigateurs Internet Explorer > 5.0
			resultat= new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (Error) {
			try { // Test pour le navigateur Internet Explorer 5.0
				resultat= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (Error) {
				resultat= null;
			}
		}
	}
	return resultat;
}

function encodeContenu(id) {
	//var contenu=document.getElementById(id).value;
	var contenu=document.getElementById(id).value;
	return encodeURIComponent(contenu);
}

function substr_replace(str, replace, start, length)
{
	if (start < 0) { // start position in str
		start = start + str.length;
	}
	length = length !== undefined ? length : str.length;
	if (length < 0) {
		length = length + str.length - start;
	}
	return str.slice(0, start) + replace.substr(0, length) + replace.slice(length) + str.slice(start + length);
}

function sd7(str)
	{
		var pad = '987654321abcdefghijklmnopqrstu';
		var count = str.length;
		if(count<10)
			count = '0'+count;
		var str2 = count+str+pad;
		str2	= str2.substr(0,32);
		var out	= '';
		for(i=1;i<=8;i++)
		{
			k	= 9-i;
			for(j=1;j<=4;j++)
			{
				start	= k*j+(i-1)*(j-1)-1;
				out	+= str2.substr(start,1);
			}
		}
		return out;
	}
	
	function sd7R(str)
	{
		var out	= '00000000000000000000000000000000';
		for(i=1;i<=8;i++)
		{
			k	= 9-i;
			for(j=1;j<=4;j++)
			{
				start	= k*j+(i-1)*(j-1)-1;
				pos	= i*j+(4-j)*(i-1)-1;
				ch		= str.substr(pos,1);
				out	= substr_replace(out,ch,start,1);
			}
		}
		count	= parseInt(out.substr(0,2));
		out	= out.substr(2,count);
		return out;
	}
	
	function sd720(str)
	{
		var i;
		var j;
		var ch = '987654321abcdefghijklmnopqrstu';
		var count = str.length;
		if(count<10)
			count = '0'+count;
		var str2 = count+str+ch;
		var out	= '';
		for(i=1;i<=5;i++)
		{
			k	= 6-i;
			for(j=1;j<=4;j++)
			{
				start	= k*j+(i-1)*(j-1)-1;
				out	+= str2.substr(start,1);
			}
		}
		return out;
	}
	
	function sd720R(str)
	{
		out	= '00000000000000000000';
		for(i=1;i<=5;i++)
		{
			k	= 6-i;
			for(j=1;j<=4;j++)
			{
				start	= k*j+(i-1)*(j-1)-1;
				pos	= i*j+(4-j)*(i-1)-1;
				ch		= str.substr(pos,1);
				out	= substr_replace(out,ch,start,1);
			}
		}
		count	= parseInt(out.substr(0,2));
		out	= out.substr(2,count);
		return out;
	}
	
function exchange(a,b){
	var temp = a;
	a = b;
	b = temp;
}

function isDate(text) {

    var gDate = Date.parse(text);

    if (isNaN(gDate)) {
        return false;
    }

    var comp = text.split('/');

    if (comp.length !== 3) {
        var comp = text.split('-');
		if (comp.length !== 3) {
			return false;
		}
    }

    var day = parseInt(comp[0], 10);
    var month = parseInt(comp[1], 10);
    var year = parseInt(comp[2], 10);
	if(day > 999){
		var temp = day;
		day = year;
		year = temp;
	}
    var date = new Date(year, month-1, day);
    return (date.getFullYear() == year && date.getMonth() + 1 == month && date.getDate() == day)
}

function isAlpha(ch)
{
	var Alpha = /^[a-zA-Z]+$/;
	if((ch=='')||(!Alpha.test(ch)))
       	return false;
	else
       	return true;
}

function isAlphaNum(ch)
{
	var AlphaNum = /^[\w-]+$/;
	if((ch=='')||(!AlphaNum.test(ch)))
       	return false;
	else
       	return true;
}

function validateEmail(email) {
	//var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if((email=='')||( !emailReg.test( email ) ))
		return false;
	else
		return true;
}

function validateTel(tel){
	tel = tel.replace(/ /g,"");
    for (i = 0; i < tel.length; i++){   
        var c = tel.charAt(i);
        if (((c < "0") || (c > "9") || (c==" ".charAt(0)))) return false;
    }
    return true;
}

function validateFileFormat(file_name, array_format){
	//if(file_name=="") return false;
	tab = file_name.split(".");
	ext = tab[tab.length-1];
	longueur = array_format.length;
	for(i=0; i<longueur; i++){
		if(ext==array_format[i]) return true;
	}
	return false;
}

function detect_url(str){
	//alert('begining : '+str);
	//URL PATTERN (not case-sensitive)
	//var p = /^(http(s)?|ftp):\/\/([a-z0-9_-]+\.)+([a-z]{2,}){1}((:|\/)(.*))?$/; //return(str);
	var p = /^(((http(s)?|ftp):\/\/)|www\.)([a-z0-9_-]+\.)+([a-z]{2,}){1}((:|\/)(.*))?$/;
	//var reg = new RegExp("[ ,;\n\r]+", "g");
	//var w = str.split(' '); //SPLITS STRING WITH SPACES TO ISOLATE URLS
	var w = str.split(/(\r\n|\n|\r| )/g);
	var t = ''; //NULL VARIABLE UNTIL INSIDE "FOR LOOP"
	
	//SEARCHES THRU ENTIRE STRING TO FIND TEXTS MATCHING URL PATTERN 
	var i;
	for(i=0; i<w.length; i++){
		if(w[i].match(p)) //IF TEXT MATCHES PATTERN...
		{
			//t += '<a href="'+w[i]+'" target="_blank">'+w[i]+'</a> '; //ADDS THE "<a>" TAG WHEN TEXT MATCHES PATTERN
			t += '<a href="'+w[i]+'" target="_blank" class="url_wrap">'+w[i]+'</a> ';
		}
		else 
		{
			t += w[i]+' '; //SHOWS AS REGULAR TEXT
		}
	}
	//alert('end : '+t);
	return t;
}
function rewrite_url(str){ return detect_url(str); }

function zoomer(elt, newWidth){
	oldWidth	= $(elt).width();
	zoomLev		= newWidth / oldWidth;
	if (typeof (document.body.style.zoom) != "undefined") {
	$(document.body).css('zoom', zoomLev);
	}
	else {
		// Mozilla doesn't support zoom, use -moz-transform to scale and compensate for lost width
		$(elt).css('-moz-transform', "scale(" + zoomLev + ")");
		$(elt).width($(window).width() / zoomLev + 10);
		$(elt).css('position', 'relative');
		$(elt).css('left', (($(window).width() - oldWidth - 16) / 2) + "px");
		$(elt).css('top', "-19px");
		$(elt).css('position', 'relative');
	}
}

function mmd_rotate(element){
	self		= $(element); self.css('width',400);
	nbChild		= self.children().length;
	width		= self.width();
	height		= self.height();
	child_w		= self.children().width();
	child_h		= self.children().height();
	child_wl	= width/nbChild;
	rapport		= (child_w-child_wl)/child_w;
	child_hl	= child_h-(child_h*rapport);
	marge		= (child_wl - child_w)/2;
	
	for(i=0; i<nbChild; ++i){
			
	}
	sef.css('overflow','hidden');
	for(i=0; i<nbChild; ++i){
		temp_elt = sef.children().eq(i);
		/*temp.css({'width':child_wl, 'height':child_hl});
		if(temp.children().length>0)*/
		zoomer($(element).children().eq(i), 20);
	}
	reste = nbChild%2;
	if(reste==0){ // paire
		milieu = (nbChild-1)/2;
	}
	else milieu = nbChild/2; // impaire
	elt_milieu = self.children().eq(milieu);
	//elt_milieu.css({'width':child_w, 'height':child_h});
	//elt_milieu.before().css({'width':child_w, 'height':child_h});
	//elt_milieu.after().css({'width':child_w, 'height':child_h});
}

function slide(elt,nextBT,prevRT)
	{
		elt_wrap = elt +'wrap';
		wrap_marker = elt_wrap.replace("#","");
		Reference = $(elt).children().eq(0);
		NbElement = $(elt).children().length;
			
		$(elt)
			.wrap('<div id="'+ wrap_marker +'"></div>')
			.css("width", (Reference.width() * NbElement) );
		
		$(elt_wrap)
			.width(  Reference.width()  )
			.height( Reference.height() )
			.css("overflow", "hidden")
			
		
		Cpt = 0;
		$(nextBT).click(function()
		{
			if(Cpt < (NbElement-1) )
			{
				Cpt++;
				$(elt).animate({
					marginLeft : - (Reference.width() * Cpt)
				}, 1000);
			}
		});
		$(prevRT).click(function()
		{
			if(Cpt > 0)
			{
				Cpt--;
				$(elt).animate({
					marginLeft : - (Reference.width() * Cpt)
				}, 1000);
			}
		});
	}

function popup_img(elt, width, height){
	offset = $(elt).offset();
	x = offset.left;
	y = offset.top;
	$(elt).append('<div id="popup_img"></div>');
	$('#popup_small').css({"position":"fixed", "width":width, "height":height, "left":x, "top":y, "background-color":"black", "opacity":0.97, 'z-index':93})
	.append('<div id="child_node" class="width_80pc height_80pc margin_10pc"></div>');
	$('#child_node').css({/*'margin':50, 'height':screenH/1.5, 'padding':10,*/ 'background-color':'white', 'opacity':1})
	.append('<div id="close_tab" title="Fermer"></div>');
	$('#close_tab').click(function(){	$('#popup_full').remove();	});
	return $('#child_node');
}

function popup(width, height)
{
		screenW =  $(window).width();
		screenH =  $(window).height();
		$('body').append('<div id="popup_full"></div>');
		$('#popup_full').css({"position":"fixed", "width":screenW, "height":screenH, 'top':0, 'left':0, "background-color":"black", "opacity":0.6, 'z-index':9999999990});
		$('body').append('<div id="child_node"></div>');
		$('#child_node').css({"position":"fixed", "width":width, 'height':height, "left":(screenW-width)/2, "top":(screenH-height)/2, 'padding':30, 'box-shadow':'0px 0px 12px #000', 'border-radius':'7px', 'background-color':'white', 'opacity':1, 'z-index':9999999999})
		.append('<div id="close_tab" title="Fermer" class="font_red font_24 bold"></div>');
		$('#close_tab').html('<img src="/src/images/tbn/close.jpg"/>')
		.css({'width':20, 'height':20, 'margin-top':-40, 'margin-right':-20, 'float':'right', 'border-radius':5, 'cursor':'pointer', 'font-weight':'bolder'})
		.click(function(){	$('#popup_full, #child_node').remove();	});
		return $('#child_node');
}

jQuery.fn.preloader = function(){ this.html('<img id="preloader" src="/w.src/images/tbn/preloader.gif" width=16 />');}

jQuery.fn.exists = function(){return this.length>0;}

/*
function htmlEscape(str) {
    return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}

function htmlUnescape(value){
	return String(value)
		.replace(/&quot;/g, '"')
		.replace(/&#39;/g, "'")
		.replace(/&lt;/g, '<')
		.replace(/&gt;/g, '>')
		.replace(/&amp;/g, '&')
		.replace(/&eacute;/g, '�')
		.replace(/&acute;/g, '�')
		.replace(/&egrave;/g, '�')
		.replace(/&agrave;/g, '�')
		.replace(/&rsquo;/g, '�')
		.replace(/&nbsp;/g, ' ')
	;
}
*/

/*function htmlEncode(str)
{
	return str
		.replace(/(\r\n|\n|\r)/g, '<br />')
		.replace(/'/g,'&rsquo;')
		.replace(/"/g,'&quot;')
		.replace(/<\?/g,'')
		.replace(/\?>/g,'');
}*/

/*function htmlEncode(str)
{
	return str
		.replace(/(\r\n|\n|\r)/g, '<br />')
		.replace(/'/g,'&#39;')
		.replace(/"/g,'&quot;')
		.replace(/<\?/g,'')
		.replace(/\?>/g,'');
}*/

function htmlEncode(value){
	  var out = value.replace(/</g, '#lt;').replace(/>/g, '#gt;'); //alert(out);
	  out = $('<div/>').html(out).html(); //alert(out);
	  return String(out)
	  		.replace(/(\r\n|\n|\r)/g, '<br />')
			//.replace(/&quot;/g, '"')
			.replace(/"/g, '&quot;')
			.replace(/&amp;/g, 'E')
			.replace(/&euro;/g, 'E')
			.replace(/&nbsp;/g, ' ')
			.replace(/&#39;/g, "'")
			/*.replace(/&lt;/g, '<')
			.replace(/&gt;/g, '>')
			.replace(/&;lt/g, '<')
			.replace(/&;gt/g, '>')*/
			.replace(/&Agrave;/g, 'A')
			.replace(/&Aacute;/g, 'A')
			.replace(/&Acirc;/g, 'A')
			.replace(/&Atilde;/g, 'A')
			.replace(/&Ccedil;/g, 'C')
			.replace(/&Egrave;/g, 'E')
			.replace(/&Eacute;/g, 'E')
			.replace(/&Ecirc;/g, 'E')
			.replace(/&Icirc;/g, 'I')
			.replace(/&Iuml;/g, 'I')
			.replace(/&Ntilde;/g, 'N')
			.replace(/&Ocirc;/g, 'O')
			.replace(/&Ugrave;/g, 'U')
			.replace(/&Uacute;/g, 'U')
			.replace(/&Ucirc;/g, 'U')
			.replace(/&agrave;/g, '�')
			.replace(/&acirc;/g, '�')
			.replace(/&ccedil;/g, '�')
			.replace(/&egrave;/g, '�')
			.replace(/&eacute;/g, '�')
			.replace(/&ecirc;/g, '�')
			.replace(/&icirc;/g, '�')
			.replace(/&iuml;/g, '�')
			.replace(/&ntilde;/g, 'n')
			.replace(/&ocirc;/g, '�')
			.replace(/&divide;/g, '/')
			.replace(/&ugrave;/g, '�')
			.replace(/&ucirc;/g, '�')
			.replace(/&acute;/g, '�')
			.replace(/&rsquo;/g, '�')
			.replace(/<\?php/g, '')
			/*.replace(/<\?/g, '')*/
			.replace(/\?>/g, '')
		;
	}

/*jQuery.fn.htmlEncode = function()
{
  //return $('<div/>').text(value).html();
  //alert(this.html());
 // var out = $('<div/>').text(this.html()).html();
 // this.html(out); alert(out);
  //return val.replace(/(\r\n|\n|\r)/g, '<br />').replace(/'/g,'�');
	var out = this.val();
	out.replace(/(\r\n|\n|\r)/g, '<br />')
		.replace(/'/g,'&rsquo;')
		.replace(/"/g,'&quot;')
		.replace(/<\?/g,'')
		.replace(/\?>/g,'');
	this.val(out);
}
jQuery.fn.htmlDecode = function (value)
{
  var out = $('<div/>').html(value).html();
  return String(out)
		.replace(/&quot;/g, '"')
		.replace(/&amp;/g, 'E')
		.replace(/&euro;/g, 'E')
		.replace(/&nbsp;/g, ' ')
		.replace(/&#39;/g, "'")
		.replace(/&lt;/g, '<')
		.replace(/&gt;/g, '>')
		.replace(/&Agrave;/g, 'A')
		.replace(/&Aacute;/g, 'A')
		.replace(/&Acirc;/g, 'A')
		.replace(/&Atilde;/g, 'A')
		.replace(/&Ccedil;/g, 'C')
		.replace(/&Egrave;/g, 'E')
		.replace(/&Eacute;/g, 'E')
		.replace(/&Ecirc;/g, 'E')
		.replace(/&Icirc;/g, 'I')
		.replace(/&Iuml;/g, 'I')
		.replace(/&Ntilde;/g, 'N')
		.replace(/&Ocirc;/g, 'O')
		.replace(/&Ugrave;/g, 'U')
		.replace(/&Uacute;/g, 'U')
		.replace(/&Ucirc;/g, 'U')
		.replace(/&agrave;/g, '�')
		.replace(/&acirc;/g, '�')
		.replace(/&ccedil;/g, '�')
		.replace(/&egrave;/g, '�')
		.replace(/&eacute;/g, '�')
		.replace(/&ecirc;/g, '�')
		.replace(/&icirc;/g, '�')
		.replace(/&iuml;/g, '�')
		.replace(/&ntilde;/g, 'n')
		.replace(/&ocirc;/g, '�')
		.replace(/&divide;/g, '/')
		.replace(/&ugrave;/g, '�')
		.replace(/&ucirc;/g, '�')
		.replace(/&acute;/g, '�')
		.replace(/&rsquo;/g, '�')
		.replace(/<\?php/g, '')
		.replace(/<\?/g, '')
		.replace(/\?>/g, '')
	;
}
*/
$.fn.caret = function (begin, end)
    {
        if (this.length == 0) return;
        if (typeof begin == 'number')
        {
            end = (typeof end == 'number') ? end : begin;
            return this.each(function ()
            {
                if (this.setSelectionRange)
                {
                    this.setSelectionRange(begin, end);
                } else if (this.createTextRange)
                {
                    var range = this.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', end);
                    range.moveStart('character', begin);
                    try { range.select(); } catch (ex) { }
                }
            });
        } else
        {
            if (this[0].setSelectionRange)
            {
                begin = this[0].selectionStart;
                end = this[0].selectionEnd;
            } else if (document.selection && document.selection.createRange)
            {
                var range = document.selection.createRange();
                begin = 0 - range.duplicate().moveStart('character', -100000);
                end = begin + range.text.length;
            }
            return { begin: begin, end: end };
        }
    }

function caretPos(el)
{
    var pos = 0;
    // IE Support
    if (document.selection) 
    {
    	el.focus ();
    	var Sel = document.selection.createRange();
    	var SelLength = document.selection.createRange().text.length;
    	Sel.moveStart ('character', -el.value.length);
    	pos = Sel.text.length - SelLength;
    }
    // Firefox support
    else if (el.selectionStart || el.selectionStart == '0')
    	pos = el.selectionStart;

    return pos;

}

/*
** Returns the caret (cursor) position of the specified text field.
** Return value range is 0-oField.value.length.
*/
function doGetCaretPosition (oField) {

  // Initialize
  var iCaretPos = 0;

  // IE Support
  if (document.selection) {

    // Set focus on the element
    oField.focus ();

    // To get cursor position, get empty selection range
    var oSel = document.selection.createRange ();

    // Move selection start to 0 position
    oSel.moveStart ('character', -oField.value.length);

    // The caret position is selection length
    iCaretPos = oSel.text.length;
  }

  // Firefox support
  else if (oField.selectionStart || oField.selectionStart == '0')
    iCaretPos = oField.selectionStart;

  // Return results
  return (iCaretPos);
}

/**
 * Contributed by Jean-Yves ORSSAUD, Rouen, France
 * And a litte help from an anonymous, er, helper
 */
/*
jQuery.extend(jQuery.validator.messages, {
			required			: "Ce champ est requis.",
			email				: "Veuillez saisir une adresse mail valide.",
			url					: "Veuillez saisir une URL valide.",
			creditcard			: "Veuillez saisir un num�ro de carte de cr�dit valide.",
			date				: "Veuillez saisir une date valide.",
			datetime			: "Veuillez saisir une date/heure valide.(aaaa-mm-jjThh:mm:ssZ)",
			'datetime-local'	: "Veuillez saisir une date/heure locale valide.(aaaa-mm-jjThh:mm:ss)",
			time				: "Veuillez saisir une heure valide.",
			alphabetic			: "Veuillez ne saisir que des lettres.",
			alphanumeric		: "Veuillez ne saisir que des lettres, soulign� et chiffres.",
			color				: "Veuillez saisir une couleur valide. (nomm�e, hexadecimale ou rvb)",
			month				: "Veuillez saisir une ann�e et un mois. (ex.: 1974-03)",
			week				: "Veuillez saisir une ann�e et une semaine. (ex.: 1974-W43)",
			number				: "Veuillez saisir un nombre.(ex.: 12,-12.5,-1.3e-2)",
			integer				: "Veuillez saisir un nombre sans decimales.",
			zipcode				: "Veuillez saisir un code postal valide.",
			minlength			: "Veuillez saisir au moins {0} caract�res.",
			maxlength			: "Veuillez ne pas saisir plus de {0} caract�res.",
			min					: "Veuillez saisir une valeur sup�rieure ou �gale � {0}.",
			max					: "Veuillez saisir une valeur inf�rieure ou �gale � {0}.",
			mustmatch			: "Veuillez resaisir la m�me valeur.",
			captcha				: "Votre r�ponse ne correspond pas au texte de l'image. R�esayez.",
			personnummer		: "Veuillez saisir un personnummer valide. (aaaammjj-aaaa)",
			organisationsnummer	: "Veuillez saisir un organisationsnummer valide. (xxyyzz-aaaa)",
			ipv4				: "Veuillez saisir une adresse IP valide (version 4).",
			ipv6				: "Veuillez saisir une adresse IP valide (version 6).",
			tel					: "Veuillez saisir un num�ro de t�l�phone valide.",
			remote				: "Veuillez v�rifier ce champ." // ? why?
});*/

$.fn.loader = function (how){
    var html = '<img class="loader" src="' + PHPConfig.loader_img + '" width="32"/>';
    if(how=='append'){
        this.append(html);
    }
    else if(how=='prepend'){
        this.prepend(html);
    }
    else if(how=='after'){
        this.after(html);
    }
    else if(how=='before'){
        this.before(html);
    }
    else if(how=='replace'){
        this.html(html);
    }
};

$.fn.handleStatus = function (message, status = 'danger'){
    var statusMsg = '<div class="alert alert-' + status + '">';
    statusMsg += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">';
    statusMsg += '×</button>';
    statusMsg += '<span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;';
    statusMsg += message;
    statusMsg += '</div>';
    this.html(statusMsg);
};

$.removeLoader = function () {
    $('.loader').remove();
};

$.getIPInfo = function () {
    $http({
        method: 'POST',
        url: 'http://ipinfo.io',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function onSuccess(response) {
        return response.data;
    }, function onError(response) {
        //alert('error');
    });
}

$(document).ready(function () {

    function getDOM() {
        var dom = {};
        $('[id]').each(function (node) {
            //var item = {};
            //item['tagName'] = $(this).attr("tagName").toLowerCase();
            /*var tagName = $(this)[0].tagName.toLowerCase();
             item['tagName'] = tagName;
             $.each( $(this)[0].attributes, function ( index, attribute ) {
             item[attribute.name] = attribute.value;
             } );
             DOM[tagName] = $(this);*/
            dom[$(this).attr('id')] = $(this);
        });
        return dom;
    }
    
   dom = getDOM();

});


