// JavaScript Document

/*

Author - WPTitans
Description - Main file for Javascript stuff for the theme. Powered by jQuery.

Index :-

1. Hades Super Object


*/
jQuery.noConflict();
(function(g){g.cookie=function(h,b,a){if(1<arguments.length&&(!/Object/.test(Object.prototype.toString.call(b))||null===b||void 0===b)){a=g.extend({},a);if(null===b||void 0===b)a.expires=-1;if("number"===typeof a.expires){var d=a.expires,c=a.expires=new Date;c.setDate(c.getDate()+d)}b=""+b;return document.cookie=[encodeURIComponent(h),"=",a.raw?b:encodeURIComponent(b),a.expires?"; expires="+a.expires.toUTCString():"",a.path?"; path="+a.path:"",a.domain?"; domain="+a.domain:"",a.secure?"; secure":
""].join("")}for(var a=b||{},d=a.raw?function(a){return a}:decodeURIComponent,c=document.cookie.split("; "),e=0,f;f=c[e]&&c[e].split("=");e++)if(d(f[0])===h)return d(f[1]||"");return null}})(jQuery);


window.define=function(){Array.prototype.slice.call(arguments).pop()(window.jQuery)};
define(["jquery","../external/requirejs/text!../version.txt","./jquery.mobile.widget"],function(c,k){(function(a,c){var e={};a.mobile=a.extend({},{version:k,ns:"",subPageUrlKey:"ui-page",activePageClass:"ui-page-active",activeBtnClass:"ui-btn-active",focusClass:"ui-focus",ajaxEnabled:!0,hashListeningEnabled:!0,linkBindingEnabled:!0,defaultPageTransition:"fade",maxTransitionWidth:!1,minScrollBack:250,touchOverflowEnabled:!1,defaultDialogTransition:"pop",loadingMessage:"loading",pageLoadErrorMessage:"Error Loading Page",
loadingMessageTextVisible:!1,loadingMessageTheme:"a",pageLoadErrorMessageTheme:"e",autoInitializePage:!0,pushStateEnabled:!0,ignoreContentEnabled:!1,orientationChangeEnabled:!0,buttonMarkup:{hoverDelay:200},keyCode:{ALT:18,BACKSPACE:8,CAPS_LOCK:20,COMMA:188,COMMAND:91,COMMAND_LEFT:91,COMMAND_RIGHT:93,CONTROL:17,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,INSERT:45,LEFT:37,MENU:93,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,NUMPAD_SUBTRACT:109,PAGE_DOWN:34,
PAGE_UP:33,PERIOD:190,RIGHT:39,SHIFT:16,SPACE:32,TAB:9,UP:38,WINDOWS:91},silentScroll:function(b){"number"!==a.type(b)&&(b=a.mobile.defaultHomeScroll);a.event.special.scrollstart.enabled=!1;setTimeout(function(){c.scrollTo(0,b);a(document).trigger("silentscroll",{x:0,y:b})},20);setTimeout(function(){a.event.special.scrollstart.enabled=true},150)},nsNormalizeDict:e,nsNormalize:function(b){if(b)return e[b]||(e[b]=a.camelCase(a.mobile.ns+b))},getInheritedTheme:function(a,h){for(var g=a[0],i="",c=/ui-(bar|body|overlay)-([a-z])\b/,
d,f;g;){d=g.className||"";if((f=c.exec(d))&&(i=f[2]))break;g=g.parentNode}return i||h||"a"},closestPageData:function(a){return a.closest(':jqmData(role="page"), :jqmData(role="dialog")').data("page")},enhanceable:function(a){return this.haveParents(a,"enhance")},hijackable:function(a){return this.haveParents(a,"ajax")},haveParents:function(b,h){if(!a.mobile.ignoreContentEnabled)return b;for(var g=b.length,d=a(),c,f,e,j=0;j<g;j++){f=b.eq(j);e=!1;for(c=b[j];c;){if("false"===(c.getAttribute?c.getAttribute("data-"+
a.mobile.ns+h):"")){e=!0;break}c=c.parentNode}e||(d=d.add(f))}return d}},a.mobile);a.fn.jqmData=function(b,h){var c;"undefined"!=typeof b&&(b&&(b=a.mobile.nsNormalize(b)),c=this.data.apply(this,2>arguments.length?[b]:[b,h]));return c};a.jqmData=function(b,c,d){var f;"undefined"!=typeof c&&(f=a.data(b,c?a.mobile.nsNormalize(c):c,d));return f};a.fn.jqmRemoveData=function(b){return this.removeData(a.mobile.nsNormalize(b))};a.jqmRemoveData=function(b,c){return a.removeData(b,a.mobile.nsNormalize(c))};
a.fn.removeWithDependents=function(){a.removeWithDependents(this)};a.removeWithDependents=function(b){b=a(b);(b.jqmData("dependents")||a()).remove();b.remove()};a.fn.addDependents=function(b){a.addDependents(a(this),b)};a.addDependents=function(b,c){var d=a(b).jqmData("dependents")||a();a(b).jqmData("dependents",a.merge(d,c))};a.fn.getEncodedText=function(){return a("<div/>").text(a(this).text()).html()};a.fn.jqmEnhanceable=function(){return a.mobile.enhanceable(this)};a.fn.jqmHijackable=function(){return a.mobile.hijackable(this)};
var f=a.find,d=/:jqmData\(([^)]*)\)/g;a.find=function(b,c,e,i){b=b.replace(d,"[data-"+(a.mobile.ns||"")+"$1]");return f.call(this,b,c,e,i)};a.extend(a.find,f);a.find.matches=function(b,c){return a.find(b,null,null,c)};a.find.matchesSelector=function(b,c){return 0<a.find(c,null,null,[b]).length}})(jQuery,this)});
define(["jquery","./jquery.mobile.core"],function(){(function(c){c(window);var k=c("html");c.mobile.media=function(){var a={},l=c("<div id='jquery-mediatest'>"),e=c("<body>").append(l);return function(c){if(!(c in a)){var d=document.createElement("style"),b="@media "+c+" { #jquery-mediatest { position:absolute; } }";d.type="text/css";d.styleSheet?d.styleSheet.cssText=b:d.appendChild(document.createTextNode(b));k.prepend(e).prepend(d);a[c]="absolute"===l.css("position");e.add(d).remove()}return a[c]}}()})(jQuery)});
define(["jquery","./jquery.mobile.media","./jquery.mobile.core"],function(){(function(a,p){function n(e){var a=e.charAt(0).toUpperCase()+e.substr(1),e=(e+" "+o.join(a+" ")+a).split(" "),b;for(b in e)if(q[e[b]]!==p)return!0}function m(a,d,b){for(var c=document.createElement("div"),b=b?[b]:o,h,i=0;i<b.length;i++){var j=b[i],r="-"+j.charAt(0).toLowerCase()+j.substr(1)+"-"+a+": "+d+";",j=j.charAt(0).toUpperCase()+j.substr(1)+(a.charAt(0).toUpperCase()+a.substr(1));c.setAttribute("style",r);c.style[j]&&
(h=!0)}return!!h}var k=a("<body>").prependTo("html"),q=k[0].style,o=["Webkit","Moz","O"],l="palmGetResource"in window,d=window.operamini&&"[object OperaMini]"==={}.toString.call(window.operamini),c=window.blackberry;a.extend(a.mobile,{browser:{}});a.mobile.browser.ie=function(){for(var a=3,d=document.createElement("div"),b=d.all||[];d.innerHTML="<\!--[if gt IE "+ ++a+"]><br><![endif]--\>",b[0];);return 4<a?a:!a}();a.extend(a.support,{orientation:"orientation"in window&&"onorientationchange"in window,
touch:"ontouchend"in document,cssTransitions:"WebKitTransitionEvent"in window||m("transition","height 100ms linear"),pushState:"pushState"in history&&"replaceState"in history,mediaquery:a.mobile.media("only all"),cssPseudoElement:!!n("content"),touchOverflow:!!n("overflowScrolling"),cssTransform3d:m("perspective","10px","moz")||a.mobile.media("(-"+o.join("-transform-3d),(-")+"-transform-3d),(transform-3d)"),boxShadow:!!n("boxShadow")&&!c,scrollTop:("pageXOffset"in window||"scrollTop"in document.documentElement||
"scrollTop"in k[0])&&!l&&!d,dynamicBaseTag:function(){var e=location.protocol+"//"+location.host+location.pathname+"ui-dir/",d=a("head base"),b=null,c="",h;d.length?c=d.attr("href"):d=b=a("<base>",{href:e}).appendTo("head");h=a("<a href='testurl' />").prependTo(k)[0].href;d[0].href=c||location.pathname;b&&b.remove();return 0===h.indexOf(e)}()});k.remove();l=function(){var a=window.navigator.userAgent;return-1<a.indexOf("Nokia")&&(-1<a.indexOf("Symbian/3")||-1<a.indexOf("Series60/5"))&&-1<a.indexOf("AppleWebKit")&&
a.match(/(BrowserNG|NokiaBrowser)\/7\.[0-3]/)}();a.mobile.gradeA=function(){return a.support.mediaquery||a.mobile.browser.ie&&7<=a.mobile.browser.ie};a.mobile.ajaxBlacklist=window.blackberry&&!window.WebKitPoint||d||l;l&&a(function(){a("head link[rel='stylesheet']").attr("rel","alternate stylesheet").attr("rel","stylesheet")});a.support.boxShadow||a("html").addClass("ui-mobile-nosupport-boxshadow")})(jQuery)});
define(["jquery","./jquery.mobile.core","./jquery.mobile.support","./jquery.mobile.vmouse"],function(){(function(a,p,n){function m(d,c,e){var f=e.type;e.type=c;a.event.handle.call(d,e);e.type=f}a.each("touchstart,touchmove,touchend,orientationchange,throttledresize,tap,taphold,swipe,swipeleft,swiperight,scrollstart,scrollstop".split(","),function(d,c){a.fn[c]=function(a){return a?this.bind(c,a):this.trigger(c)};a.attrFn[c]=true});var k=a.support.touch,q=k?"touchstart":"mousedown",o=k?"touchend":"mouseup",
l=k?"touchmove":"mousemove";a.event.special.scrollstart={enabled:!0,setup:function(){function d(a,d){e=d;m(c,e?"scrollstart":"scrollstop",a)}var c=this,e,f;a(c).bind("touchmove scroll",function(b){a.event.special.scrollstart.enabled&&(e||d(b,!0),clearTimeout(f),f=setTimeout(function(){d(b,!1)},50))})}};a.event.special.tap={setup:function(){var d=this,c=a(d);c.bind("vmousedown",function(e){function f(){clearTimeout(i)}function b(){f();c.unbind("vclick",g).unbind("vmouseup",f);a(document).unbind("vmousecancel",
b)}function g(a){b();h==a.target&&m(d,"tap",a)}if(e.which&&1!==e.which)return!1;var h=e.target,i;c.bind("vmouseup",f).bind("vclick",g);a(document).bind("vmousecancel",b);i=setTimeout(function(){m(d,"taphold",a.Event("taphold",{target:h}))},750)})}};a.event.special.swipe={scrollSupressionThreshold:10,durationThreshold:1E3,horizontalDistanceThreshold:30,verticalDistanceThreshold:75,setup:function(){var d=a(this);d.bind(q,function(c){function e(d){if(b){var c=d.originalEvent.touches?d.originalEvent.touches[0]:
d;g={time:(new Date).getTime(),coords:[c.pageX,c.pageY]};Math.abs(b.coords[0]-g.coords[0])>a.event.special.swipe.scrollSupressionThreshold&&d.preventDefault()}}var f=c.originalEvent.touches?c.originalEvent.touches[0]:c,b={time:(new Date).getTime(),coords:[f.pageX,f.pageY],origin:a(c.target)},g;d.bind(l,e).one(o,function(){d.unbind(l,e);b&&g&&g.time-b.time<a.event.special.swipe.durationThreshold&&Math.abs(b.coords[0]-g.coords[0])>a.event.special.swipe.horizontalDistanceThreshold&&Math.abs(b.coords[1]-
g.coords[1])<a.event.special.swipe.verticalDistanceThreshold&&b.origin.trigger("swipe").trigger(b.coords[0]>g.coords[0]?"swipeleft":"swiperight");b=g=n})})}};(function(a,c){function e(){var a=b();a!==g&&(g=a,f.trigger("orientationchange"))}var f=a(c),b,g,h,i,j={"0":!0,180:!0};if(a.support.orientation&&(h=c.innerWidth||a(c).width(),i=c.innerHeight||a(c).height(),h=h>i&&50<h-i,i=j[c.orientation],h&&i||!h&&!i))j={"-90":!0,90:!0};a.event.special.orientationchange={setup:function(){if(a.support.orientation&&
a.mobile.orientationChangeEnabled)return!1;g=b();f.bind("throttledresize",e)},teardown:function(){if(a.support.orientation&&a.mobile.orientationChangeEnabled)return!1;f.unbind("throttledresize",e)},add:function(a){var c=a.handler;a.handler=function(a){a.orientation=b();return c.apply(this,arguments)}}};a.event.special.orientationchange.orientation=b=function(){var b=!0,b=document.documentElement;return(b=a.support.orientation?j[c.orientation]:b&&1.1>b.clientWidth/b.clientHeight)?"portrait":"landscape"}})(jQuery,
p);(function(){a.event.special.throttledresize={setup:function(){a(this).bind("resize",d)},teardown:function(){a(this).unbind("resize",d)}};var d=function(){f=(new Date).getTime();b=f-c;250<=b?(c=f,a(this).trigger("throttledresize")):(e&&clearTimeout(e),e=setTimeout(d,250-b))},c=0,e,f,b})();a.each({scrollstop:"scrollstart",taphold:"tap",swipeleft:"swipe",swiperight:"swipe"},function(d,c){a.event.special[d]={setup:function(){a(this).bind(c,a.noop)}}})})(jQuery,this)});




window.matchMedia = window.matchMedia || (function( doc, undefined ) {

  "use strict";

  var bool,
      docElem = doc.documentElement,
      refNode = docElem.firstElementChild || docElem.firstChild,
      // fakeBody required for <FF4 when executed in <head>
      fakeBody = doc.createElement( "body" ),
      div = doc.createElement( "div" );

  div.id = "mq-test-1";
  div.style.cssText = "position:absolute;top:-100em";
  fakeBody.style.background = "none";
  fakeBody.appendChild(div);

  return function(q){

    div.innerHTML = "&shy;<style media=\"" + q + "\"> #mq-test-1 { width: 42px; }</style>";

    docElem.insertBefore( fakeBody, refNode );
    bool = div.offsetWidth === 42;
    docElem.removeChild( fakeBody );

    return {
      matches: bool,
      media: q
    };

  };

}( document ));


window.enquire=function(e){"use strict";function t(e,t){var n=0,r=e.length,i;for(n;n<r;n++){i=t(e[n],n);if(i===!1)break}}function n(e){return Object.prototype.toString.apply(e)==="[object Array]"}function r(e){return typeof e=="function"}function i(e){this.initialised=!1,this.options=e,e.deferSetup||this.setup()}function s(e,t){this.query=e,this.isUnconditional=t,this.handlers=[],this.matched=!1}function o(){if(!e)throw new Error("matchMedia is required");var t=new s("only all");this.queries={},this.listening=!1,this.browserIsIncapable=!t.matchMedia()}return i.prototype={setup:function(){this.options.setup&&this.options.setup(),this.initialised=!0},on:function(e){this.initialised||this.setup(),this.options.match(e)},off:function(e){this.options.unmatch&&this.options.unmatch(e)},destroy:function(){this.options.destroy?this.options.destroy():this.off()},equals:function(e){return this.options===e||this.options.match===e}},s.prototype={matchMedia:function(){return e(this.query).matches},addHandler:function(e){this.handlers.push(new i(e))},removeHandler:function(e){var n=this.handlers;t(n,function(t,r){if(t.equals(e))return t.destroy(),!n.splice(r,1)})},assess:function(){this.matchMedia()||this.isUnconditional?this.match():this.unmatch()},match:function(e){if(this.matched)return;t(this.handlers,function(t){t.on(e)}),this.matched=!0},unmatch:function(e){if(!this.matched)return;t(this.handlers,function(t){t.off(e)}),this.matched=!1}},o.prototype={register:function(e,i,o){var u=this.queries,a=o&&this.browserIsIncapable;return u.hasOwnProperty(e)||(u[e]=new s(e,a)),r(i)&&(i={match:i}),n(i)||(i=[i]),t(i,function(t){u[e].addHandler(t)}),this},unregister:function(e,n){var r=this.queries;if(!r.hasOwnProperty(e))return this;n?r[e].removeHandler(n):(t(this.queries[e].handlers,function(e){e.destroy()}),delete r[e])},fire:function(e){var t=this.queries,n;for(n in t)t.hasOwnProperty(n)&&t[n].assess();return this},listen:function(e){function r(r){var i;t(r,function(t){i&&clearTimeout(i),i=setTimeout(function(){n.fire(t)},e)})}var t=window.addEventListener||window.attachEvent,n=this;return e=e||500,this.listening?this:(n.fire(),r("resize"),r("orientationChange"),this.listening=!0,this)}},new o}(window.matchMedia);

(function(a){a.fn.zAccordion=function(e){var d={timeout:6000,width:null,slideWidth:null,tabWidth:null,height:null,startingSlide:0,slideClass:null,easing:null,speed:1200,auto:true,trigger:"click",pause:true,invert:false,animationStart:function(){},animationComplete:function(){},buildComplete:function(){},errors:false},c={displayError:function(g,f){if(window.console&&f){console.log("zAccordion: "+g+".")}},findChildElements:function(f){if(f.children().get(0)===undefined){return false}else{return true}},getNext:function(g,h){var f=h+1;if(f>=g){f=0}return f},fixHeight:function(f){if((f.height===null)&&(f.slideHeight!==undefined)){f.height=f.slideHeight;return true}else{if((f.height!==null)&&(f.slideHeight===undefined)){return true}else{if((f.height===null)&&(f.slideHeight===undefined)){return false}}}},getUnits:function(f){if(f!==null){if(f.toString().indexOf("%")>-1){return"%"}else{if(f.toString().indexOf("px")>-1){return"px"}else{return"px"}}}},toInteger:function(f){if(f!==null){return parseInt(f,10)}},sizeAccordion:function(f,g){if((g.width===undefined)&&(g.slideWidth===undefined)&&(g.tabWidth===undefined)){c.displayError("width must be defined",g.errors);return false}else{if((g.width!==undefined)&&(g.slideWidth===undefined)&&(g.tabWidth===undefined)){if((g.width>100)&&(g.widthUnits==="%")){c.displayError("width cannot be over 100%",g.errors);return false}else{g.slideWidthUnits=g.widthUnits;g.tabWidthUnits=g.widthUnits;if(g.widthUnits==="%"){g.tabWidth=100/(f.children().size()+1);g.slideWidth=100-((f.children().size()-1)*g.tabWidth)}else{g.tabWidth=g.width/(f.children().size()+1);g.slideWidth=g.width-((f.children().size()-1)*g.tabWidth)}return true}}else{if((g.width===undefined)&&(g.slideWidth!==undefined)&&(g.tabWidth===undefined)){c.displayError("width must be defined",g.errors);return false}else{if((g.width===undefined)&&(g.slideWidth===undefined)&&(g.tabWidth!==undefined)){c.displayError("width must be defined",g.errors);return false}else{if((g.width!==undefined)&&(g.slideWidth===undefined)&&(g.tabWidth!==undefined)){if(g.widthUnits!==g.tabWidthUnits){c.displayError("Units do not match",g.errors);return false}else{if((g.width>100)&&(g.widthUnits==="%")){c.displayError("width cannot be over 100%",g.errors);return false}else{if((((f.children().size()*g.tabWidth)>100)&&(g.widthUnits==="%"))||(((f.children().size()*g.tabWidth)>g.width)&&(g.widthUnits==="px"))){c.displayError("tabWidth too large for accordion",g.errors);return false}else{g.slideWidthUnits=g.widthUnits;if(g.widthUnits==="%"){g.slideWidth=100-((f.children().size()-1)*g.tabWidth)}else{g.slideWidth=g.width-((f.children().size()-1)*g.tabWidth)}return true}}}}else{if((g.width!==undefined)&&(g.slideWidth!==undefined)&&(g.tabWidth===undefined)){if(g.widthUnits!==g.slideWidthUnits){c.displayError("Units do not match",g.errors);return false}else{if((g.width>100)&&(g.widthUnits==="%")){c.displayError("width cannot be over 100%",g.errors);return false}else{if(g.slideWidth>=g.width){c.displayError("slideWidth cannot be greater than or equal to width",g.errors);return false}else{if((((f.children().size()*g.slideWidth)<100)&&(g.widthUnits==="%"))||(((f.children().size()*g.slideWidth)<g.width)&&(g.widthUnits==="px"))){c.displayError("slideWidth too small for accordion",g.errors);return false}else{g.tabWidthUnits=g.widthUnits;if(g.widthUnits==="%"){g.tabWidth=(100-g.slideWidth)/(f.children().size()-1)}else{g.tabWidth=(g.width-g.slideWidth)/(f.children().size()-1)}return true}}}}}else{if((g.width===undefined)&&(g.slideWidth!==undefined)&&(g.tabWidth!==undefined)){c.displayError("width must be defined",g.errors);return false}else{if((g.width!==undefined)&&(g.slideWidth!==undefined)&&(g.tabWidth!==undefined)){c.displayError("At maximum two of three attributes (width, slideWidth, and tabWidth) should be defined",g.errors);return false}}}}}}}}},timer:function(k){var l=k.data("next")+1;if(k.data("pause")&&k.data("inside")&&k.data("auto")){try{clearTimeout(k.data("interval"))}catch(j){}}else{if(k.data("pause")&&!k.data("inside")&&k.data("auto")){try{clearTimeout(k.data("interval"))}catch(i){}k.data("interval",setTimeout(function(){k.children(k.children().get(0).tagName+":nth-child("+l+")").trigger(k.data("trigger"))},k.data("timeout")))}else{if(!k.data("pause")&&k.data("auto")){try{clearTimeout(k.data("interval"))}catch(h){}k.data("interval",setTimeout(function(){k.children(k.children().get(0).tagName+":nth-child("+l+")").trigger(k.data("trigger"))},k.data("timeout")))}}}}},b={init:function(h){var i,g=["slideWidth","tabWidth","startingSlide","slideClass","animationStart","animationComplete","buildComplete"];for(i=0;i<g.length;i+=1){if(a(this).data(g[i].toLowerCase())!==undefined){a(this).data(g[i],a(this).data(g[i].toLowerCase()));a(this).removeData(g[i].toLowerCase())}}h=a.extend(d,h,a(this).data());if(this.length<=0){c.displayError("Selector does not exist",h.errors);return false}else{if(!c.fixHeight(h)){c.displayError("height must be defined",h.errors);return false}else{if(!c.findChildElements(this)){c.displayError("No child elements available",h.errors);return false}else{if(h.speed>h.timeout){c.displayError("Speed cannot be greater than timeout",h.errors);return false}else{h.heightUnits=c.getUnits(h.height);h.height=c.toInteger(h.height);h.widthUnits=c.getUnits(h.width);h.width=c.toInteger(h.width);h.slideWidthUnits=c.getUnits(h.slideWidth);h.slideWidth=c.toInteger(h.slideWidth);h.tabWidthUnits=c.getUnits(h.tabWidth);h.tabWidth=c.toInteger(h.tabWidth);if(h.slideClass!==null){h.slideOpenClass=h.slideClass+"-open";h.slideClosedClass=h.slideClass+"-closed";h.slidePreviousClass=h.slideClass+"-previous"}if(!c.sizeAccordion(this,h)){return false}else{return this.each(function(){var q=h,p=a(this),j=[],k,f,n,l,m=-1;k=q.slideWidth-q.tabWidth;f=p.get(0).tagName;n=p.children().get(0).tagName;l=p.children().size();p.data(a.extend({},{auto:q.auto,interval:null,timeout:q.timeout,trigger:q.trigger,current:q.startingSlide,previous:m,next:c.getNext(l,q.startingSlide),slideClass:q.slideClass,inside:false,pause:q.pause}));if(q.heightUnits==="%"){q.height=(p.parent().get(0).tagName==="BODY")?q.height*0.01*a(window).height():q.height*0.01*p.parent().height();q.heightUnits="px"}p.children().each(function(s){var r,o,t;o=q.invert?o=((l-1)*q.tabWidth)-(s*q.tabWidth):s*q.tabWidth;j[s]=o;r=q.invert?((l-1)-s)*10:s*10;if(q.slideClass!==null){a(this).addClass(q.slideClass)}a(this).css({top:0,"z-index":r,margin:0,padding:0,"float":"left",display:"block",position:"absolute",overflow:"hidden",width:q.slideWidth+q.widthUnits,height:q.height+q.heightUnits});if(n==="LI"){a(this).css({"text-indent":0})}if(q.invert){a(this).css({right:o+q.widthUnits,"float":"right"})}else{a(this).css({left:o+q.widthUnits,"float":"left"})}if(s===(q.startingSlide)){a(this).css("cursor","default");if(q.slideClass!==null){a(this).addClass(q.slideOpenClass)}}else{a(this).css("cursor","pointer");if(q.slideClass!==null){a(this).addClass(q.slideClosedClass)}if((s>(q.startingSlide))&&(!q.invert)){t=s+1;p.children(n+":nth-child("+t+")").css({left:j[t-1]+k+q.widthUnits})}else{if((s<(q.startingSlide))&&(q.invert)){t=s+1;p.children(n+":nth-child("+t+")").css({right:j[t-1]+k+q.widthUnits})}}}});p.css({display:"block",height:q.height+q.heightUnits,width:q.width+q.widthUnits,padding:0,position:"relative",overflow:"hidden"});if((f==="UL")||(f==="OL")){p.css({"list-style":"none"})}p.hover(function(){p.data("inside",true);if(p.data("pause")){try{clearTimeout(p.data("interval"))}catch(o){}}},function(){p.data("inside",false);if(p.data("auto")&&p.data("pause")){c.timer(p)}});p.children().bind(q.trigger,function(){if(a(this).index()!==p.data("current")){var r,o,s,t;s=m+1;t=p.data("current")+1;if((s!==0)&&(q.slideClass!==null)){p.children(n+":nth-child("+s+")").removeClass(q.slidePreviousClass)}p.children(n+":nth-child("+t+")");if(q.slideClass!==null){p.children(n+":nth-child("+t+")").addClass(q.slidePreviousClass)}m=p.data("current");p.data("previous",p.data("current"));s=m;s+=1;p.data("current",a(this).index());t=p.data("current");t+=1;p.children().css("cursor","pointer");a(this).css("cursor","default");if(q.slideClass!==null){p.children().addClass(q.slideClosedClass).removeClass(q.slideOpenClass);a(this).addClass(q.slideOpenClass).removeClass(q.slideClosedClass)}p.data("next",c.getNext(l,a(this).index()));c.timer(p);q.animationStart();if(q.invert){p.children(n+":nth-child("+t+")").stop().animate({right:j[p.data("current")]+q.widthUnits},q.speed,q.easing,q.animationComplete)}else{p.children(n+":nth-child("+t+")").stop().animate({left:j[p.data("current")]+q.widthUnits},q.speed,q.easing,q.animationComplete)}for(r=0;r<l;r+=1){o=r+1;if(r<p.data("current")){if(q.invert){p.children(n+":nth-child("+o+")").stop().animate({right:q.width-(o*q.tabWidth)+q.widthUnits},q.speed,q.easing)}else{p.children(n+":nth-child("+o+")").stop().animate({left:j[r]+q.widthUnits},q.speed,q.easing)}}if(r>p.data("current")){if(q.invert){p.children(n+":nth-child("+o+")").stop().animate({right:(l-o)*q.tabWidth+q.widthUnits},q.speed,q.easing)}else{p.children(n+":nth-child("+o+")").stop().animate({left:j[r]+k+q.widthUnits},q.speed,q.easing)}}}return false}});if(p.data("auto")){c.timer(p)}q.buildComplete()})}}}}}},stop:function(){if(a(this).data("auto")){clearTimeout(a(this).data("interval"));a(this).data("auto",false)}},start:function(){if(!a(this).data("auto")){var f=a(this).data("next")+1;a(this).data("auto",true);a(this).children(a(this).children().get(0).tagName+":nth-child("+f+")").trigger(a(this).data("trigger"))}},trigger:function(f){if((f>=a(this).children().size())||(f<0)){f=0}f+=1;a(this).children(a(this).children().get(0).tagName+":nth-child("+f+")").trigger(a(this).data("trigger"))},destroy:function(i){var f,g,h=a(this).data("slideClass");if(i!==undefined){f=(i.removeStyleAttr!==undefined)?i.removeStyleAttr:true;g=(i.removeClasses!==undefined)?i.removeClasses:false}clearTimeout(a(this).data("interval"));a(this).children().stop().unbind(a(this).data("trigger"));a(this).unbind("mouseenter mouseleave mouseover mouseout");if(f){a(this).removeAttr("style");a(this).children().removeAttr("style")}if(g){a(this).children().removeClass(h);a(this).children().removeClass(h+"-open");a(this).children().removeClass(h+"-closed");a(this).children().removeClass(h+"-previous")}a(this).removeData();if(i!==undefined){if(i.destroyComplete!=="undefined"){if(typeof(i.destroyComplete.afterDestroy)!=="undefined"){i.destroyComplete.afterDestroy()}if(i.destroyComplete.rebuild){return b.init.apply(this,[i.destroyComplete.rebuild])}}}}};if(b[e]){return b[e].apply(this,Array.prototype.slice.call(arguments,1))}else{if(typeof e==="object"||!e){return b.init.apply(this,arguments)}else{a.error("zAccordion: "+e+" does not exist.")}}}}(jQuery));

jQuery(function($){
	
jQuery.fn.soleaSlider = function(options){
	
/* ================================================================================================ */
/* == Slider Options ============================================================================== */
/* ================================================================================================ */	
	
	var defaults = {
		              time:4000,
					  autoplay:true,
					  listControls:true,
					  arrowControls:false
					 };
	
	
	var options = jQuery.extend(defaults, options);
	
/* ================================================================================================ */
/* == Variables & Precaching ====================================================================== */
/* ================================================================================================ */	
	
	return this.each(function()
		{	
		var root = jQuery(this);
		//root.wrap('<div class="soleaSlider" />');	
		var parent = root.parent(), slider, timer,image_timer,wait,index,src,parent,im,override=false,in_animation = false,controls,root_parent,trace_len;
		 
		
		 slider = {
			 slides : root.find("li"),
			 current : null,
			 prev : null ,
			 width: root.data('width'),
			 height: root.data('height'),
			 time :root.data('time'),
			 responsive :root.data('responsive'), 
			 isResponsive:false,
			 preloading :root.data('preloading'), 
			 autoplay :root.data('autoplay'),
			 arrow_controls :root.data('arrows'), 
			 bullets_controls :root.data('bullets'), 
			 random_slides:root.data('random'), 
			 init : function() { if(slider.autoplay) image_timer = setTimeout(function(){ slider.switcher(); },slider.time);	 },
			 endeffect : function() { slider.current.find('div.desc').fadeIn('normal'); image_timer = setTimeout(function(){ slider.switcher(); },slider.time);	 },
			 show : function(){ slider.slides.find('div.desc').hide(); root.find("li").first().show();  root.css({ 'opacity':0 , 'visibility' : 'visible' }).animate({'opacity':1},'normal',function(){ parent.css('background','#ffffff'); root.find("li").first().find('div.desc').fadeIn('slow');   }); },
			 hide : function(){ root.animate({'opacity':0},'normal',function(){  jQuery(this).css('visibility' , 'hidden' ) }); }  ,
			  switcher : function(){ 
			 						
									if(slider.current.prev().length==0) slider.prev = slider.slides.last(); else slider.prev = slider.current.prev();
									
									slider.prev.removeClass('reset');
			 						slider.current.removeClass('active').addClass('reset'); 
									
									if(slider.current.next().length==0) slider.current = slider.slides.first(); else slider.current = slider.current.next();
									
									slider.current.addClass('active').hide();
									
									slider.animate();
									
									if(slider.bullets_controls) {
								    controls.removeClass('control_active'); controls.eq( slider.slides.index(slider.current) ).addClass('control_active');
									}
								  },
			 appendControls : function()
								 {
									var str = "<ul class='controls'>";
									for(var i=0;i<slider.slides.length;i++)
									str = str + "<li>"+(i+1)+"</li>";
									str = str+"</ul>";
									
									root.after(str);
									 
									controls = parent.find(".controls li");
									controls.first().addClass("control_active");
									
									controls.bind({
									click:function(){ slider.setImage(  parent.find('.controls li').index(jQuery(this) )  ); },
									mouseover:function(){ jQuery(this).toggleClass("control_hover"); },
									mouseout:function(){ jQuery(this).toggleClass("control_hover"); }
									  });
									
									var offset = 40;
								
									  
									parent.find(".controls").css({ "left" : root.width() - ( root.width()/2 + parent.find(".controls").width()/2 + offset )   });
									
								 }	,
			  appendArrows : function appendarrowControls()
								{
									
									var prev = jQuery("<a href='#'></a>").addClass('q-prev');
									parent.append(prev);
									var next = jQuery("<a href='#'></a>").addClass('q-next');
									parent.append(next);
									
									
									parent.find(".q-next").bind("click",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index + 1;
										 
										 if(index>slider.slides.length-1)  index = 0;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});
									
									parent.find(".q-prev").bind("click",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index - 1;

										 
										 if(index==-1)  index = slider.slides.length -1;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});	
									
								} 	,
				setImage :   function(index)
								{  
								
								    if(parent.find(".disblock").is(":animated") ) return;
								    if(index == slider.slides.index(slider.current) ) return;
									
									clearTimeout(image_timer); // Manual Override...
									
									if(slider.bullets_controls)  {
									controls.removeClass('control_active'); controls.eq(index).addClass('control_active');
									}
									
									root.find('li').removeClass("reset active");
									
									
									
									slider.current.addClass("reset");
									slider.prev = slider.current;
									
									slider.current = slider.slides.eq(index).addClass("active");
									slider.current.hide();
									slider.animate();
									
								
								},
				animate : function()
							{
								var choice =  Math.floor(Math.random()*9);
								
								if(slider.isResponsive==true) choice = 0;
								root.find('div.desc').hide();
								switch(choice)
								{
									case 0 : slider.current.fadeIn('slow',function(){   slider.endeffect(); }); break;
									case 1 : // == Vertical Fade In ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									
									w = 75;
									h = slider.height;
									var sparent = slider.current.find('div.image-wrap');
									
									
									
									var css,i =0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:w,
													height:h,
													'background-image':'url('+img+')',
													zIndex:25,
													opacity:0, top:0 
													}
														}).addClass('disblock');
									
								
									
									while(i<slider.width)
									 {
											sparent.append(block.clone().css({left:i ,backgroundPosition:-i+"px 0px" }));
											i = i + w; 
									 }
									
										
									 
									sparent.find('div.disblock').each(function(i){
										jQuery(this).delay(i*110).animate({opacity:1,width:i*4+w},{duration:400,easing:'easeInSine'});
										}); 
									 
								    var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
								 break;
								 case 2 : // == Horizontal Fade In ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									
									w = slider.width;
									h = 70;
									sparent = slider.current.find('div.image-wrap');;
									
									
									
									var css,i =0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:w,
													height:h,
													'background-image':'url('+img+')',
													zIndex:25,
													opacity:0, left:0 
													}
														}).addClass('disblock');
									
								
									
									while(i<slider.width)
									 {
											sparent.append(block.clone().css({top:i ,backgroundPosition:"0px "+-i+"px" }));
											i = i + h; 
									 }
									
										
									 
									sparent.find('div.disblock').each(function(i){
										jQuery(this).delay(i*70).animate({opacity:1},{duration:500,easing:'easeInSine'});
										}); 
									 
								    var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
									break; 	
									case 3 : // == Strip Half Fade In ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									
									w = 75;
									h = slider.height;
									sparent = slider.current.find('div.image-wrap');;
									
									
									
									var css,i =0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:w,
													height:h/2,
													'background-image':'url('+img+')',
													zIndex:25,
													opacity:0 
													}
														}).addClass('disblock');
									
								
									
									counter = 30;
									while(i<slider.width)
										 {
											j=0;
											while(j<h)
											{
												if(j==0)

												css ={left:i,top:j ,backgroundPosition:-i+"px "+(-j)+"px" ,marginTop: -(h/2)};
												else
												css ={left:i,top:j ,backgroundPosition:-i+"px "+(-j)+"px" ,marginTop: h};
												sparent.append(block.clone().css(css).delay(counter).animate({opacity:1,marginTop:0},{duration: 700, easing:'easeOutBack'}));
												j = j + h/2;
												counter = counter + 45;
											}
											i = i + w;
										 }
									
							
									 
								    var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
									break; 	
									case 4 : // == Cube Grow In ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									sparent = slider.current.find('div.image-wrap');;
									w = 95;
									h = 95;
									
									var css,i =0,j=0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:0,
													height:0,
													'background-image':'url('+img+')',
													zIndex:25
													}
														}).addClass('disblock');
									
								
									
									counter = 30;
									 while(i<slider.width)
									 {
										
										j=0;
										while(j<slider.height)
										{
											
											
											sparent.append( block.clone().css({left:i ,top:j,backgroundPosition:-i+"px "+-j+"px" }).delay(counter).animate({height:h,width:w},600));
										j = j + h; counter = counter + 50;
										}
										
										i = i + w;
									 }
									
							
									 
								    var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
									break;
									case 5 : // == Cube Grow In ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									sparent = slider.current.find('div.image-wrap');;
									w = 95;
									h = 95;
									
									var css,i =0,j=0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:0,
													height:0,
													marginTop:h/2,
													marginLeft: w/2,
													'background-image':'url('+img+')',
													zIndex:25
													}
														}).addClass('disblock');
									
								
									
									counter = 30;
									 while(i<slider.width)
									 {
										
										j=0;
										while(j<slider.height)
										{
											
											
											sparent.append( block.clone().css({left:i ,top:j,backgroundPosition:-i+"px "+-j+"px" }).delay(counter).animate({height:h,width:w,marginTop:0,marginLeft:0},600));
										j = j + h; counter = counter + 50;
										}
										
										i = i + w;
									 }
									
							
									 
								    var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
									break;
									case 6 : // == Horizontal Stripes Slide Down ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									sparent = slider.current.find('div.image-wrap');;
									w = slider.width;
									h = 75;
									
									var css,i =0,j=0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:w,
													height:0,
													'background-image':'url('+img+')',
													zIndex:25,
													left:0
													}
														}).addClass('disblock');
									
								
									
									counter = 30;
									while(j<slider.height)
										{
										sparent.append( block.clone().css({top:j,backgroundPosition:"0px "+-j+"px" }).delay(counter).animate({height:h},600));
										j = j + h; counter = counter + 50;
										}
									
							
									 
								    var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
									break;	
									case 7 : // == Horizontal Stripes Fade In ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									sparent = slider.current.find('div.image-wrap');;
									w = 75;
									h = slider.height;
									
									var css,i =0,j=0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:0,
													height:h,
													'background-image':'url('+img+')',
													zIndex:25,
													top:0
													}
														}).addClass('disblock');
									
								
									
									counter = 30;
									while(j<slider.width)
										{
										sparent.append( block.clone().css({left:j,backgroundPosition: -j+"px 0px" }).delay(counter).animate({width:w},600));
										j = j + w; counter = counter + 50;
										}
									
							
									 
								    var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
									break;
								    case 8 : // == Horizontal Expand Width Fade In ~~ =====================
									
									slider.current.find('img').hide(); 
									slider.current.show();
									img = slider.current.find('img').attr('src'); 
									sparent = slider.current.find('div.image-wrap');;
									w = 75;
									h = slider.height;
									
									var css,i =0,j=0; 
									block = jQuery("<div />",{
												css:{
													position:"absolute",
													width:w*3,
													height:h,
													'background-image':'url('+img+')',
													zIndex:25,
													top:0,
													opacity:0
													}
														}).addClass('disblock');
									
								
									
									counter = 30;
									while(j<slider.width)
										{
										sparent.append( block.clone().css({left:j,backgroundPosition: -j+"px 0px" }).delay(counter).animate({width:w,opacity:1},600));
										j = j + w; counter = counter + 50;
										}
									
							
									 
									var	wait = setInterval(function() {
										if( ! sparent.find(".disblock").is(":animated") ) {
											clearInterval(wait);
											slider.current.find('img').show(); 
											sparent.find('div.disblock').remove();
										   slider.endeffect();
										}
									}, 40);
									
									break;
																		
								} // End of switch
								
									
								
							},
				resize : function(h,w, maxh, maxw) {
						  var ratio = maxh/maxw;
						  if (h/w > ratio){
							 // height is the problem
							if (h > maxh){
							  w = Math.round(w*(maxh/h));
							  h = maxh;
							}
						  } else if (h/w < ratio) {
							// width is the problem
							if (w > maxh){
							  h = Math.round(h*(maxw/w));
							  w = maxw;
							}
						  } 
					
						  return [h,w];
						}	,
				
				scale : function(h,w, maxh, maxw) {
						  var ratio = maxh/maxw;
						  if (h/w < ratio) {
							// width is the problem
							if (w >= maxh){
							  h = Math.round(maxh*(w/maxw));
							  w = w;
							}
						 
						  
						  } 
						 
						  return [h,w];
						},			
				touchevents : function(){
					
					slider.slides.live("swipeleft",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index + 1;
									
										 if(index>slider.slides.length-1)  index = 0;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});
									
									slider.slides.live("swiperight",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index - 1;

										 
										 if(index==-1)  index = slider.slides.length -1;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});	
					
					} ,		
				responsive : function(){
					
					  if(parent.parent().width()<slider.width  ) {	 
						
						if(trace_len>=jQuery(window).width())
						{
							temp = slider.resize(slider.height,slider.width,slider.height,parent.parent().width());
							if(temp[1]>parent.parent().width())
							{
								 temp[1] = parent.parent().width() ;
								// temp[0] = slider.height * ( parent.parent().width() / temp[1] ) ;
							}
						}
						else
						temp = slider.scale(parent.height(),parent.parent().width(),slider.height,slider.width);
						
						
						
						parent.find(".controls").css({ "left" : temp[1] - ( temp[1]/2 + parent.find(".controls").width()/2 ) -10  });
			
						  root.css({
							  "width" : temp[1],
							  "height": temp[0]
							  
							  });
						  parent.css({
							  "width" : temp[1],
							  "height": temp[0]
							  
							  });	
					   }
					 
					   else
					   {
						   root.css({ width:slider.width , height:slider.height }); 
						   parent.css({ width:slider.width , height:slider.height }); 
						   
						   parent.find(".controls").css({ "left" : slider.width - ( slider.width/2 + parent.find(".controls").width()/2 ) -10  });
					   }
					   
					   trace_len = jQuery(window).width();
					
					}		
										
			}
		slider.current = slider.slides.first().toggleClass('active');
		slider.prev = slider.slides.last().toggleClass('reset');
		parent.css('overflow','visible');
		root.css({ width:slider.width , height:slider.height });  parent.css({ width:slider.width , height:slider.height });
		
		if(slider.preloading){
			jQuery(window).load(function(){   slider.show();
		   
		   if(slider.slides.length>1)
		   slider.init(); 
		   })
		}
		else  {
		   slider.show();
		    if(slider.slides.length>1)
		   slider.init();
		}
	
	if(slider.slides.length>1) {	
		if(slider.bullets_controls) slider.appendControls();
		if(slider.arrow_controls) slider.appendArrows();
 	   
		
	
		 slider.touchevents();
		root.find("li").bind('click',function() { clearTimeout(image_timer); });
	}
		if(slider.responsive)
		{
			trace_len = jQuery(window).width();
			 parent.addClass('isResponsive');
			 
			 jQuery(window).resize(function(){
			
			   	 
				  slider.responsive();
				 
				  });
			 slider.responsive();
		}	
		
		 
		 	
		});
	
	};
});


jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});



	
jQuery(function($){
	
jQuery.fn.qSlider = function(options){
	
/* ================================================================================================ */
/* == Slider Options ============================================================================== */
/* ================================================================================================ */	
	
	var defaults = {
		              time:4000,
					  autoplay:true,
					  listControls:true,
					  arrowControls:false
					 };
	
	
	var options = jQuery.extend(defaults, options);
	
/* ================================================================================================ */
/* == Variables & Precaching ====================================================================== */
/* ================================================================================================ */	
	
	return this.each(function()
		{	
		var root = jQuery(this);
		//root.wrap('<div class="qSlider" />');	
		var parent = root.parent(),  slider, timer,image_timer,wait,index,src,parent,im,override=false,in_animation = false,controls,root_parent,trace_len;
		 var bgc = root.css('background-color');
		  root.find('.desc').each(function(){
				  
				   if(jQuery(this).find('h2').length>0) {
				  jQuery(this).find('h2').data('top', jQuery(this).find('h2').position().top);
				  jQuery(this).find('h2').data('left', jQuery(this).find('h2').position().left);
				  }
				  
				  if(jQuery(this).find('div.inner-slider-content').length>0) {
				  jQuery(this).find('div.inner-slider-content').data('top', jQuery(this).find('div.inner-slider-content').position().top);
				  jQuery(this).find('div.inner-slider-content').data('left', jQuery(this).find('div.inner-slider-content').position().left);
				  }
				 
				 });
		
		 slider = {
			 slides : root.find("li").hide(),
			 current : null,
			 prev : null ,
			 width: root.data('width'),
			 height: root.data('height'),
			 time :root.data('time'),
			 responsive :root.data('responsive'), 
			 preloading :root.data('preloading'), 
			 autoplay :root.data('autoplay'),
			 arrow_controls :root.data('arrows'), 
			 bullets_controls :root.data('bullets'), 
			 thumbs :root.data('thumbs'),
			 random_slides:root.data('random'), 
			 init : function() { if(slider.autoplay) image_timer = setInterval(function(){ slider.switcher(); },slider.time);	 },
			 show : function(){ slider.slides.find('div.desc').hide(); root.find("li").first().show();  root.css({ 'opacity':0 , 'visibility' : 'visible' }).animate({'opacity':1},'normal',function(){  root.find("li").first().find('div.desc').fadeIn('slow');   });  },
			 hide : function(){ root.animate({'opacity':0},'normal',function(){  jQuery(this).css('visibility' , 'hidden' ) }); }  ,
			 switcher : function(){ 
			 						
									if(slider.current.prev().length==0) slider.prev = slider.slides.last(); else slider.prev = slider.current.prev();
									
									slider.prev.removeClass('reset');
			 						slider.current.removeClass('active').addClass('reset'); 
									
									slider.current.fadeOut('normal');
									
									if(slider.current.next().length==0) slider.current = slider.slides.first(); else slider.current = slider.current.next();
									
									slider.current.addClass('active').hide();
									
									slider.animate();
									
									if(slider.bullets_controls) {
								    controls.removeClass('control_active'); controls.eq( slider.slides.index(slider.current) ).addClass('control_active');
									}
								  },
			 appendControls : function()
								 {
								var str = '';
									// console.log(slider.thumbs);
									if(slider.thumbs){
										 
										str = "<ul class='thumbs-controls controls'>"; 
										for(var i=0;i<slider.slides.length;i++)
										str = str + "<li><img src='"+slider.slides.eq(i).find('img').attr('src')+"' alt='thumb' /></li>";
										str = str+"</ul>";
									}
									else
									{
										var str = "<ul class='controls'>"; 
										for(var i=0;i<slider.slides.length;i++)
										str = str + "<li>"+(i+1)+"</li>";
										str = str+"</ul>";
								   }
									
									
									root.after(str);
									 
									controls = parent.find(".controls li");
									controls.first().addClass("control_active");
									
									controls.bind({
									click:function(){ slider.setImage(  parent.find('.controls li').index(jQuery(this) )  ); },
									mouseover:function(){ jQuery(this).toggleClass("control_hover"); },
									mouseout:function(){ jQuery(this).toggleClass("control_hover"); }
									  });
									 
									
									// parent.find(".controls").css({ "left" : slider.width - ( slider.width/2 + parent.find(".controls").width()/2 ) -10  });
									
								 }	,
			  appendArrows : function appendarrowControls()
								{
									var prev = jQuery("<a href='#'></a>").addClass('q-prev');
									parent.append(prev);
									var next = jQuery("<a href='#'></a>").addClass('q-next');
									parent.append(next);
									
									
									parent.find(".q-next").bind("click",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index + 1;
										 
										 if(index>slider.slides.length-1)  index = 0;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});
									
									parent.find(".q-prev").bind("click",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index - 1;

										 
										 if(index==-1)  index = slider.slides.length -1;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});	
									
								} 	,
				setImage :   function(index)
								{  
								    if(index == slider.slides.index(slider.current) ) return;
									
									if(slider.bullets_controls) {
									controls.removeClass('control_active'); controls.eq(index).addClass('control_active');
									}
									
									slider.slides.removeClass("reset active");
									
									clearTimeout(image_timer); // Manual Override...
									
									slider.current.addClass("reset");
									slider.current.fadeOut('normal');
									slider.prev = slider.current;
									
									slider.current = slider.slides.eq(index).addClass("active");
									
									slider.animate();
									
								
								},
				animate : function()
							{
								root.find('div.desc').hide();
								slider.current.fadeIn('slow',function(){  
								if(jQuery('.inStage').length>0) slider.parallex(slider.current.find('div.desc'));
								else jQuery(slider.current.find('div.desc')).fadeIn('normal');
								
								 });
									
								
							},
				parallex : function(obj)
				{
				
				//obj.css('visibility','visible').animate({opacity:1},'normal'); return;
				
					var o =  Math.floor(Math.random()*6);
					var title = obj.find('h2');
					var desc = obj.find('div.inner-slider-content');
				    
					var tx = title.data('left');
					var ty = title.data('top');
					
					var dx = desc.data('left');
					var dy = desc.data('top');
				   
				   if(title.css('position')=="relative") { tx = 0; ty =0; }
				    if(desc.css('position')=="relative") { dx = 0; dy =0; }
				  title.removeAttr('style');
				  desc.removeAttr('style');
				 
				   switch(o)
				   {
					   
					   case 0 :	
								obj.fadeIn('normal');
								
								title.css({ "left":-jQuery(window).width(),"top":ty });
								desc.css({ "left":-jQuery(window).width(),"top":dy });
								
								title.delay(100).animate({left:tx},{duration:800, easing:'easeOutBack' });
								desc.delay(300).animate({left:dx},{duration:800, easing:'easeOutBack' });
								
								break;
				 case 1 :	 
					          	obj.fadeIn('normal');
								
								title.css({ "left":jQuery(window).width(),"top":ty });
								desc.css({ "left":jQuery(window).width(),"top":dy });
								
								title.delay(100).animate({left:tx},{duration:800, easing:'easeOutBack' });
								desc.delay(300).animate({left:dx},{duration:800, easing:'easeOutBack' });
								break;
								
					  case 2 :		obj.fadeIn('normal');
								
								title.css({"top":-slider.height,"left":tx });
								desc.css({"top":-slider.height,"left":dx });
								
								title.delay(100).animate({top:ty},{duration:800, easing:'easeOutBack' });
								desc.delay(300).animate({top:dy},{duration:800, easing:'easeOutBack' });
								break;
								
					 case 3 :	 	obj.fadeIn('normal');
								
								title.css({ "opacity":0 , "top":ty , "left" : tx });
								desc.css({"top":-slider.height,"left":dx });
								
								if(desc.length>0)
								desc.delay(300).animate({top:dy},{duration:1200, easing:'easeOutElastic' , complete : function(){
									
									title.delay(100).animate({opacity:1},{duration:800, easing:'easeOutSine' });
									
									} });
								else
								title.delay(100).animate({opacity:1},{duration:800, easing:'easeOutSine' });	
								break;		
					 case 4 :		obj.fadeIn('normal');
								
								title.css({"top":slider.height,"left":tx });
								desc.css({"top":slider.height,"left":dx });
								
								title.delay(100).animate({top:ty},{duration:1100, easing:'easeOutElastic' });
								desc.delay(100).animate({top:dy},{duration:1100, easing:'easeOutElastic' });
								break; 
					 case 5 :	 	obj.fadeIn('normal');
								
								title.css({ "left":jQuery(window).width(),"top":ty });
								desc.css({ "left":jQuery(window).width(),"top":dy });
								
								title.delay(100).animate({left:tx},{duration:500, easing:'easeOutSine' });
								desc.delay(300).animate({left:dx},{duration:500, easing:'easeOutSine' });
								break;	
					   }
					   
					  
					   
				},				
				resize : function(h,w, maxh, maxw) {
						  var ratio = maxh/maxw;
						  if (h/w > ratio){
							 // height is the problem
							if (h > maxh){
							  w = Math.round(w*(maxh/h));
							  h = maxh;
							}
						  } else if (h/w < ratio) {
							// width is the problem
							if (w > maxh){
							  h = Math.round(h*(maxw/w));
							  w = maxw;
							}
						  } 
					
						  return [h,w];
						}	,
				
				scale : function(h,w, maxh, maxw) {
						  var ratio = maxh/maxw;
						  if (h/w < ratio) {
							// width is the problem
							if (w >= maxh){
							  h = Math.round(maxh*(w/maxw));
							  w = w;
							}
						 
						  
						  } 
						 
						  return [h,w];
						},	
				touchevents : function(){
					
					slider.slides.live("swipeleft",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index + 1;
									
										 if(index>slider.slides.length-1)  index = 0;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});
									
									slider.slides.live("swiperight",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index - 1;

										 
										 if(index==-1)  index = slider.slides.length -1;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});	
					
					} ,		
				responsive : function(){
					
					  if(parent.parent().width()<slider.width  ) {	 
						
						if(trace_len>=jQuery(window).width())
						{
							temp = slider.resize(slider.height,slider.width,slider.height,parent.parent().width());
							if(temp[1]>parent.parent().width())
							{
								 temp[1] = parent.parent().width() ;
								// temp[0] = slider.height * ( parent.parent().width() / temp[1] ) ;
							}
						}
						else
						temp = slider.scale(parent.height(),parent.parent().width(),slider.height,slider.width);
						
						
						
						parent.find(".controls").css({ "left" : temp[1] - ( temp[1]/2 + parent.find(".controls").width()/2 ) -10  });
			
						  root.css({
							  "width" : temp[1],
							  "height": temp[0]
							  
							  });
						  parent.css({
							  "width" : temp[1],
							  "height": temp[0]
							  
							  });	
					   }
					 
					   else
					   {
						   root.css({ width:slider.width , height:slider.height }); 
						   parent.css({ width:slider.width , height:slider.height }); 
						   
						   parent.find(".controls").css({ "left" : slider.width - ( slider.width/2 + parent.find(".controls").width()/2 ) -10  });
					   }
					   
					   trace_len = jQuery(window).width();
					
					}		
										
			}
		slider.current = slider.slides.first().toggleClass('active');
		slider.prev = slider.slides.last().toggleClass('reset');
		parent.css('overflow','visible');
		root.css({ width:slider.width , height:slider.height });  parent.css({ width:slider.width , height:slider.height });
		
		if(slider.preloading){
			jQuery(window).load(function(){   slider.show();
		   
		   if(slider.slides.length>1)
		   slider.init(); 
		   })
		}
		else  {
		   slider.show();
		    if(slider.slides.length>1)
		   slider.init();
		}
	
	if(slider.slides.length>1) {	
		if(slider.bullets_controls) slider.appendControls();
		if(slider.arrow_controls) slider.appendArrows();
 	   
		
	
		 slider.touchevents();
		root.find("li").bind('click',function() { clearTimeout(image_timer); });
	}
		if(slider.responsive)
		{
			trace_len = jQuery(window).width();
			 parent.addClass('isResponsive');
			 
			 jQuery(window).resize(function(){
			
			   	 
				  slider.responsive();
				 
				  });
			 slider.responsive();
		}	
		
		 
		 	
		});
	
	};
});

	
jQuery(function($){
	
jQuery.fn.mSlider = function(options){
	
/* ================================================================================================ */
/* == Slider Options ============================================================================== */
/* ================================================================================================ */	
	
	var defaults = {
		              time:4000,
					  autoplay:true,
					  listControls:true,
					  arrowControls:false
					 };
	
	
	var options = jQuery.extend(defaults, options);
	
/* ================================================================================================ */
/* == Variables & Precaching ====================================================================== */
/* ================================================================================================ */	
	
	return this.each(function()
		{	
		var root = jQuery(this);
		//root.wrap('<div class="qSlider" />');	
		var parent = root.parent(),  slider, timer,image_timer,wait,index,src,parent,im,override=false,in_animation = false,controls,root_parent,trace_len;
		
		
		 slider = {
			 slides : root.find("li").hide(),
			 current : null,
			 prev : null ,
			 width: root.data('width'),
			 height: root.data('height'),
			 time :root.data('time'),
			 responsive :root.data('responsive'), 
			 preloading :root.data('preloading'), 
			 autoplay :root.data('autoplay'),
			 arrow_controls :root.data('arrows'), 
			 bullets_controls :root.data('bullets'), 
			 thumbs :root.data('thumbs'),
			 random_slides:root.data('random'), 
			 init : function() { if(slider.autoplay) image_timer = setInterval(function(){ slider.switcher(); },slider.time);	 },
			 show : function(){ slider.slides.find('div.desc').hide(); root.find("li").first().show();  root.css({ 'opacity':0 , 'visibility' : 'visible' }).animate({'opacity':1},'normal',function(){  root.find("li").first().find('div.desc').fadeIn('slow');   });  },
			 hide : function(){ root.animate({'opacity':0},'normal',function(){  jQuery(this).css('visibility' , 'hidden' ) }); }  ,
			 switcher : function(){ 
			 						
									if(slider.current.prev().length==0) slider.prev = slider.slides.last(); else slider.prev = slider.current.prev();
									
									slider.prev.removeClass('reset');
			 						slider.current.removeClass('active').addClass('reset'); 
									
									slider.current.fadeOut('normal');
									
									if(slider.current.next().length==0) slider.current = slider.slides.first(); else slider.current = slider.current.next();
									
									slider.current.addClass('active').hide();
									
									slider.animate();
									
									if(slider.bullets_controls) {
								    controls.removeClass('control_active'); controls.eq( slider.slides.index(slider.current) ).addClass('control_active');
									}
								  },
			 appendControls : function()
								 {
								var str = '';
									// console.log(slider.thumbs);
									if(slider.thumbs){
										 
										str = "<ul class='thumbs-controls controls'>"; 
										for(var i=0;i<slider.slides.length;i++)
										str = str + "<li><img src='"+slider.slides.eq(i).find('img').attr('src')+"' alt='thumb' /></li>";
										str = str+"</ul>";
									}
									else
									{
										var str = "<ul class='controls'>"; 
										for(var i=0;i<slider.slides.length;i++)
										str = str + "<li>"+(i+1)+"</li>";
										str = str+"</ul>";
								   }
									
									
									root.after(str);
									 
									controls = parent.find(".controls li");
									controls.first().addClass("control_active");
									
									controls.bind({
									click:function(){ slider.setImage(  parent.find('.controls li').index(jQuery(this) )  ); },
									mouseover:function(){ jQuery(this).toggleClass("control_hover"); },
									mouseout:function(){ jQuery(this).toggleClass("control_hover"); }
									  });
									 
									
									// parent.find(".controls").css({ "left" : slider.width - ( slider.width/2 + parent.find(".controls").width()/2 ) -10  });
									
								 }	,
			  appendArrows : function appendarrowControls()
								{
									var prev = jQuery("<a href='#'></a>").addClass('q-prev');
									parent.append(prev);
									var next = jQuery("<a href='#'></a>").addClass('q-next');
									parent.append(next);
									
									
									parent.find(".q-next").bind("click",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index + 1;
										 
										 if(index>slider.slides.length-1)  index = 0;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});
									
									parent.find(".q-prev").bind("click",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index - 1;

										 
										 if(index==-1)  index = slider.slides.length -1;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});	
									
								} 	,
				setImage :   function(index)
								{  
								    if(index == slider.slides.index(slider.current) ) return;
									
									if(slider.bullets_controls) {
									controls.removeClass('control_active'); controls.eq(index).addClass('control_active');
									}
									
									slider.slides.removeClass("reset active");
									
									clearTimeout(image_timer); // Manual Override...
									
									slider.current.addClass("reset");
									
									slider.prev = slider.current;
									
									slider.current = slider.slides.eq(index).addClass("active");
									
									slider.animate();
									
								
								},
				animate : function()
							{
								root.find('div.desc').hide();
								
								slider.current.css("top",slider.height+"px");
								slider.current.show();
								
								slider.prev.animate({ top: -slider.height  },{ easing : 'easeInBack' , duration : 400 });
								slider.current.delay(300).animate({ top: 0  },{ easing : 'easeOutBack' , duration : 400 , complete : function(){
									
									slider.current.find('div.desc').fadeIn('normal');
									
									} });
									
								
							},
								
				resize : function(h,w, maxh, maxw) {
						  var ratio = maxh/maxw;
						  if (h/w > ratio){
							 // height is the problem
							if (h > maxh){
							  w = Math.round(w*(maxh/h));
							  h = maxh;
							}
						  } else if (h/w < ratio) {
							// width is the problem
							if (w > maxh){
							  h = Math.round(h*(maxw/w));
							  w = maxw;
							}
						  } 
					
						  return [h,w];
						}	,
				
				scale : function(h,w, maxh, maxw) {
						  var ratio = maxh/maxw;
						  if (h/w < ratio) {
							// width is the problem
							if (w >= maxh){
							  h = Math.round(maxh*(w/maxw));
							  w = w;
							}
						 
						  
						  } 
						 
						  return [h,w];
						},	
				touchevents : function(){
					
					slider.slides.live("swipeleft",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index + 1;
									
										 if(index>slider.slides.length-1)  index = 0;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});
									
									slider.slides.live("swiperight",function(e){
										 var index = slider.slides.index(slider.current);
										 index = index - 1;

										 
										 if(index==-1)  index = slider.slides.length -1;
										
										 slider.setImage(index);  
										 e.preventDefault();
										 
										});	
					
					} ,		
				responsive : function(){
					
					  if(parent.parent().width()<slider.width  ) {	 
						
						if(trace_len>=jQuery(window).width())
						{
							temp = slider.resize(slider.height,slider.width,slider.height,parent.parent().width());
							if(temp[1]>parent.parent().width())
							{
								 temp[1] = parent.parent().width() ;
								// temp[0] = slider.height * ( parent.parent().width() / temp[1] ) ;
							}
						}
						else
						temp = slider.scale(parent.height(),parent.parent().width(),slider.height,slider.width);
						
						
						
						parent.find(".controls").css({ "left" : temp[1] - ( temp[1]/2 + parent.find(".controls").width()/2 ) -10  });
			
						  root.css({
							  "width" : temp[1],
							  "height": temp[0]
							  
							  });
						  parent.css({
							  "width" : temp[1],
							  "height": temp[0]
							  
							  });	
					   }
					 
					   else
					   {
						   root.css({ width:slider.width , height:slider.height }); 
						   parent.css({ width:slider.width , height:slider.height }); 
						   
						   parent.find(".controls").css({ "left" : slider.width - ( slider.width/2 + parent.find(".controls").width()/2 ) -10  });
					   }
					   
					   trace_len = jQuery(window).width();
					
					}		
										
			}
		slider.current = slider.slides.first().toggleClass('active');
		slider.prev = slider.slides.last().toggleClass('reset');
		parent.css('overflow','visible');
		root.css({ width:slider.width , height:slider.height });  parent.css({ width:slider.width , height:slider.height });
		
		if(slider.preloading){
			jQuery(window).load(function(){   slider.show();
		   
		   if(slider.slides.length>1)
		   slider.init(); 
		   })
		}
		else  {
		   slider.show();
		    if(slider.slides.length>1)
		   slider.init();
		}
	
	if(slider.slides.length>1) {	
		if(slider.bullets_controls) slider.appendControls();
		if(slider.arrow_controls) slider.appendArrows();
 	   
		
	
		 slider.touchevents();
		root.find("li").bind('click',function() { clearTimeout(image_timer); });
	}
		if(slider.responsive)
		{
			trace_len = jQuery(window).width();
			 parent.addClass('isResponsive');
			 
			 jQuery(window).resize(function(){
			
			   	 
				  slider.responsive();
				 
				  });
			 slider.responsive();
		}	
		
		 
		 	
		});
	
	};
});



jQuery(function($){
	
jQuery.fn.GridWall = function(options){
	
	var root = $(this);
	var sets = root.find('div.image-set');
	var current = sets.first().addClass('active') , choice = 4;
	
	root.find('a.next').click(function(e){
		
		 sets.not(current).removeClass('active');
		 
		 root.find('ul').find('li').removeAttr('style');
		 root.find('ul').removeAttr('style');
		 
		 
		choice = Math.floor(Math.random()*3);	
		current.children('ul').each(function(i){
	
			
			switch(choice)
			 {
				case 0: $(this).delay(i*200).animate({ left: -root.width() },{duration:800, easing:'easeInBack' }); break;
				case 1: $(this).delay(i*200).animate({ opacity: 0 },{duration:800, easing:'easeInSine' }); break;
				case 2: $(this).delay(i*200).animate({ top: -root.height() },{duration:800, easing:'easeInBack' }); break;
				 case 3: 
				
				$(this).children('li').each(function(i){
					
					$(this).delay(i*100).animate({ left: -root.width() , top: -root.height() },{duration:800, easing:'easeInBack' });

					
					});
				
				 break;
				
			 }
			});
		
		var obj;
		
		if(current.next().length==0)
		current = sets.first();
		else
		current = current.next();
		
		
		
		
		 switch(choice)
			 {
			 	case 0 : current.children('ul').css("left",root.width()+"px"); break;
				case 1 : current.children('ul').css("opacity",0); break;
				case 2 : current.children('ul').css("top",root.height()+"px"); break;
				case 3:  current.find('li').css({ 'scale' : 1.6, opacity:0 }); break;
				case 4 : current.find('li').css({ "left":root.width()+"px" , "top":root.height()+"px" }); break;
				
				 
				 
			 }
		
		setTimeout(function(){
			
		current.addClass('active');
		
		
		
		current.children('ul').each(function(i){
			
			 switch(choice)
			 {
			 	case 0 :$(this).delay(i*200).animate({ left: 0 },{duration:800, easing:'easeOutBack' }); break;
				case 1: $(this).delay(i*200).animate({ opacity: 1 },{duration:800, easing:'easeInSine' }); break;
				case 2 :$(this).delay(i*200).animate({ top: 0 },{duration:800, easing:'easeOutBack' }); break;
				case 3: 
				
				$(this).children('li').each(function(i){
					
					$(this).delay(i*100).transition({
											  opacity: 1,
											  scale: 1
										  });

					
					});
				
				 break;
			   case 4: 
				
				$(this).children('li').each(function(i){
					
					$(this).delay(i*100).animate({ left: 0 , top: 0 },{duration:800, easing:'easeOutBack' });

					
					});
				
				 break;
				 	 
			 }
			});
        
		
		
		
		},500);
			
			
		e.preventDefault();
		
		});
		
		
		root.find('a.prev').click(function(e){
		
		 sets.not(current).removeClass('active');
		 
		  root.find('ul').find('li').removeAttr('style');
		 root.find('ul').removeAttr('style');
		 
		 
		 
		current.children('ul').each(function(i){
		
			
			switch(choice)
			 {
				case 0:  $(this).delay(i*200).animate({ left: root.width() },{duration:800, easing:'easeInBack' }); break;
				case 1: $(this).delay(i*200).animate({ opacity: 0 },{duration:800, easing:'easeInSine' }); break;
				case 2: $(this).delay(i*200).animate({ top: root.height() },{duration:800, easing:'easeInBack' }); break;
				case 3: 
				
				$(this).children('li').each(function(i){
					
					$(this).delay(i*100).transition({
											  opacity: 0,
											  scale: 1.6
										  });

					
					});
				
				 break;
				  case 4: 
				
				$(this).children('li').each(function(i){
					
					$(this).delay(i*100).animate({ left: root.width() , top: root.height() },{duration:800, easing:'easeInBack' });

					
					});
				
				 break;
				 
			 }
			});
		
		var obj;
		
		if(current.prev().length==0)
		current = sets.last();
		else
		current = current.prev();
		
		
		switch(choice)
			 {
			 	case 0 :current.children('ul').css("left",-root.width()+"px"); break;
				case 1 : current.children('ul').css("opacity",0); break;
				case 2 : current.children('ul').css("top",-root.height()+"px"); break;
				case 3:  current.find('li').css({ 'scale' : 1.6, opacity:0 });
				case 4 : current.find('li').css({ "left":-root.width()+"px" , "top":-root.height()+"px" }); break;
			 }
		setTimeout(function(){
			
			current.addClass('active');
		current.children('ul').each(function(i){
			
			
			switch(choice)
			 {
			 	case 0 : $(this).delay(i*200).animate({ left: 0 },{duration:800, easing:'easeOutBack' }); break;
				case 1: $(this).delay(i*200).animate({ opacity: 1 },{duration:800, easing:'easeInSine' }); break;
				case 2 :$(this).delay(i*200).animate({ top: 0 },{duration:800, easing:'easeOutBack' }); break;
				case 3: 
				
				$(this).children('li').each(function(i){
					
					$(this).delay(i*100).transition({
											  opacity: 1,
											  scale: 1
										  });

					
					});
				
				 break;
				  case 4: 
				
				$(this).children('li').each(function(i){
					
					$(this).delay(i*100).animate({ left: 0 , top: 0 },{duration:800, easing:'easeOutBack' });

					
					});
				
				 break;
			 }
			});
        
		
			},500);
			
			
		e.preventDefault();
		
		});
	
	
	
}
	
});

Number.prototype.pxToEm = String.prototype.pxToEm = function(settings){
	//set defaults
	settings = jQuery.extend({
		scope: 'body',
		reverse: false
	}, settings);
	
	var pxVal = (this == '') ? 0 : parseFloat(this);
	var scopeVal;
	var getWindowWidth = function(){
		var de = document.documentElement;
		return self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
	};	
	
	/* When a percentage-based font-size is set on the body, IE returns that percent of the window width as the font-size. 
		For example, if the body font-size is 62.5% and the window width is 1000px, IE will return 625px as the font-size. 	
		When this happens, we calculate the correct body font-size (%) and multiply it by 16 (the standard browser font size) 
		to get an accurate em value. */
				
	if (settings.scope == 'body' && jQuery.browser.msie && (parseFloat(jQuery('body').css('font-size')) / getWindowWidth()).toFixed(1) > 0.0) {
		var calcFontSize = function(){		
			return (parseFloat(jQuery('body').css('font-size'))/getWindowWidth()).toFixed(3) * 16;
		};
		scopeVal = calcFontSize();
	}
	else { scopeVal = parseFloat(jQuery(settings.scope).css("font-size")); };
			
	var result = (settings.reverse == true) ? (pxVal * scopeVal).toFixed(2) + 'px' : (pxVal / scopeVal).toFixed(2) + 'em';
	return result;
};
jQuery.fn.equalHeights = function(px) {
	if(jQuery(window).width()<767) return;
	jQuery(this).each(function(){
		var currentTallest = 0;
		jQuery(this).children().each(function(i){
			if (jQuery(this).height() > currentTallest) { currentTallest = jQuery(this).height(); }
		});
		if (!px || !Number.prototype.pxToEm) currentTallest = currentTallest.pxToEm(); //use ems unless px is specified
		// for ie6, set height since min-height isn't supported
		if (jQuery.browser.msie && jQuery.browser.version == 6.0) { jQuery(this).children().css({'height': currentTallest}); }
		jQuery(this).children().not('.title').css({'min-height': currentTallest}); 
	});
	return this;
};	
jQuery(document).ready(function(){

if( jQuery('body.login').length >0  ) { jQuery('#base-css,#theme-css-css,#color-style-css,#titanshortcodesfront-css,#titantablesfront-css').remove();  }


if( jQuery.browser.msie && jQuery.browser.version<=7)
jQuery('div.imageholder-wrapper a.hover').hide();

jQuery('body').testable();
jQuery(window).resize(function(){ jQuery('body').testable(); });

jQuery('#searchform').addClass('form-search');
jQuery('.sidebar-wrap input[type=submit]').addClass('custom-font thunder_button');

jQuery('div.wpcf7 p , .wpcf7-submit , .error-search #searchsubmit , p.form-submit input[type=submit]').addClass('custom-font');

jQuery('p.form-submit input[type=submit]').addClass('thunder_button');

jQuery('#calendar_wrap').addClass('table table-striped');

jQuery('.tagcloud a').addClass('label');
jQuery('.tagcloud a').hover(function(){ jQuery(this).addClass('label-inverse') },function(){ jQuery(this).removeClass('label-inverse') });

jQuery('#footer img[alt=RSS]').parent().remove();


jQuery('div.gridSlider').GridWall();

	
});	


/* ================================================================================== */
/* == Main Code ===================================================================== */
/* ================================================================================== */


jQuery(function($){


/* ---------------------------------------------------------------------------------- */
/* -- Variables intialization ------------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */
	
var obj,temp,i,j,k,parent,sidebar  =  jQuery(".sidebar") , content = jQuery("#main-content"), menu = jQuery("#menu-bar .menu,#top-bar .menu"),str='';

// ========== ISOTOPE ================================================================

var container = null;


jQuery('div.project-nav a.info').click(function(e){
	jQuery('div.single_portfolio_content').slideToggle('normal');
	e.preventDefault();
	});

var layout = 'masonry';

jQuery('div.gridSlider ul li').hover(function(){
	 $(this).find('span.hover-image').fadeIn('normal');
	},function(){
		
		$(this).find('span.hover-image').stop(true,true).fadeOut('normal');
		});




jQuery(window).load(function(){
	
if(!jQuery('.content').hasClass('full-width'))
	jQuery('.content').equalHeights();
	
jQuery('body').testable();	


setTimeout(function(){
	$('.blurb-wrapper .blurb-text').fadeTo('slow',1,function(){
	$('.blurb-secondary-text').fadeTo('normal',1);
	});
	},800);

 container = jQuery('.filterable .posts').isotope({
				  // options
				  itemSelector : '.filterable .posts li',
				
				  layoutMode : layout
				  });
				  
	
	 jQuery('.blog-template .posts').isotope({
				  // options
				  itemSelector : '.blog-template .posts li',
				masonry: {
    columnWidth: 340
  },
				  layoutMode : layout
				  });
				  			  
	
	});	
				  

jQuery('.portfolio-taxonomy a').click(function(){
  var selector = "."+jQuery(this).html().replace(' ','_');
  
  jQuery('.portfolio-taxonomy li').removeClass('active');
   jQuery(this).parent().addClass('active');
   
  if(jQuery(this).data('check')=="all") selector = "*";
  container.isotope({ filter: selector });
  
 
  
  return false;
});

  jQuery('.accordion-heading').click( function (e) { 
  jQuery(this).parents('div.shortcodes-accordion').find('.accordion-heading').removeClass('active');
  
  if(!jQuery(this).next().hasClass('in'))
  jQuery(this).addClass('active');
  
  e.preventDefault();
  // do something…
})

jQuery('div.accordion-body').each(function(){
	
	if( jQuery(this).hasClass('in') ) jQuery(this).prev().addClass('active');
	
	});

jQuery('.portfolio-template .posts li').hover(function(){
   
   jQuery(this).find('a.hover').stop(true,true).fadeIn('normal');
   
  },function(){
   
   jQuery(this).find('a.hover').stop(true,true).fadeOut('normal');
    
  });	


jQuery('.post-block , .latest-home-posts  .image').hover(function(){
   
   jQuery(this).find('a.hover').stop(true,true).fadeIn('normal');
   
  },function(){
   
   jQuery(this).find('a.hover').stop(true,true).fadeOut('normal');
    
  });	
  

jQuery('a.accordion-toggle').click(function(){
	jQuery(this).parents('div.shortcodes-faq').find('.accordion-heading').not(jQuery(this).parent()).removeClass('active');
	jQuery(this).parent().toggleClass('active');
	}); 
  
// ==========  SLIDER ================================================================

if(jQuery('.fadeSlider').length>0)  jQuery('.fadeSlider').qSlider();
if(jQuery('.moveSlider').length>0)  jQuery('.moveSlider').mSlider();
if(jQuery('.jquerySlider').length>0)  jQuery('.jquerySlider').soleaSlider();


if($('.accordion').length>0) {


var example = $('.accordion');
example.find('li:first').find('div.desc').fadeIn('normal');
var defaults = {
		buildComplete: function () {
			example.css('visibility', 'visible');
		},
		timeout: 2500, speed: 500 , animationStart: function () { example.find('div.desc').fadeOut('fast'); }, animationComplete: function () { jQuery(this).find('div.desc').fadeIn('normal'); },
		easing : "easeOutExpo"
	};
	function build(x) {
		var opts, current;
		if (!$.isEmptyObject(example.data())) { /* If an zAccordion is found, rebuild it with new settings. */
			example.css('visibility', 'hidden');
			current = example.data('current');
			opts = $.extend({
				startingSlide: current
			}, defaults, x);
			example.zAccordion('destroy', {
				removeStyleAttr: true,
				removeClasses: true,
				destroyComplete: {
					afterDestroy: function() {
					
					},
					rebuild: opts
				}
			});
		} else { /* If no zAccordion is found, build one from scratch. */
			example.css('visibility', 'hidden');
			opts = $.extend(defaults, x);
			example.zAccordion(opts);
		}
	}
	/* A unique Media Query is registered for each screen size. */
	enquire.register('screen and (min-width: 960px)', { /* Standard screen sizes and a default build for browsers that are unsupported. */
		match : function () {
			build({
				slideWidth: Math.round( $('.accordion').width() * 0.75 ),
				width: 960,
				height: 400
			});
		} /* The *true* value below means this media query will fire by default. */
	}, true).register('screen and (max-width: 979px)', {
		match : function () {
			build({
				slideWidth: 520,
				width: 720,
				height: 360
			});
		}
	}).register(' screen and (min-width: 768px) and (max-width: 979px)  and (orientation:portrait) ', {
		match : function () {
			build({
				slideWidth: 420,
				width: 640,
				height: 320
			});
		}
	}).register('screen and (min-width: 480px) and (max-width: 767px)', {
		match : function () {
			build({
				slideWidth: 300,
				width: 480,
				height: 250
			});
		}
	}).register('screen and (max-width: 479px)', {
		match : function () {
			build({
				slideWidth: 250,
				width: 320,
				height: 150
			});
		}
	}).listen(5);


}

// == Menu Code ==========================================================================

menu.find("li").hover(function(){
//   jQuery(this).children('.sub-menu').show();
   
   jQuery(this).children('.sub-menu').slideDown('normal');
   
  },function(){
  jQuery(this).children('.sub-menu').stop(true,true).hide(); 
  });	



jQuery("ul.top-social-icons li a,ul.social-icons li a").hover(function(){ 
   jQuery(this).children('span.def').stop(true,true).animate({opacity:0},'normal');
   jQuery(this).children('span.hov').stop(true,true).animate({opacity:1},'normal');
  },function(){
   jQuery(this).children('span.def').stop(true,true).animate({opacity:1},'normal');
   jQuery(this).children('span.hov').stop(true,true).animate({opacity:0},'normal');
  });	

var testSubtitle = false;
  
menu.children("li").each(function(){
		temp = jQuery(this);
		
		if( jQuery.trim(temp.children('a').find('span.menu-subtitle').html())!=""  )
		{
		  
			testSubtitle = true;
		}
		
		if(temp.children('ul.sub-menu').length>0)
		{
			temp.addClass("showdropdown");
			temp.find('.sub-menu').append('<span class="mg-menu-tip" style="width:'+(temp.width())+'px;"></span>');
		}
		else
		{
			temp.addClass("showdropdown");
			temp.find('.sub-menu').append('<span class="mg-menu-tip" style="width:'+(40+temp.width())+'px;left:'+temp.position().left+'px"></span>');
			
		//	console.log( temp.position().left );
			
			if(temp.find('div.sub-menu').length>0)
			temp.find('div.sub-menu').css('left',- temp.position().left);
			
		}
		
		temp.find("a").each(function(){ 
		
			if(jQuery(this).attr('href')!="#") 
			{
				if(jQuery(this).parent().hasClass('current-menu-item'))
				str = str + '<option selected="selected" value="'+jQuery(this).attr('href')+'">'+jQuery(this).html()+'</option>'; 
				else
				str = str + '<option value="'+jQuery(this).attr('href')+'">'+jQuery(this).html()+'</option>'; 
				
			}
				});	
		
		});




menu.find('li').each(function(){
	temp = jQuery(this);
	
	if(temp.children().hasClass('sub-menu'))
		{
			temp.children('a').append('<span class="hasDropdown"></span>');
		}
	
	

});
		
menu.children("li").find('div.sub-menu ul , ul.sub-menu').each(function(){  jQuery(this).find('li:last').css('borderBottom','none');  });	
jQuery('#mobile-menu').html(str);

jQuery('#mobile-menu').change(function(){
	if(jQuery(this).val()!="none")
	{
		location.href = jQuery(this).val();
	}
	});


jQuery('.testimonials .image , .events-slider .image').click(function(e) {
   temp = jQuery(this).parents('.super-parent');
   
   temp.find('.thumbnails li').removeClass('active');
 
   temp.find('.data li').removeClass('active');
   
   temp.find('.'+jQuery(this).data('key')).addClass('active');
   
   jQuery(this).parent().addClass('active');
   
   if(temp.hasClass('testimonials'))
   jQuery("div.testimonial-slider ul.data").height(jQuery("div.testimonial-slider ul.data li.active").height());
   else
   jQuery("div.events-slider ul.data").height(jQuery("div.events-slider ul.data li.active").height());
   
    e.preventDefault();
});

jQuery('.testimonial-slider .thumbnails').width( jQuery('.testimonial-slider .thumbnails').children().length * 72 );
jQuery('.events-slider .thumbnails').width( jQuery('.events-slider .thumbnails').children().length * 78 );

jQuery('#toggle-top-menu').toggle(function(e){
	
	jQuery('#top-bar').slideDown('normal');
	jQuery(this).addClass('opened');
	e.preventDefault();
	},function(e){
		jQuery('#top-bar').slideUp('normal');  jQuery(this).removeClass('opened');
	e.preventDefault();	
		});

// == Lightbox related code ===================================================================

jQuery(".lightbox").prettyPhoto();


// == Home page scrollable thumb =======================
var feature_thumb;

var factor = [];

  
  var index,capi = [];
  
  jQuery('.isScrollable .scrollable').each(function(i){ capi[i] = jQuery(this).scrollable({api:true}); factor[i] = 70; });
 
 jQuery('.isScrollable  .scrollable-next').live('click',function(e){
	 e.preventDefault();
	 
	 index = jQuery('.isScrollable').index( jQuery(this).parents('.isScrollable') ); 
	 capi[index].next(); 
	 });
 jQuery('.isScrollable  .scrollable-prev').live('click',function(e){
	 e.preventDefault();
	 index = jQuery('.isScrollable').index( jQuery(this).parents('.isScrollable') ); 
	 capi[index].prev(); 
	 });
  
  
 var pid = jQuery('a.like').data('id'), noaction = false;
if(jQuery.cookie('voted-'+pid)=="true") 
{
	jQuery('a.like').addClass('disabled');
	noaction = true;
}



 jQuery('a.like').click(function(e){
		 	 e.preventDefault();
		 if(noaction==true) return;
		 
		 jQuery.post( jQuery(this).data('url'),{ type:"vote",   id : jQuery(this).data('id')
			},function(data){
			
			jQuery.cookie("voted-"+pid, "true", { expires: 21 });
			
			jQuery('a.like').html(data);
				
		});
		 
	
		 });
		 
		    
 
/* ==================================================================== */
/* === Contact Form Settings ========================================== */
/* ==================================================================== */ 
	
	
    var valFlag = false;
	jQuery(".d_submit").click(function(e){
		
		e.preventDefault();
		obj = jQuery(this);
		valFlag = false;
		obj.parent().find("input[type=text],textarea").each(function(){
			
			if(jQuery.trim(jQuery(this).val())=="")
			{
				jQuery(this).parent().addClass("error");
			valFlag = true;
			}
			else
			jQuery(this).parent().removeClass("error");
			
			});
		
		if(valFlag) return;
	
		var msg = obj.parents(".dynamic_forms").find(".alert");
		
		var loader = jQuery(this).parents(".dynamic_forms").find(".ajax-loading-icon").fadeIn("slow");
		
		jQuery.post( obj.parent().attr("action"), { name : obj.parent().find('.qname').val(), email : obj.parent().find('.qemail').val(), msg : obj.parent().find('.qmsg').val() , notify_email : obj.parent().find(".notify_email").val()  } , function(data){
			
			if(data=="success")
			{
				loader.fadeOut("slow");
			    msg.addClass('alert-success').removeClass('alert-error').html("Your Message been sent");
			   
			}
			else
			{
				loader.fadeOut("slow");
				 msg.addClass('alert-error').removeClass('alert-success').html("Error ! Please try later. ");
				
			}
			msg.fadeIn("slow").delay(3000).fadeOut("fast");
			}  );
		
		
		
		});   

 
 
}); // End of Scope
	


(function($)
{
	jQuery.fn.testable = function(options, callback) 
	{
		if(jQuery('div.single-portfolio').length>0) {
var sdo = jQuery('#main-content').offset();

jQuery('#project-button').css({ top: sdo.top  , left: sdo.left + 40 + jQuery('#main-content').width() });
}

	


	};
	
})(jQuery);

(function(d){d.fn.kwicks=function(n){var a=d.extend({isVertical:!1,sticky:!1,defaultKwick:0,event:"mouseover",spacing:0,duration:500},n),g=a.isVertical?"height":"width",h=a.isVertical?"top":"left";return this.each(function(){container=d(this);var b=container.children("li"),f=b.eq(0).css(g).replace(/px/,"");a.max?a.min=(f*b.size()-a.max)/(b.size()-1):a.max=f*b.size()-a.min*(b.size()-1);a.isVertical?container.css({width:b.eq(0).css("width"),height:f*b.size()+a.spacing*(b.size()-1)+"px"}):container.css({width:f*
b.size()+a.spacing*(b.size()-1)+"px",height:b.eq(0).css("height")});var m=[];for(i=0;i<b.size();i++){m[i]=[];for(j=1;j<b.size()-1;j++)m[i][j]=i==j?a.isVertical?j*a.min+j*a.spacing:j*a.min+j*a.spacing:(j<=i?j*a.min:(j-1)*a.min+a.max)+j*a.spacing}b.each(function(e){var c=d(this);e===0?c.css(h,"0px"):e==b.size()-1?c.css(a.isVertical?"bottom":"right","0px"):a.sticky?c.css(h,m[a.defaultKwick][e]):c.css(h,e*f+e*a.spacing);a.sticky&&(a.defaultKwick==e?(c.css(g,a.max+"px"),c.addClass("active")):c.css(g,a.min+
"px"));c.css({margin:0,position:"absolute"});c.bind(a.event,function(){var f=[],k=[];b.stop().removeClass("active");for(j=0;j<b.size();j++)f[j]=b.eq(j).css(g).replace(/px/,""),k[j]=b.eq(j).css(h).replace(/px/,"");var l={};l[g]=a.max;var d=a.max-f[e],n=f[e]/d;c.addClass("active").animate(l,{step:function(c){var l=d!=0?c/d-n:1;b.each(function(c){c!=e&&b.eq(c).css(g,f[c]-(f[c]-a.min)*l+"px");c>0&&c<b.size()-1&&b.eq(c).css(h,k[c]-(k[c]-m[e][c])*l+"px")})},duration:a.duration,easing:a.easing})})});a.sticky||
container.bind("mouseleave",function(){var e=[],c=[];b.removeClass("active").stop();for(i=0;i<b.size();i++)e[i]=b.eq(i).css(g).replace(/px/,""),c[i]=b.eq(i).css(h).replace(/px/,"");var d={};d[g]=f;var k=f-e[0];b.eq(0).animate(d,{step:function(d){d=k!=0?(d-e[0])/k:1;for(i=1;i<b.size();i++)b.eq(i).css(g,e[i]-(e[i]-f)*d+"px"),i<b.size()-1&&b.eq(i).css(h,c[i]-(c[i]-(i*f+i*a.spacing))*d+"px")},duration:a.duration,easing:a.easing})})})}})(jQuery);

(function(d){function h(e,b){var a=d(b);return a.length<2?a:e.parent().find(b)}function g(e,b){var a=this,o=e.add(a),f=e.children(),l=0,g=b.vertical;b.next=d(e).find(".next");b.prev=d(e).find(".prev");j||(j=a);f.length>1&&(f=d(b.items,e));if(b.size>1)b.circular=false;d.extend(a,{getConf:function(){return b},getIndex:function(){return l},getSize:function(){return a.getItems().size()},getNaviButtons:function(){return m.add(n)},getRoot:function(){return e},getItemWrap:function(){return f},getItems:function(){return f.find(b.item).not("."+
b.clonedClass)},move:function(c,b){return a.seekTo(l+c,b)},next:function(c){return a.move(b.size,c)},prev:function(c){return a.move(-b.size,c)},begin:function(c){return a.seekTo(0,c)},end:function(c){return a.seekTo(a.getSize()-1,c)},focus:function(){return j=a},addItem:function(c){c=d(c);b.circular?(f.children().last().before(c),f.children().first().replaceWith(c.clone().addClass(b.clonedClass))):(f.append(c),n.removeClass("disabled"));o.trigger("onAddItem",[c]);return a},seekTo:function(c,i,e){c.jquery||
(c*=1);if(b.circular&&c===0&&l==-1&&i!==0)return a;if(!b.circular&&c<0||c>a.getSize()||c<-1)return a;var k=c;c.jquery?c=a.getItems().index(c):k=a.getItems().eq(c);var h=d.Event("onBeforeSeek");if(!e&&(o.trigger(h,[c,i]),h.isDefaultPrevented()||!k.length))return a;k=g?{top:-k.position().top}:{left:-k.position().left};l=c;j=a;if(i===void 0)i=b.speed;f.animate(k,i,b.easing,e||function(){o.trigger("onSeek",[c])});return a}});d.each(["onBeforeSeek","onSeek","onAddItem"],function(c,i){d.isFunction(b[i])&&
d(a).bind(i,b[i]);a[i]=function(c){c&&d(a).bind(i,c);return a}});if(b.circular){var q=a.getItems().slice(-1).clone().prependTo(f),r=a.getItems().eq(1).clone().appendTo(f);q.add(r).addClass(b.clonedClass);a.onBeforeSeek(function(c,b,d){if(!c.isDefaultPrevented())if(b==-1)return a.seekTo(q,d,function(){a.end(0)}),c.preventDefault();else b==a.getSize()&&a.seekTo(r,d,function(){a.begin(0)})});var p=e.parents().add(e).filter(function(){if(d(this).css("display")==="none")return true});p.length?(p.show(),
a.seekTo(0,0,function(){}),p.hide()):a.seekTo(0,0,function(){})}var m=h(e,b.prev).click(function(c){c.stopPropagation();a.prev()}),n=h(e,b.next).click(function(c){c.stopPropagation();a.next()});b.circular||(a.onBeforeSeek(function(c,d){setTimeout(function(){c.isDefaultPrevented()||(m.toggleClass(b.disabledClass,d<=0),n.toggleClass(b.disabledClass,d>=a.getSize()-1))},1)}),b.initialIndex||m.addClass(b.disabledClass));a.getSize()<2&&m.add(n).addClass(b.disabledClass);b.mousewheel&&d.fn.mousewheel&&e.mousewheel(function(c,
d){if(b.mousewheel)return a.move(d<0?1:-1,b.wheelSpeed||50),false});if(b.touch){var s,t;f[0].ontouchstart=function(a){a=a.touches[0];s=a.clientX;t=a.clientY};f[0].ontouchmove=function(c){if(c.touches.length==1&&!f.is(":animated")){var b=c.touches[0],d=s-b.clientX,b=t-b.clientY;a[g&&b>0||!g&&d>0?"next":"prev"]();c.preventDefault()}}}b.keyboard&&d(document).bind("keydown.scrollable",function(c){if(b.keyboard&&!c.altKey&&!c.ctrlKey&&!c.metaKey&&!d(c.target).is(":input")&&!(b.keyboard!="static"&&j!=a)){var e=
c.keyCode;if(g&&(e==38||e==40))return a.move(e==38?-1:1),c.preventDefault();if(!g&&(e==37||e==39))return a.move(e==37?-1:1),c.preventDefault()}});b.initialIndex&&a.seekTo(b.initialIndex,0,function(){})}d.tools=d.tools||{version:"@VERSION"};d.tools.scrollable={conf:{activeClass:"active",circular:false,clonedClass:"cloned",disabledClass:"disabled",easing:"swing",initialIndex:0,item:"> *",items:".items",keyboard:true,mousewheel:false,next:".next",prev:".prev",size:1,speed:400,vertical:false,touch:true,
wheelSpeed:0}};var j;d.fn.scrollable=function(e){var b=this.data("scrollable");if(b)return b;e=d.extend({},d.tools.scrollable.conf,e);this.each(function(){b=new g(d(this),e);d(this).data("scrollable",b)});return e.api?b:this}})(jQuery);
(function(d){var h=d.tools.scrollable;h.autoscroll={conf:{autoplay:true,interval:3E3,autopause:true}};d.fn.autoscroll=function(g){typeof g=="number"&&(g={interval:g});var j=d.extend({},h.autoscroll.conf,g),e;this.each(function(){function b(){f=setTimeout(function(){a.next()},j.interval)}var a=d(this).data("scrollable"),g=a.getRoot(),f,h=false;a&&(e=a);a.play=function(){f||(h=false,g.bind("onSeek",b),b())};a.pause=function(){f=clearTimeout(f);g.unbind("onSeek",b)};a.resume=function(){h||a.play()};
a.stop=function(){h=true;a.pause()};j.autopause&&g.add(a.getNaviButtons()).hover(a.pause,a.resume);j.autoplay&&a.play()});return j.api?e:this}})(jQuery);