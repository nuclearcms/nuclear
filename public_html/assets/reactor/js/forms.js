/*! jQuery UI - v1.12.0 - 2016-08-21
* http://jqueryui.com
* Includes: widget.js, data.js, scroll-parent.js, widgets/sortable.js, widgets/mouse.js
* Copyright jQuery Foundation and other contributors; Licensed MIT */

(function(t){"function"==typeof define&&define.amd?define(["jquery"],t):t(jQuery)})(function(t){t.ui=t.ui||{},t.ui.version="1.12.0";var e=0,i=Array.prototype.slice;t.cleanData=function(e){return function(i){var s,n,o;for(o=0;null!=(n=i[o]);o++)try{s=t._data(n,"events"),s&&s.remove&&t(n).triggerHandler("remove")}catch(a){}e(i)}}(t.cleanData),t.widget=function(e,i,s){var n,o,a,r={},h=e.split(".")[0];e=e.split(".")[1];var l=h+"-"+e;return s||(s=i,i=t.Widget),t.isArray(s)&&(s=t.extend.apply(null,[{}].concat(s))),t.expr[":"][l.toLowerCase()]=function(e){return!!t.data(e,l)},t[h]=t[h]||{},n=t[h][e],o=t[h][e]=function(t,e){return this._createWidget?(arguments.length&&this._createWidget(t,e),void 0):new o(t,e)},t.extend(o,n,{version:s.version,_proto:t.extend({},s),_childConstructors:[]}),a=new i,a.options=t.widget.extend({},a.options),t.each(s,function(e,s){return t.isFunction(s)?(r[e]=function(){function t(){return i.prototype[e].apply(this,arguments)}function n(t){return i.prototype[e].apply(this,t)}return function(){var e,i=this._super,o=this._superApply;return this._super=t,this._superApply=n,e=s.apply(this,arguments),this._super=i,this._superApply=o,e}}(),void 0):(r[e]=s,void 0)}),o.prototype=t.widget.extend(a,{widgetEventPrefix:n?a.widgetEventPrefix||e:e},r,{constructor:o,namespace:h,widgetName:e,widgetFullName:l}),n?(t.each(n._childConstructors,function(e,i){var s=i.prototype;t.widget(s.namespace+"."+s.widgetName,o,i._proto)}),delete n._childConstructors):i._childConstructors.push(o),t.widget.bridge(e,o),o},t.widget.extend=function(e){for(var s,n,o=i.call(arguments,1),a=0,r=o.length;r>a;a++)for(s in o[a])n=o[a][s],o[a].hasOwnProperty(s)&&void 0!==n&&(e[s]=t.isPlainObject(n)?t.isPlainObject(e[s])?t.widget.extend({},e[s],n):t.widget.extend({},n):n);return e},t.widget.bridge=function(e,s){var n=s.prototype.widgetFullName||e;t.fn[e]=function(o){var a="string"==typeof o,r=i.call(arguments,1),h=this;return a?this.each(function(){var i,s=t.data(this,n);return"instance"===o?(h=s,!1):s?t.isFunction(s[o])&&"_"!==o.charAt(0)?(i=s[o].apply(s,r),i!==s&&void 0!==i?(h=i&&i.jquery?h.pushStack(i.get()):i,!1):void 0):t.error("no such method '"+o+"' for "+e+" widget instance"):t.error("cannot call methods on "+e+" prior to initialization; "+"attempted to call method '"+o+"'")}):(r.length&&(o=t.widget.extend.apply(null,[o].concat(r))),this.each(function(){var e=t.data(this,n);e?(e.option(o||{}),e._init&&e._init()):t.data(this,n,new s(o,this))})),h}},t.Widget=function(){},t.Widget._childConstructors=[],t.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{classes:{},disabled:!1,create:null},_createWidget:function(i,s){s=t(s||this.defaultElement||this)[0],this.element=t(s),this.uuid=e++,this.eventNamespace="."+this.widgetName+this.uuid,this.bindings=t(),this.hoverable=t(),this.focusable=t(),this.classesElementLookup={},s!==this&&(t.data(s,this.widgetFullName,this),this._on(!0,this.element,{remove:function(t){t.target===s&&this.destroy()}}),this.document=t(s.style?s.ownerDocument:s.document||s),this.window=t(this.document[0].defaultView||this.document[0].parentWindow)),this.options=t.widget.extend({},this.options,this._getCreateOptions(),i),this._create(),this.options.disabled&&this._setOptionDisabled(this.options.disabled),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:function(){return{}},_getCreateEventData:t.noop,_create:t.noop,_init:t.noop,destroy:function(){var e=this;this._destroy(),t.each(this.classesElementLookup,function(t,i){e._removeClass(i,t)}),this.element.off(this.eventNamespace).removeData(this.widgetFullName),this.widget().off(this.eventNamespace).removeAttr("aria-disabled"),this.bindings.off(this.eventNamespace)},_destroy:t.noop,widget:function(){return this.element},option:function(e,i){var s,n,o,a=e;if(0===arguments.length)return t.widget.extend({},this.options);if("string"==typeof e)if(a={},s=e.split("."),e=s.shift(),s.length){for(n=a[e]=t.widget.extend({},this.options[e]),o=0;s.length-1>o;o++)n[s[o]]=n[s[o]]||{},n=n[s[o]];if(e=s.pop(),1===arguments.length)return void 0===n[e]?null:n[e];n[e]=i}else{if(1===arguments.length)return void 0===this.options[e]?null:this.options[e];a[e]=i}return this._setOptions(a),this},_setOptions:function(t){var e;for(e in t)this._setOption(e,t[e]);return this},_setOption:function(t,e){return"classes"===t&&this._setOptionClasses(e),this.options[t]=e,"disabled"===t&&this._setOptionDisabled(e),this},_setOptionClasses:function(e){var i,s,n;for(i in e)n=this.classesElementLookup[i],e[i]!==this.options.classes[i]&&n&&n.length&&(s=t(n.get()),this._removeClass(n,i),s.addClass(this._classes({element:s,keys:i,classes:e,add:!0})))},_setOptionDisabled:function(t){this._toggleClass(this.widget(),this.widgetFullName+"-disabled",null,!!t),t&&(this._removeClass(this.hoverable,null,"ui-state-hover"),this._removeClass(this.focusable,null,"ui-state-focus"))},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_classes:function(e){function i(i,o){var a,r;for(r=0;i.length>r;r++)a=n.classesElementLookup[i[r]]||t(),a=e.add?t(t.unique(a.get().concat(e.element.get()))):t(a.not(e.element).get()),n.classesElementLookup[i[r]]=a,s.push(i[r]),o&&e.classes[i[r]]&&s.push(e.classes[i[r]])}var s=[],n=this;return e=t.extend({element:this.element,classes:this.options.classes||{}},e),e.keys&&i(e.keys.match(/\S+/g)||[],!0),e.extra&&i(e.extra.match(/\S+/g)||[]),s.join(" ")},_removeClass:function(t,e,i){return this._toggleClass(t,e,i,!1)},_addClass:function(t,e,i){return this._toggleClass(t,e,i,!0)},_toggleClass:function(t,e,i,s){s="boolean"==typeof s?s:i;var n="string"==typeof t||null===t,o={extra:n?e:i,keys:n?t:e,element:n?this.element:t,add:s};return o.element.toggleClass(this._classes(o),s),this},_on:function(e,i,s){var n,o=this;"boolean"!=typeof e&&(s=i,i=e,e=!1),s?(i=n=t(i),this.bindings=this.bindings.add(i)):(s=i,i=this.element,n=this.widget()),t.each(s,function(s,a){function r(){return e||o.options.disabled!==!0&&!t(this).hasClass("ui-state-disabled")?("string"==typeof a?o[a]:a).apply(o,arguments):void 0}"string"!=typeof a&&(r.guid=a.guid=a.guid||r.guid||t.guid++);var h=s.match(/^([\w:-]*)\s*(.*)$/),l=h[1]+o.eventNamespace,c=h[2];c?n.on(l,c,r):i.on(l,r)})},_off:function(e,i){i=(i||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,e.off(i).off(i),this.bindings=t(this.bindings.not(e).get()),this.focusable=t(this.focusable.not(e).get()),this.hoverable=t(this.hoverable.not(e).get())},_delay:function(t,e){function i(){return("string"==typeof t?s[t]:t).apply(s,arguments)}var s=this;return setTimeout(i,e||0)},_hoverable:function(e){this.hoverable=this.hoverable.add(e),this._on(e,{mouseenter:function(e){this._addClass(t(e.currentTarget),null,"ui-state-hover")},mouseleave:function(e){this._removeClass(t(e.currentTarget),null,"ui-state-hover")}})},_focusable:function(e){this.focusable=this.focusable.add(e),this._on(e,{focusin:function(e){this._addClass(t(e.currentTarget),null,"ui-state-focus")},focusout:function(e){this._removeClass(t(e.currentTarget),null,"ui-state-focus")}})},_trigger:function(e,i,s){var n,o,a=this.options[e];if(s=s||{},i=t.Event(i),i.type=(e===this.widgetEventPrefix?e:this.widgetEventPrefix+e).toLowerCase(),i.target=this.element[0],o=i.originalEvent)for(n in o)n in i||(i[n]=o[n]);return this.element.trigger(i,s),!(t.isFunction(a)&&a.apply(this.element[0],[i].concat(s))===!1||i.isDefaultPrevented())}},t.each({show:"fadeIn",hide:"fadeOut"},function(e,i){t.Widget.prototype["_"+e]=function(s,n,o){"string"==typeof n&&(n={effect:n});var a,r=n?n===!0||"number"==typeof n?i:n.effect||i:e;n=n||{},"number"==typeof n&&(n={duration:n}),a=!t.isEmptyObject(n),n.complete=o,n.delay&&s.delay(n.delay),a&&t.effects&&t.effects.effect[r]?s[e](n):r!==e&&s[r]?s[r](n.duration,n.easing,o):s.queue(function(i){t(this)[e](),o&&o.call(s[0]),i()})}}),t.widget,t.extend(t.expr[":"],{data:t.expr.createPseudo?t.expr.createPseudo(function(e){return function(i){return!!t.data(i,e)}}):function(e,i,s){return!!t.data(e,s[3])}}),t.fn.scrollParent=function(e){var i=this.css("position"),s="absolute"===i,n=e?/(auto|scroll|hidden)/:/(auto|scroll)/,o=this.parents().filter(function(){var e=t(this);return s&&"static"===e.css("position")?!1:n.test(e.css("overflow")+e.css("overflow-y")+e.css("overflow-x"))}).eq(0);return"fixed"!==i&&o.length?o:t(this[0].ownerDocument||document)},t.ui.ie=!!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase());var s=!1;t(document).on("mouseup",function(){s=!1}),t.widget("ui.mouse",{version:"1.12.0",options:{cancel:"input, textarea, button, select, option",distance:1,delay:0},_mouseInit:function(){var e=this;this.element.on("mousedown."+this.widgetName,function(t){return e._mouseDown(t)}).on("click."+this.widgetName,function(i){return!0===t.data(i.target,e.widgetName+".preventClickEvent")?(t.removeData(i.target,e.widgetName+".preventClickEvent"),i.stopImmediatePropagation(),!1):void 0}),this.started=!1},_mouseDestroy:function(){this.element.off("."+this.widgetName),this._mouseMoveDelegate&&this.document.off("mousemove."+this.widgetName,this._mouseMoveDelegate).off("mouseup."+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(e){if(!s){this._mouseMoved=!1,this._mouseStarted&&this._mouseUp(e),this._mouseDownEvent=e;var i=this,n=1===e.which,o="string"==typeof this.options.cancel&&e.target.nodeName?t(e.target).closest(this.options.cancel).length:!1;return n&&!o&&this._mouseCapture(e)?(this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){i.mouseDelayMet=!0},this.options.delay)),this._mouseDistanceMet(e)&&this._mouseDelayMet(e)&&(this._mouseStarted=this._mouseStart(e)!==!1,!this._mouseStarted)?(e.preventDefault(),!0):(!0===t.data(e.target,this.widgetName+".preventClickEvent")&&t.removeData(e.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(t){return i._mouseMove(t)},this._mouseUpDelegate=function(t){return i._mouseUp(t)},this.document.on("mousemove."+this.widgetName,this._mouseMoveDelegate).on("mouseup."+this.widgetName,this._mouseUpDelegate),e.preventDefault(),s=!0,!0)):!0}},_mouseMove:function(e){if(this._mouseMoved){if(t.ui.ie&&(!document.documentMode||9>document.documentMode)&&!e.button)return this._mouseUp(e);if(!e.which)if(e.originalEvent.altKey||e.originalEvent.ctrlKey||e.originalEvent.metaKey||e.originalEvent.shiftKey)this.ignoreMissingWhich=!0;else if(!this.ignoreMissingWhich)return this._mouseUp(e)}return(e.which||e.button)&&(this._mouseMoved=!0),this._mouseStarted?(this._mouseDrag(e),e.preventDefault()):(this._mouseDistanceMet(e)&&this._mouseDelayMet(e)&&(this._mouseStarted=this._mouseStart(this._mouseDownEvent,e)!==!1,this._mouseStarted?this._mouseDrag(e):this._mouseUp(e)),!this._mouseStarted)},_mouseUp:function(e){this.document.off("mousemove."+this.widgetName,this._mouseMoveDelegate).off("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,e.target===this._mouseDownEvent.target&&t.data(e.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(e)),this._mouseDelayTimer&&(clearTimeout(this._mouseDelayTimer),delete this._mouseDelayTimer),this.ignoreMissingWhich=!1,s=!1,e.preventDefault()},_mouseDistanceMet:function(t){return Math.max(Math.abs(this._mouseDownEvent.pageX-t.pageX),Math.abs(this._mouseDownEvent.pageY-t.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return!0}}),t.widget("ui.sortable",t.ui.mouse,{version:"1.12.0",widgetEventPrefix:"sort",ready:!1,options:{appendTo:"parent",axis:!1,connectWith:!1,containment:!1,cursor:"auto",cursorAt:!1,dropOnEmpty:!0,forcePlaceholderSize:!1,forceHelperSize:!1,grid:!1,handle:!1,helper:"original",items:"> *",opacity:!1,placeholder:!1,revert:!1,scroll:!0,scrollSensitivity:20,scrollSpeed:20,scope:"default",tolerance:"intersect",zIndex:1e3,activate:null,beforeStop:null,change:null,deactivate:null,out:null,over:null,receive:null,remove:null,sort:null,start:null,stop:null,update:null},_isOverAxis:function(t,e,i){return t>=e&&e+i>t},_isFloating:function(t){return/left|right/.test(t.css("float"))||/inline|table-cell/.test(t.css("display"))},_create:function(){this.containerCache={},this._addClass("ui-sortable"),this.refresh(),this.offset=this.element.offset(),this._mouseInit(),this._setHandleClassName(),this.ready=!0},_setOption:function(t,e){this._super(t,e),"handle"===t&&this._setHandleClassName()},_setHandleClassName:function(){var e=this;this._removeClass(this.element.find(".ui-sortable-handle"),"ui-sortable-handle"),t.each(this.items,function(){e._addClass(this.instance.options.handle?this.item.find(this.instance.options.handle):this.item,"ui-sortable-handle")})},_destroy:function(){this._mouseDestroy();for(var t=this.items.length-1;t>=0;t--)this.items[t].item.removeData(this.widgetName+"-item");return this},_mouseCapture:function(e,i){var s=null,n=!1,o=this;return this.reverting?!1:this.options.disabled||"static"===this.options.type?!1:(this._refreshItems(e),t(e.target).parents().each(function(){return t.data(this,o.widgetName+"-item")===o?(s=t(this),!1):void 0}),t.data(e.target,o.widgetName+"-item")===o&&(s=t(e.target)),s?!this.options.handle||i||(t(this.options.handle,s).find("*").addBack().each(function(){this===e.target&&(n=!0)}),n)?(this.currentItem=s,this._removeCurrentsFromItems(),!0):!1:!1)},_mouseStart:function(e,i,s){var n,o,a=this.options;if(this.currentContainer=this,this.refreshPositions(),this.helper=this._createHelper(e),this._cacheHelperProportions(),this._cacheMargins(),this.scrollParent=this.helper.scrollParent(),this.offset=this.currentItem.offset(),this.offset={top:this.offset.top-this.margins.top,left:this.offset.left-this.margins.left},t.extend(this.offset,{click:{left:e.pageX-this.offset.left,top:e.pageY-this.offset.top},parent:this._getParentOffset(),relative:this._getRelativeOffset()}),this.helper.css("position","absolute"),this.cssPosition=this.helper.css("position"),this.originalPosition=this._generatePosition(e),this.originalPageX=e.pageX,this.originalPageY=e.pageY,a.cursorAt&&this._adjustOffsetFromHelper(a.cursorAt),this.domPosition={prev:this.currentItem.prev()[0],parent:this.currentItem.parent()[0]},this.helper[0]!==this.currentItem[0]&&this.currentItem.hide(),this._createPlaceholder(),a.containment&&this._setContainment(),a.cursor&&"auto"!==a.cursor&&(o=this.document.find("body"),this.storedCursor=o.css("cursor"),o.css("cursor",a.cursor),this.storedStylesheet=t("<style>*{ cursor: "+a.cursor+" !important; }</style>").appendTo(o)),a.opacity&&(this.helper.css("opacity")&&(this._storedOpacity=this.helper.css("opacity")),this.helper.css("opacity",a.opacity)),a.zIndex&&(this.helper.css("zIndex")&&(this._storedZIndex=this.helper.css("zIndex")),this.helper.css("zIndex",a.zIndex)),this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName&&(this.overflowOffset=this.scrollParent.offset()),this._trigger("start",e,this._uiHash()),this._preserveHelperProportions||this._cacheHelperProportions(),!s)for(n=this.containers.length-1;n>=0;n--)this.containers[n]._trigger("activate",e,this._uiHash(this));return t.ui.ddmanager&&(t.ui.ddmanager.current=this),t.ui.ddmanager&&!a.dropBehaviour&&t.ui.ddmanager.prepareOffsets(this,e),this.dragging=!0,this._addClass(this.helper,"ui-sortable-helper"),this._mouseDrag(e),!0},_mouseDrag:function(e){var i,s,n,o,a=this.options,r=!1;for(this.position=this._generatePosition(e),this.positionAbs=this._convertPositionTo("absolute"),this.lastPositionAbs||(this.lastPositionAbs=this.positionAbs),this.options.scroll&&(this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName?(this.overflowOffset.top+this.scrollParent[0].offsetHeight-e.pageY<a.scrollSensitivity?this.scrollParent[0].scrollTop=r=this.scrollParent[0].scrollTop+a.scrollSpeed:e.pageY-this.overflowOffset.top<a.scrollSensitivity&&(this.scrollParent[0].scrollTop=r=this.scrollParent[0].scrollTop-a.scrollSpeed),this.overflowOffset.left+this.scrollParent[0].offsetWidth-e.pageX<a.scrollSensitivity?this.scrollParent[0].scrollLeft=r=this.scrollParent[0].scrollLeft+a.scrollSpeed:e.pageX-this.overflowOffset.left<a.scrollSensitivity&&(this.scrollParent[0].scrollLeft=r=this.scrollParent[0].scrollLeft-a.scrollSpeed)):(e.pageY-this.document.scrollTop()<a.scrollSensitivity?r=this.document.scrollTop(this.document.scrollTop()-a.scrollSpeed):this.window.height()-(e.pageY-this.document.scrollTop())<a.scrollSensitivity&&(r=this.document.scrollTop(this.document.scrollTop()+a.scrollSpeed)),e.pageX-this.document.scrollLeft()<a.scrollSensitivity?r=this.document.scrollLeft(this.document.scrollLeft()-a.scrollSpeed):this.window.width()-(e.pageX-this.document.scrollLeft())<a.scrollSensitivity&&(r=this.document.scrollLeft(this.document.scrollLeft()+a.scrollSpeed))),r!==!1&&t.ui.ddmanager&&!a.dropBehaviour&&t.ui.ddmanager.prepareOffsets(this,e)),this.positionAbs=this._convertPositionTo("absolute"),this.options.axis&&"y"===this.options.axis||(this.helper[0].style.left=this.position.left+"px"),this.options.axis&&"x"===this.options.axis||(this.helper[0].style.top=this.position.top+"px"),i=this.items.length-1;i>=0;i--)if(s=this.items[i],n=s.item[0],o=this._intersectsWithPointer(s),o&&s.instance===this.currentContainer&&n!==this.currentItem[0]&&this.placeholder[1===o?"next":"prev"]()[0]!==n&&!t.contains(this.placeholder[0],n)&&("semi-dynamic"===this.options.type?!t.contains(this.element[0],n):!0)){if(this.direction=1===o?"down":"up","pointer"!==this.options.tolerance&&!this._intersectsWithSides(s))break;this._rearrange(e,s),this._trigger("change",e,this._uiHash());break}return this._contactContainers(e),t.ui.ddmanager&&t.ui.ddmanager.drag(this,e),this._trigger("sort",e,this._uiHash()),this.lastPositionAbs=this.positionAbs,!1},_mouseStop:function(e,i){if(e){if(t.ui.ddmanager&&!this.options.dropBehaviour&&t.ui.ddmanager.drop(this,e),this.options.revert){var s=this,n=this.placeholder.offset(),o=this.options.axis,a={};o&&"x"!==o||(a.left=n.left-this.offset.parent.left-this.margins.left+(this.offsetParent[0]===this.document[0].body?0:this.offsetParent[0].scrollLeft)),o&&"y"!==o||(a.top=n.top-this.offset.parent.top-this.margins.top+(this.offsetParent[0]===this.document[0].body?0:this.offsetParent[0].scrollTop)),this.reverting=!0,t(this.helper).animate(a,parseInt(this.options.revert,10)||500,function(){s._clear(e)})}else this._clear(e,i);return!1}},cancel:function(){if(this.dragging){this._mouseUp({target:null}),"original"===this.options.helper?(this.currentItem.css(this._storedCSS),this._removeClass(this.currentItem,"ui-sortable-helper")):this.currentItem.show();for(var e=this.containers.length-1;e>=0;e--)this.containers[e]._trigger("deactivate",null,this._uiHash(this)),this.containers[e].containerCache.over&&(this.containers[e]._trigger("out",null,this._uiHash(this)),this.containers[e].containerCache.over=0)}return this.placeholder&&(this.placeholder[0].parentNode&&this.placeholder[0].parentNode.removeChild(this.placeholder[0]),"original"!==this.options.helper&&this.helper&&this.helper[0].parentNode&&this.helper.remove(),t.extend(this,{helper:null,dragging:!1,reverting:!1,_noFinalSort:null}),this.domPosition.prev?t(this.domPosition.prev).after(this.currentItem):t(this.domPosition.parent).prepend(this.currentItem)),this},serialize:function(e){var i=this._getItemsAsjQuery(e&&e.connected),s=[];return e=e||{},t(i).each(function(){var i=(t(e.item||this).attr(e.attribute||"id")||"").match(e.expression||/(.+)[\-=_](.+)/);i&&s.push((e.key||i[1]+"[]")+"="+(e.key&&e.expression?i[1]:i[2]))}),!s.length&&e.key&&s.push(e.key+"="),s.join("&")},toArray:function(e){var i=this._getItemsAsjQuery(e&&e.connected),s=[];return e=e||{},i.each(function(){s.push(t(e.item||this).attr(e.attribute||"id")||"")}),s},_intersectsWith:function(t){var e=this.positionAbs.left,i=e+this.helperProportions.width,s=this.positionAbs.top,n=s+this.helperProportions.height,o=t.left,a=o+t.width,r=t.top,h=r+t.height,l=this.offset.click.top,c=this.offset.click.left,u="x"===this.options.axis||s+l>r&&h>s+l,d="y"===this.options.axis||e+c>o&&a>e+c,p=u&&d;return"pointer"===this.options.tolerance||this.options.forcePointerForContainers||"pointer"!==this.options.tolerance&&this.helperProportions[this.floating?"width":"height"]>t[this.floating?"width":"height"]?p:e+this.helperProportions.width/2>o&&a>i-this.helperProportions.width/2&&s+this.helperProportions.height/2>r&&h>n-this.helperProportions.height/2},_intersectsWithPointer:function(t){var e,i,s="x"===this.options.axis||this._isOverAxis(this.positionAbs.top+this.offset.click.top,t.top,t.height),n="y"===this.options.axis||this._isOverAxis(this.positionAbs.left+this.offset.click.left,t.left,t.width),o=s&&n;return o?(e=this._getDragVerticalDirection(),i=this._getDragHorizontalDirection(),this.floating?"right"===i||"down"===e?2:1:e&&("down"===e?2:1)):!1},_intersectsWithSides:function(t){var e=this._isOverAxis(this.positionAbs.top+this.offset.click.top,t.top+t.height/2,t.height),i=this._isOverAxis(this.positionAbs.left+this.offset.click.left,t.left+t.width/2,t.width),s=this._getDragVerticalDirection(),n=this._getDragHorizontalDirection();return this.floating&&n?"right"===n&&i||"left"===n&&!i:s&&("down"===s&&e||"up"===s&&!e)},_getDragVerticalDirection:function(){var t=this.positionAbs.top-this.lastPositionAbs.top;return 0!==t&&(t>0?"down":"up")},_getDragHorizontalDirection:function(){var t=this.positionAbs.left-this.lastPositionAbs.left;return 0!==t&&(t>0?"right":"left")},refresh:function(t){return this._refreshItems(t),this._setHandleClassName(),this.refreshPositions(),this},_connectWith:function(){var t=this.options;return t.connectWith.constructor===String?[t.connectWith]:t.connectWith},_getItemsAsjQuery:function(e){function i(){r.push(this)}var s,n,o,a,r=[],h=[],l=this._connectWith();if(l&&e)for(s=l.length-1;s>=0;s--)for(o=t(l[s],this.document[0]),n=o.length-1;n>=0;n--)a=t.data(o[n],this.widgetFullName),a&&a!==this&&!a.options.disabled&&h.push([t.isFunction(a.options.items)?a.options.items.call(a.element):t(a.options.items,a.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),a]);for(h.push([t.isFunction(this.options.items)?this.options.items.call(this.element,null,{options:this.options,item:this.currentItem}):t(this.options.items,this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),this]),s=h.length-1;s>=0;s--)h[s][0].each(i);return t(r)},_removeCurrentsFromItems:function(){var e=this.currentItem.find(":data("+this.widgetName+"-item)");this.items=t.grep(this.items,function(t){for(var i=0;e.length>i;i++)if(e[i]===t.item[0])return!1;return!0})},_refreshItems:function(e){this.items=[],this.containers=[this];var i,s,n,o,a,r,h,l,c=this.items,u=[[t.isFunction(this.options.items)?this.options.items.call(this.element[0],e,{item:this.currentItem}):t(this.options.items,this.element),this]],d=this._connectWith();if(d&&this.ready)for(i=d.length-1;i>=0;i--)for(n=t(d[i],this.document[0]),s=n.length-1;s>=0;s--)o=t.data(n[s],this.widgetFullName),o&&o!==this&&!o.options.disabled&&(u.push([t.isFunction(o.options.items)?o.options.items.call(o.element[0],e,{item:this.currentItem}):t(o.options.items,o.element),o]),this.containers.push(o));for(i=u.length-1;i>=0;i--)for(a=u[i][1],r=u[i][0],s=0,l=r.length;l>s;s++)h=t(r[s]),h.data(this.widgetName+"-item",a),c.push({item:h,instance:a,width:0,height:0,left:0,top:0})},refreshPositions:function(e){this.floating=this.items.length?"x"===this.options.axis||this._isFloating(this.items[0].item):!1,this.offsetParent&&this.helper&&(this.offset.parent=this._getParentOffset());var i,s,n,o;for(i=this.items.length-1;i>=0;i--)s=this.items[i],s.instance!==this.currentContainer&&this.currentContainer&&s.item[0]!==this.currentItem[0]||(n=this.options.toleranceElement?t(this.options.toleranceElement,s.item):s.item,e||(s.width=n.outerWidth(),s.height=n.outerHeight()),o=n.offset(),s.left=o.left,s.top=o.top);if(this.options.custom&&this.options.custom.refreshContainers)this.options.custom.refreshContainers.call(this);else for(i=this.containers.length-1;i>=0;i--)o=this.containers[i].element.offset(),this.containers[i].containerCache.left=o.left,this.containers[i].containerCache.top=o.top,this.containers[i].containerCache.width=this.containers[i].element.outerWidth(),this.containers[i].containerCache.height=this.containers[i].element.outerHeight();return this},_createPlaceholder:function(e){e=e||this;var i,s=e.options;s.placeholder&&s.placeholder.constructor!==String||(i=s.placeholder,s.placeholder={element:function(){var s=e.currentItem[0].nodeName.toLowerCase(),n=t("<"+s+">",e.document[0]);return e._addClass(n,"ui-sortable-placeholder",i||e.currentItem[0].className)._removeClass(n,"ui-sortable-helper"),"tbody"===s?e._createTrPlaceholder(e.currentItem.find("tr").eq(0),t("<tr>",e.document[0]).appendTo(n)):"tr"===s?e._createTrPlaceholder(e.currentItem,n):"img"===s&&n.attr("src",e.currentItem.attr("src")),i||n.css("visibility","hidden"),n},update:function(t,n){(!i||s.forcePlaceholderSize)&&(n.height()||n.height(e.currentItem.innerHeight()-parseInt(e.currentItem.css("paddingTop")||0,10)-parseInt(e.currentItem.css("paddingBottom")||0,10)),n.width()||n.width(e.currentItem.innerWidth()-parseInt(e.currentItem.css("paddingLeft")||0,10)-parseInt(e.currentItem.css("paddingRight")||0,10)))}}),e.placeholder=t(s.placeholder.element.call(e.element,e.currentItem)),e.currentItem.after(e.placeholder),s.placeholder.update(e,e.placeholder)},_createTrPlaceholder:function(e,i){var s=this;e.children().each(function(){t("<td>&#160;</td>",s.document[0]).attr("colspan",t(this).attr("colspan")||1).appendTo(i)})},_contactContainers:function(e){var i,s,n,o,a,r,h,l,c,u,d=null,p=null;for(i=this.containers.length-1;i>=0;i--)if(!t.contains(this.currentItem[0],this.containers[i].element[0]))if(this._intersectsWith(this.containers[i].containerCache)){if(d&&t.contains(this.containers[i].element[0],d.element[0]))continue;d=this.containers[i],p=i}else this.containers[i].containerCache.over&&(this.containers[i]._trigger("out",e,this._uiHash(this)),this.containers[i].containerCache.over=0);if(d)if(1===this.containers.length)this.containers[p].containerCache.over||(this.containers[p]._trigger("over",e,this._uiHash(this)),this.containers[p].containerCache.over=1);else{for(n=1e4,o=null,c=d.floating||this._isFloating(this.currentItem),a=c?"left":"top",r=c?"width":"height",u=c?"pageX":"pageY",s=this.items.length-1;s>=0;s--)t.contains(this.containers[p].element[0],this.items[s].item[0])&&this.items[s].item[0]!==this.currentItem[0]&&(h=this.items[s].item.offset()[a],l=!1,e[u]-h>this.items[s][r]/2&&(l=!0),n>Math.abs(e[u]-h)&&(n=Math.abs(e[u]-h),o=this.items[s],this.direction=l?"up":"down"));if(!o&&!this.options.dropOnEmpty)return;if(this.currentContainer===this.containers[p])return this.currentContainer.containerCache.over||(this.containers[p]._trigger("over",e,this._uiHash()),this.currentContainer.containerCache.over=1),void 0;o?this._rearrange(e,o,null,!0):this._rearrange(e,null,this.containers[p].element,!0),this._trigger("change",e,this._uiHash()),this.containers[p]._trigger("change",e,this._uiHash(this)),this.currentContainer=this.containers[p],this.options.placeholder.update(this.currentContainer,this.placeholder),this.containers[p]._trigger("over",e,this._uiHash(this)),this.containers[p].containerCache.over=1}},_createHelper:function(e){var i=this.options,s=t.isFunction(i.helper)?t(i.helper.apply(this.element[0],[e,this.currentItem])):"clone"===i.helper?this.currentItem.clone():this.currentItem;return s.parents("body").length||t("parent"!==i.appendTo?i.appendTo:this.currentItem[0].parentNode)[0].appendChild(s[0]),s[0]===this.currentItem[0]&&(this._storedCSS={width:this.currentItem[0].style.width,height:this.currentItem[0].style.height,position:this.currentItem.css("position"),top:this.currentItem.css("top"),left:this.currentItem.css("left")}),(!s[0].style.width||i.forceHelperSize)&&s.width(this.currentItem.width()),(!s[0].style.height||i.forceHelperSize)&&s.height(this.currentItem.height()),s},_adjustOffsetFromHelper:function(e){"string"==typeof e&&(e=e.split(" ")),t.isArray(e)&&(e={left:+e[0],top:+e[1]||0}),"left"in e&&(this.offset.click.left=e.left+this.margins.left),"right"in e&&(this.offset.click.left=this.helperProportions.width-e.right+this.margins.left),"top"in e&&(this.offset.click.top=e.top+this.margins.top),"bottom"in e&&(this.offset.click.top=this.helperProportions.height-e.bottom+this.margins.top)},_getParentOffset:function(){this.offsetParent=this.helper.offsetParent();var e=this.offsetParent.offset();return"absolute"===this.cssPosition&&this.scrollParent[0]!==this.document[0]&&t.contains(this.scrollParent[0],this.offsetParent[0])&&(e.left+=this.scrollParent.scrollLeft(),e.top+=this.scrollParent.scrollTop()),(this.offsetParent[0]===this.document[0].body||this.offsetParent[0].tagName&&"html"===this.offsetParent[0].tagName.toLowerCase()&&t.ui.ie)&&(e={top:0,left:0}),{top:e.top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:e.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}},_getRelativeOffset:function(){if("relative"===this.cssPosition){var t=this.currentItem.position();return{top:t.top-(parseInt(this.helper.css("top"),10)||0)+this.scrollParent.scrollTop(),left:t.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollParent.scrollLeft()}}return{top:0,left:0}},_cacheMargins:function(){this.margins={left:parseInt(this.currentItem.css("marginLeft"),10)||0,top:parseInt(this.currentItem.css("marginTop"),10)||0}},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var e,i,s,n=this.options;"parent"===n.containment&&(n.containment=this.helper[0].parentNode),("document"===n.containment||"window"===n.containment)&&(this.containment=[0-this.offset.relative.left-this.offset.parent.left,0-this.offset.relative.top-this.offset.parent.top,"document"===n.containment?this.document.width():this.window.width()-this.helperProportions.width-this.margins.left,("document"===n.containment?this.document.height()||document.body.parentNode.scrollHeight:this.window.height()||this.document[0].body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top]),/^(document|window|parent)$/.test(n.containment)||(e=t(n.containment)[0],i=t(n.containment).offset(),s="hidden"!==t(e).css("overflow"),this.containment=[i.left+(parseInt(t(e).css("borderLeftWidth"),10)||0)+(parseInt(t(e).css("paddingLeft"),10)||0)-this.margins.left,i.top+(parseInt(t(e).css("borderTopWidth"),10)||0)+(parseInt(t(e).css("paddingTop"),10)||0)-this.margins.top,i.left+(s?Math.max(e.scrollWidth,e.offsetWidth):e.offsetWidth)-(parseInt(t(e).css("borderLeftWidth"),10)||0)-(parseInt(t(e).css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left,i.top+(s?Math.max(e.scrollHeight,e.offsetHeight):e.offsetHeight)-(parseInt(t(e).css("borderTopWidth"),10)||0)-(parseInt(t(e).css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top])},_convertPositionTo:function(e,i){i||(i=this.position);var s="absolute"===e?1:-1,n="absolute"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&t.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,o=/(html|body)/i.test(n[0].tagName);return{top:i.top+this.offset.relative.top*s+this.offset.parent.top*s-("fixed"===this.cssPosition?-this.scrollParent.scrollTop():o?0:n.scrollTop())*s,left:i.left+this.offset.relative.left*s+this.offset.parent.left*s-("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():o?0:n.scrollLeft())*s}},_generatePosition:function(e){var i,s,n=this.options,o=e.pageX,a=e.pageY,r="absolute"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&t.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,h=/(html|body)/i.test(r[0].tagName);
return"relative"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&this.scrollParent[0]!==this.offsetParent[0]||(this.offset.relative=this._getRelativeOffset()),this.originalPosition&&(this.containment&&(e.pageX-this.offset.click.left<this.containment[0]&&(o=this.containment[0]+this.offset.click.left),e.pageY-this.offset.click.top<this.containment[1]&&(a=this.containment[1]+this.offset.click.top),e.pageX-this.offset.click.left>this.containment[2]&&(o=this.containment[2]+this.offset.click.left),e.pageY-this.offset.click.top>this.containment[3]&&(a=this.containment[3]+this.offset.click.top)),n.grid&&(i=this.originalPageY+Math.round((a-this.originalPageY)/n.grid[1])*n.grid[1],a=this.containment?i-this.offset.click.top>=this.containment[1]&&i-this.offset.click.top<=this.containment[3]?i:i-this.offset.click.top>=this.containment[1]?i-n.grid[1]:i+n.grid[1]:i,s=this.originalPageX+Math.round((o-this.originalPageX)/n.grid[0])*n.grid[0],o=this.containment?s-this.offset.click.left>=this.containment[0]&&s-this.offset.click.left<=this.containment[2]?s:s-this.offset.click.left>=this.containment[0]?s-n.grid[0]:s+n.grid[0]:s)),{top:a-this.offset.click.top-this.offset.relative.top-this.offset.parent.top+("fixed"===this.cssPosition?-this.scrollParent.scrollTop():h?0:r.scrollTop()),left:o-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():h?0:r.scrollLeft())}},_rearrange:function(t,e,i,s){i?i[0].appendChild(this.placeholder[0]):e.item[0].parentNode.insertBefore(this.placeholder[0],"down"===this.direction?e.item[0]:e.item[0].nextSibling),this.counter=this.counter?++this.counter:1;var n=this.counter;this._delay(function(){n===this.counter&&this.refreshPositions(!s)})},_clear:function(t,e){function i(t,e,i){return function(s){i._trigger(t,s,e._uiHash(e))}}this.reverting=!1;var s,n=[];if(!this._noFinalSort&&this.currentItem.parent().length&&this.placeholder.before(this.currentItem),this._noFinalSort=null,this.helper[0]===this.currentItem[0]){for(s in this._storedCSS)("auto"===this._storedCSS[s]||"static"===this._storedCSS[s])&&(this._storedCSS[s]="");this.currentItem.css(this._storedCSS),this._removeClass(this.currentItem,"ui-sortable-helper")}else this.currentItem.show();for(this.fromOutside&&!e&&n.push(function(t){this._trigger("receive",t,this._uiHash(this.fromOutside))}),!this.fromOutside&&this.domPosition.prev===this.currentItem.prev().not(".ui-sortable-helper")[0]&&this.domPosition.parent===this.currentItem.parent()[0]||e||n.push(function(t){this._trigger("update",t,this._uiHash())}),this!==this.currentContainer&&(e||(n.push(function(t){this._trigger("remove",t,this._uiHash())}),n.push(function(t){return function(e){t._trigger("receive",e,this._uiHash(this))}}.call(this,this.currentContainer)),n.push(function(t){return function(e){t._trigger("update",e,this._uiHash(this))}}.call(this,this.currentContainer)))),s=this.containers.length-1;s>=0;s--)e||n.push(i("deactivate",this,this.containers[s])),this.containers[s].containerCache.over&&(n.push(i("out",this,this.containers[s])),this.containers[s].containerCache.over=0);if(this.storedCursor&&(this.document.find("body").css("cursor",this.storedCursor),this.storedStylesheet.remove()),this._storedOpacity&&this.helper.css("opacity",this._storedOpacity),this._storedZIndex&&this.helper.css("zIndex","auto"===this._storedZIndex?"":this._storedZIndex),this.dragging=!1,e||this._trigger("beforeStop",t,this._uiHash()),this.placeholder[0].parentNode.removeChild(this.placeholder[0]),this.cancelHelperRemoval||(this.helper[0]!==this.currentItem[0]&&this.helper.remove(),this.helper=null),!e){for(s=0;n.length>s;s++)n[s].call(this,t);this._trigger("stop",t,this._uiHash())}return this.fromOutside=!1,!this.cancelHelperRemoval},_trigger:function(){t.Widget.prototype._trigger.apply(this,arguments)===!1&&this.cancel()},_uiHash:function(e){var i=e||this;return{helper:i.helper,placeholder:i.placeholder||t([]),position:i.position,originalPosition:i.originalPosition,offset:i.positionAbs,item:i.currentItem,sender:e?e.element:null}}})});
/*
 * jQuery MiniColors: A tiny color picker built on jQuery
 *
 * Copyright: Cory LaViska for A Beautiful Site, LLC: http://www.abeautifulsite.net/
 *
 * Contribute: https://github.com/claviska/jquery-minicolors
 *
 * @license: http://opensource.org/licenses/MIT
 *
 */
!function(i){"function"==typeof define&&define.amd?define(["jquery"],i):"object"==typeof exports?module.exports=i(require("jquery")):i(jQuery)}(function($){"use strict";function i(i,t){var o=$('<div class="minicolors" />'),s=$.minicolors.defaults,a,n,r,c,l;if(!i.data("minicolors-initialized")){if(t=$.extend(!0,{},s,t),o.addClass("minicolors-theme-"+t.theme).toggleClass("minicolors-with-opacity",t.opacity).toggleClass("minicolors-no-data-uris",t.dataUris!==!0),void 0!==t.position&&$.each(t.position.split(" "),function(){o.addClass("minicolors-position-"+this)}),a="rgb"===t.format?t.opacity?"25":"20":t.keywords?"11":"7",i.addClass("minicolors-input").data("minicolors-initialized",!1).data("minicolors-settings",t).prop("size",a).wrap(o).after('<div class="minicolors-panel minicolors-slider-'+t.control+'"><div class="minicolors-slider minicolors-sprite"><div class="minicolors-picker"></div></div><div class="minicolors-opacity-slider minicolors-sprite"><div class="minicolors-picker"></div></div><div class="minicolors-grid minicolors-sprite"><div class="minicolors-grid-inner"></div><div class="minicolors-picker"><div></div></div></div></div>'),t.inline||(i.after('<span class="minicolors-swatch minicolors-sprite minicolors-input-swatch"><span class="minicolors-swatch-color"></span></span>'),i.next(".minicolors-input-swatch").on("click",function(t){t.preventDefault(),i.focus()})),c=i.parent().find(".minicolors-panel"),c.on("selectstart",function(){return!1}).end(),t.swatches&&0!==t.swatches.length)for(t.swatches.length>7&&(t.swatches.length=7),c.addClass("minicolors-with-swatches"),n=$('<ul class="minicolors-swatches"></ul>').appendTo(c),l=0;l<t.swatches.length;++l)r=t.swatches[l],r=f(r)?u(r,!0):x(p(r,!0)),$('<li class="minicolors-swatch minicolors-sprite"><span class="minicolors-swatch-color"></span></li>').appendTo(n).data("swatch-color",t.swatches[l]).find(".minicolors-swatch-color").css({backgroundColor:y(r),opacity:r.a}),t.swatches[l]=r;t.inline&&i.parent().addClass("minicolors-inline"),e(i,!1),i.data("minicolors-initialized",!0)}}function t(i){var t=i.parent();i.removeData("minicolors-initialized").removeData("minicolors-settings").removeProp("size").removeClass("minicolors-input"),t.before(i).remove()}function o(i){var t=i.parent(),o=t.find(".minicolors-panel"),a=i.data("minicolors-settings");!i.data("minicolors-initialized")||i.prop("disabled")||t.hasClass("minicolors-inline")||t.hasClass("minicolors-focus")||(s(),t.addClass("minicolors-focus"),o.stop(!0,!0).fadeIn(a.showSpeed,function(){a.show&&a.show.call(i.get(0))}))}function s(){$(".minicolors-focus").each(function(){var i=$(this),t=i.find(".minicolors-input"),o=i.find(".minicolors-panel"),s=t.data("minicolors-settings");o.fadeOut(s.hideSpeed,function(){s.hide&&s.hide.call(t.get(0)),i.removeClass("minicolors-focus")})})}function a(i,t,o){var s=i.parents(".minicolors").find(".minicolors-input"),a=s.data("minicolors-settings"),r=i.find("[class$=-picker]"),e=i.offset().left,c=i.offset().top,l=Math.round(t.pageX-e),h=Math.round(t.pageY-c),d=o?a.animationSpeed:0,p,u,g,m;t.originalEvent.changedTouches&&(l=t.originalEvent.changedTouches[0].pageX-e,h=t.originalEvent.changedTouches[0].pageY-c),0>l&&(l=0),0>h&&(h=0),l>i.width()&&(l=i.width()),h>i.height()&&(h=i.height()),i.parent().is(".minicolors-slider-wheel")&&r.parent().is(".minicolors-grid")&&(p=75-l,u=75-h,g=Math.sqrt(p*p+u*u),m=Math.atan2(u,p),0>m&&(m+=2*Math.PI),g>75&&(g=75,l=75-75*Math.cos(m),h=75-75*Math.sin(m)),l=Math.round(l),h=Math.round(h)),i.is(".minicolors-grid")?r.stop(!0).animate({top:h+"px",left:l+"px"},d,a.animationEasing,function(){n(s,i)}):r.stop(!0).animate({top:h+"px"},d,a.animationEasing,function(){n(s,i)})}function n(i,t){function o(i,t){var o,s;return i.length&&t?(o=i.offset().left,s=i.offset().top,{x:o-t.offset().left+i.outerWidth()/2,y:s-t.offset().top+i.outerHeight()/2}):null}var s,a,n,e,l,h,d,p=i.val(),u=i.attr("data-opacity"),g=i.parent(),f=i.data("minicolors-settings"),v=g.find(".minicolors-input-swatch"),b=g.find(".minicolors-grid"),w=g.find(".minicolors-slider"),y=g.find(".minicolors-opacity-slider"),k=b.find("[class$=-picker]"),M=w.find("[class$=-picker]"),x=y.find("[class$=-picker]"),I=o(k,b),S=o(M,w),z=o(x,y);if(t.is(".minicolors-grid, .minicolors-slider, .minicolors-opacity-slider")){switch(f.control){case"wheel":e=b.width()/2-I.x,l=b.height()/2-I.y,h=Math.sqrt(e*e+l*l),d=Math.atan2(l,e),0>d&&(d+=2*Math.PI),h>75&&(h=75,I.x=69-75*Math.cos(d),I.y=69-75*Math.sin(d)),a=m(h/.75,0,100),s=m(180*d/Math.PI,0,360),n=m(100-Math.floor(S.y*(100/w.height())),0,100),p=C({h:s,s:a,b:n}),w.css("backgroundColor",C({h:s,s:a,b:100}));break;case"saturation":s=m(parseInt(I.x*(360/b.width()),10),0,360),a=m(100-Math.floor(S.y*(100/w.height())),0,100),n=m(100-Math.floor(I.y*(100/b.height())),0,100),p=C({h:s,s:a,b:n}),w.css("backgroundColor",C({h:s,s:100,b:n})),g.find(".minicolors-grid-inner").css("opacity",a/100);break;case"brightness":s=m(parseInt(I.x*(360/b.width()),10),0,360),a=m(100-Math.floor(I.y*(100/b.height())),0,100),n=m(100-Math.floor(S.y*(100/w.height())),0,100),p=C({h:s,s:a,b:n}),w.css("backgroundColor",C({h:s,s:a,b:100})),g.find(".minicolors-grid-inner").css("opacity",1-n/100);break;default:s=m(360-parseInt(S.y*(360/w.height()),10),0,360),a=m(Math.floor(I.x*(100/b.width())),0,100),n=m(100-Math.floor(I.y*(100/b.height())),0,100),p=C({h:s,s:a,b:n}),b.css("backgroundColor",C({h:s,s:100,b:100}))}u=f.opacity?parseFloat(1-z.y/y.height()).toFixed(2):1,r(i,p,u)}else v.find("span").css({backgroundColor:p,opacity:u}),c(i,p,u)}function r(i,t,o){var s,a=i.parent(),n=i.data("minicolors-settings"),r=a.find(".minicolors-input-swatch");n.opacity&&i.attr("data-opacity",o),"rgb"===n.format?(s=f(t)?u(t,!0):x(p(t,!0)),o=""===i.attr("data-opacity")?1:m(parseFloat(i.attr("data-opacity")).toFixed(2),0,1),(isNaN(o)||!n.opacity)&&(o=1),t=i.minicolors("rgbObject").a<=1&&s&&n.opacity?"rgba("+s.r+", "+s.g+", "+s.b+", "+parseFloat(o)+")":"rgb("+s.r+", "+s.g+", "+s.b+")"):(f(t)&&(t=w(t)),t=d(t,n.letterCase)),i.val(t),r.find("span").css({backgroundColor:t,opacity:o}),c(i,t,o)}function e(i,t){var o,s,a,n,r,e,l,h,b,y,M=i.parent(),x=i.data("minicolors-settings"),I=M.find(".minicolors-input-swatch"),S=M.find(".minicolors-grid"),z=M.find(".minicolors-slider"),F=M.find(".minicolors-opacity-slider"),D=S.find("[class$=-picker]"),T=z.find("[class$=-picker]"),j=F.find("[class$=-picker]");switch(f(i.val())?(o=w(i.val()),r=m(parseFloat(v(i.val())).toFixed(2),0,1),r&&i.attr("data-opacity",r)):o=d(p(i.val(),!0),x.letterCase),o||(o=d(g(x.defaultValue,!0),x.letterCase)),s=k(o),n=x.keywords?$.map(x.keywords.split(","),function(i){return $.trim(i.toLowerCase())}):[],e=""!==i.val()&&$.inArray(i.val().toLowerCase(),n)>-1?d(i.val()):f(i.val())?u(i.val()):o,t||i.val(e),x.opacity&&(a=""===i.attr("data-opacity")?1:m(parseFloat(i.attr("data-opacity")).toFixed(2),0,1),isNaN(a)&&(a=1),i.attr("data-opacity",a),I.find("span").css("opacity",a),h=m(F.height()-F.height()*a,0,F.height()),j.css("top",h+"px")),"transparent"===i.val().toLowerCase()&&I.find("span").css("opacity",0),I.find("span").css("backgroundColor",o),x.control){case"wheel":b=m(Math.ceil(.75*s.s),0,S.height()/2),y=s.h*Math.PI/180,l=m(75-Math.cos(y)*b,0,S.width()),h=m(75-Math.sin(y)*b,0,S.height()),D.css({top:h+"px",left:l+"px"}),h=150-s.b/(100/S.height()),""===o&&(h=0),T.css("top",h+"px"),z.css("backgroundColor",C({h:s.h,s:s.s,b:100}));break;case"saturation":l=m(5*s.h/12,0,150),h=m(S.height()-Math.ceil(s.b/(100/S.height())),0,S.height()),D.css({top:h+"px",left:l+"px"}),h=m(z.height()-s.s*(z.height()/100),0,z.height()),T.css("top",h+"px"),z.css("backgroundColor",C({h:s.h,s:100,b:s.b})),M.find(".minicolors-grid-inner").css("opacity",s.s/100);break;case"brightness":l=m(5*s.h/12,0,150),h=m(S.height()-Math.ceil(s.s/(100/S.height())),0,S.height()),D.css({top:h+"px",left:l+"px"}),h=m(z.height()-s.b*(z.height()/100),0,z.height()),T.css("top",h+"px"),z.css("backgroundColor",C({h:s.h,s:s.s,b:100})),M.find(".minicolors-grid-inner").css("opacity",1-s.b/100);break;default:l=m(Math.ceil(s.s/(100/S.width())),0,S.width()),h=m(S.height()-Math.ceil(s.b/(100/S.height())),0,S.height()),D.css({top:h+"px",left:l+"px"}),h=m(z.height()-s.h/(360/z.height()),0,z.height()),T.css("top",h+"px"),S.css("backgroundColor",C({h:s.h,s:100,b:100}))}i.data("minicolors-initialized")&&c(i,e,a)}function c(i,t,o){var s=i.data("minicolors-settings"),a=i.data("minicolors-lastChange"),n,r,e;if(!a||a.value!==t||a.opacity!==o){if(i.data("minicolors-lastChange",{value:t,opacity:o}),s.swatches&&0!==s.swatches.length){for(n=f(t)?u(t,!0):x(t),r=-1,e=0;e<s.swatches.length;++e)if(n.r===s.swatches[e].r&&n.g===s.swatches[e].g&&n.b===s.swatches[e].b&&n.a===s.swatches[e].a){r=e;break}i.parent().find(".minicolors-swatches .minicolors-swatch").removeClass("selected"),-1!==e&&i.parent().find(".minicolors-swatches .minicolors-swatch").eq(e).addClass("selected")}s.change&&(s.changeDelay?(clearTimeout(i.data("minicolors-changeTimeout")),i.data("minicolors-changeTimeout",setTimeout(function(){s.change.call(i.get(0),t,o)},s.changeDelay))):s.change.call(i.get(0),t,o)),i.trigger("change").trigger("input")}}function l(i){var t=p($(i).val(),!0),o=x(t),s=$(i).attr("data-opacity");return o?(void 0!==s&&$.extend(o,{a:parseFloat(s)}),o):null}function h(i,t){var o=p($(i).val(),!0),s=x(o),a=$(i).attr("data-opacity");return s?(void 0===a&&(a=1),t?"rgba("+s.r+", "+s.g+", "+s.b+", "+parseFloat(a)+")":"rgb("+s.r+", "+s.g+", "+s.b+")"):null}function d(i,t){return"uppercase"===t?i.toUpperCase():i.toLowerCase()}function p(i,t){return i=i.replace(/^#/g,""),i.match(/^[A-F0-9]{3,6}/gi)?3!==i.length&&6!==i.length?"":(3===i.length&&t&&(i=i[0]+i[0]+i[1]+i[1]+i[2]+i[2]),"#"+i):""}function u(i,t){var o=i.replace(/[^\d,.]/g,""),s=o.split(",");return s[0]=m(parseInt(s[0],10),0,255),s[1]=m(parseInt(s[1],10),0,255),s[2]=m(parseInt(s[2],10),0,255),s[3]&&(s[3]=m(parseFloat(s[3],10),0,1)),t?{r:s[0],g:s[1],b:s[2],a:s[3]?s[3]:null}:"undefined"!=typeof s[3]&&s[3]<=1?"rgba("+s[0]+", "+s[1]+", "+s[2]+", "+s[3]+")":"rgb("+s[0]+", "+s[1]+", "+s[2]+")"}function g(i,t){return f(i)?u(i):p(i,t)}function m(i,t,o){return t>i&&(i=t),i>o&&(i=o),i}function f(i){var t=i.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);return t&&4===t.length?!0:!1}function v(i){return i=i.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+(\.\d{1,2})?|\.\d{1,2})[\s+]?/i),i&&6===i.length?i[4]:"1"}function b(i){var t={},o=Math.round(i.h),s=Math.round(255*i.s/100),a=Math.round(255*i.b/100);if(0===s)t.r=t.g=t.b=a;else{var n=a,r=(255-s)*a/255,e=(n-r)*(o%60)/60;360===o&&(o=0),60>o?(t.r=n,t.b=r,t.g=r+e):120>o?(t.g=n,t.b=r,t.r=n-e):180>o?(t.g=n,t.r=r,t.b=r+e):240>o?(t.b=n,t.r=r,t.g=n-e):300>o?(t.b=n,t.g=r,t.r=r+e):360>o?(t.r=n,t.g=r,t.b=n-e):(t.r=0,t.g=0,t.b=0)}return{r:Math.round(t.r),g:Math.round(t.g),b:Math.round(t.b)}}function w(i){return i=i.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i),i&&4===i.length?"#"+("0"+parseInt(i[1],10).toString(16)).slice(-2)+("0"+parseInt(i[2],10).toString(16)).slice(-2)+("0"+parseInt(i[3],10).toString(16)).slice(-2):""}function y(i){var t=[i.r.toString(16),i.g.toString(16),i.b.toString(16)];return $.each(t,function(i,o){1===o.length&&(t[i]="0"+o)}),"#"+t.join("")}function C(i){return y(b(i))}function k(i){var t=M(x(i));return 0===t.s&&(t.h=360),t}function M(i){var t={h:0,s:0,b:0},o=Math.min(i.r,i.g,i.b),s=Math.max(i.r,i.g,i.b),a=s-o;return t.b=s,t.s=0!==s?255*a/s:0,0!==t.s?i.r===s?t.h=(i.g-i.b)/a:i.g===s?t.h=2+(i.b-i.r)/a:t.h=4+(i.r-i.g)/a:t.h=-1,t.h*=60,t.h<0&&(t.h+=360),t.s*=100/255,t.b*=100/255,t}function x(i){return i=parseInt(i.indexOf("#")>-1?i.substring(1):i,16),{r:i>>16,g:(65280&i)>>8,b:255&i}}$.minicolors={defaults:{animationSpeed:50,animationEasing:"swing",change:null,changeDelay:0,control:"hue",dataUris:!0,defaultValue:"",format:"hex",hide:null,hideSpeed:100,inline:!1,keywords:"",letterCase:"lowercase",opacity:!1,position:"bottom left",show:null,showSpeed:100,theme:"default",swatches:[]}},$.extend($.fn,{minicolors:function(a,n){switch(a){case"destroy":return $(this).each(function(){t($(this))}),$(this);case"hide":return s(),$(this);case"opacity":return void 0===n?$(this).attr("data-opacity"):($(this).each(function(){e($(this).attr("data-opacity",n))}),$(this));case"rgbObject":return l($(this),"rgbaObject"===a);case"rgbString":case"rgbaString":return h($(this),"rgbaString"===a);case"settings":return void 0===n?$(this).data("minicolors-settings"):($(this).each(function(){var i=$(this).data("minicolors-settings")||{};t($(this)),$(this).minicolors($.extend(!0,i,n))}),$(this));case"show":return o($(this).eq(0)),$(this);case"value":return void 0===n?$(this).val():($(this).each(function(){"object"==typeof n?(n.opacity&&$(this).attr("data-opacity",m(n.opacity,0,1)),n.color&&$(this).val(n.color)):$(this).val(n),e($(this))}),$(this));default:return"create"!==a&&(n=a),$(this).each(function(){i($(this),n)}),$(this)}}}),$(document).on("mousedown.minicolors touchstart.minicolors",function(i){$(i.target).parents().add(i.target).hasClass("minicolors")||s()}).on("mousedown.minicolors touchstart.minicolors",".minicolors-grid, .minicolors-slider, .minicolors-opacity-slider",function(i){var t=$(this);i.preventDefault(),$(document).data("minicolors-target",t),a(t,i,!0)}).on("mousemove.minicolors touchmove.minicolors",function(i){var t=$(document).data("minicolors-target");t&&a(t,i)}).on("mouseup.minicolors touchend.minicolors",function(){$(this).removeData("minicolors-target")}).on("click.minicolors",".minicolors-swatches li",function(i){i.preventDefault();var t=$(this),o=t.parents(".minicolors").find(".minicolors-input"),s=t.data("swatch-color");r(o,s,v(s)),e(o)}).on("mousedown.minicolors touchstart.minicolors",".minicolors-input-swatch",function(i){var t=$(this).parent().find(".minicolors-input");i.preventDefault(),o(t)}).on("focus.minicolors",".minicolors-input",function(){var i=$(this);i.data("minicolors-initialized")&&o(i)}).on("blur.minicolors",".minicolors-input",function(){var i=$(this),t=i.data("minicolors-settings"),o,s,a,n,r;i.data("minicolors-initialized")&&(o=t.keywords?$.map(t.keywords.split(","),function(i){return $.trim(i.toLowerCase())}):[],""!==i.val()&&$.inArray(i.val().toLowerCase(),o)>-1?r=i.val():(f(i.val())?a=u(i.val(),!0):(s=p(i.val(),!0),a=s?x(s):null),r=null===a?t.defaultValue:"rgb"===t.format?u(t.opacity?"rgba("+a.r+","+a.g+","+a.b+","+i.attr("data-opacity")+")":"rgb("+a.r+","+a.g+","+a.b+")"):y(a)),n=t.opacity?i.attr("data-opacity"):1,"transparent"===r.toLowerCase()&&(n=0),i.closest(".minicolors").find(".minicolors-input-swatch > span").css("opacity",n),i.val(r),""===i.val()&&i.val(g(t.defaultValue,!0)),i.val(d(i.val(),t.letterCase)))}).on("keydown.minicolors",".minicolors-input",function(i){var t=$(this);if(t.data("minicolors-initialized"))switch(i.keyCode){case 9:s();break;case 13:case 27:s(),t.blur()}}).on("keyup.minicolors",".minicolors-input",function(){var i=$(this);i.data("minicolors-initialized")&&e(i,!0)}).on("paste.minicolors",".minicolors-input",function(){var i=$(this);i.data("minicolors-initialized")&&setTimeout(function(){e(i,!0)},1)})});
;( function(window) {
    'use strict';

    /**
     * PasswordMeter constructor
     *
     * @param DOM Object el
     * @param string field
     */
    function PasswordMeter(el, field, meter) {
        this.el = el;

        field = field || 'input[type="password"]';
        meter = meter || '.form-group__password > .password-strength';

        this.field = this.el.find(field);
        this.meter = this.el.find(meter);
        this._init();
    }

    // PasswordMeter prototype
    PasswordMeter.prototype = {
        // Initializes meter
        _init : function() {
            this.characters = 0;
            this.capitalletters = 0;
            this.lowerletters = 0;
            this.number = 0;
            this.special = 0;

            this.upperCase = new RegExp('[A-Z]');
            this.lowerCase = new RegExp('[a-z]');
            this.numbers = new RegExp('[0-9]');
            this.specialchars = new RegExp('([!,%,&,@,#,$,^,*,?,_,~,/])');

            var self = this;

            this.field.on('keyup keydown', function() {
                self._checkStrength($(this).val());
            });
        },
        // Sets meter percentage
        _setPercentage : function(percentage) {
            this.meter.css({ 'width' : percentage + '%' });
        },
        // Sets meter class
        _setClass : function(total) {
            if(total <= 1) {
                this.meter.removeClass();
                this.meter.addClass('password-strength password-strength--veryweak');
            } else if(total === 2) {
                this.meter.removeClass();
                this.meter.addClass('password-strength password-strength--weak');
            } else if(total === 3) {
                this.meter.removeClass();
                this.meter.addClass('password-strength password-strength--medium');
            } else {
                this.meter.removeClass();
                this.meter.addClass('password-strength password-strength--strong');
            }
        },
        // Checks strength
        _checkStrength : function(value) {
            if (value.length >= 8) { this.characters = 1; } else { this.characters = 0; }
            if (value.match(this.upperCase)) { this.capitalletters = 1; } else { this.capitalletters = 0; }
            if (value.match(this.lowerCase)) { this.lowerletters = 1; }  else { this.lowerletters = 0; }
            if (value.match(this.numbers)) { this.number = 1; }  else { this.number = 0; }
            if (value.match(this.specialchars)) { this.special = 1; }  else { this.special = 0; }


            var total = this._getTotal();
            var percentage = this._getPercentage(5, total);

            this._setPercentage(percentage);

            this._setClass(total);
        },
        // Percentage helper
        _getPercentage : function(a, b) {
            return ((b / a) * 100);
        },
        // Gets total
        _getTotal : function() {
            return this.characters + this.capitalletters + this.lowerletters + this.number + this.special;
        }
    };

    // Register meter to window namespace
    window.PasswordMeter = PasswordMeter;

})(window);
;(function (window) {
    'use strict';

    /**
     * RelationField Constructor
     *
     * @param DOM Object
     */
    function RelationField(el) {
        this.el = el;

        this._init();
    }

    RelationField.prototype = {
        _init: function () {
            this.searchurl = this.el.data('searchurl');
            this.mode = this.el.data('mode');

            this.items = this.el.find('ul.related-items');
            this.results = this.el.find('ul.related-search__results');
            this.search = this.el.find('input[name="_relatedsearch"]');
            this.value = this.el.find('input[type="hidden"]');

            this.searching = false;

            this.itemKeys = [];
            this._extractItems();

            this._initEvents();
        },
        _extractItems: function () {
            var items = this.value.val().trim();

            if (items == '') {
                return;
            }

            if (this.mode === 'single') {
                this.itemKeys.push(parseInt(items));
            } else {
                this.itemKeys = JSON.parse(items);
            }
        },
        _initEvents: function () {
            var self = this;

            // Search input
            this.search.on('keydown', function (e) {
                var q = $(this).val().trim(),
                    input = $(this);

                // Press escape
                if (e.which == 27) {
                    e.stopPropagation();

                    (q === '') ? input.blur() : input.val('');

                    self._clearSearch();

                    return;

                    // Press down
                } else if (e.which == 40) {
                    e.stopPropagation();

                    if (self._hasResults()) {
                        self._focusResult(0);
                    }

                    return;

                    // Press enter
                } else if (e.which == 13) {
                    e.preventDefault();
                }

                if (!self.searching && q.length > 0) {
                    self._search(q);
                }

                if (q == '') {
                    self._clearSearch();
                }
            });

            this.search.on('focus', function () {
                self._showResults();
            });

            // Hiding search
            $('body').click(function () {
                self._hideResults();
            });

            this.el.click(function (e) {
                e.stopPropagation();
            });

            // Toggle between results
            this.results.on('keydown', 'input.related-search__input', function (e) {
                e.stopPropagation();
                e.preventDefault();

                var parent = $(this).closest('li');

                // Press down
                if (e.which == 40) {
                    if ( ! parent.is(':last-child')) {
                        self._focusResult(parent.index() + 1);
                    }
                // Press up
                } else if (e.which == 38) {
                    if (parent.is(':first-child')) {
                        self._focusSearch();
                    } else {
                        self._focusResult(parent.index() - 1);
                    }

                // Press enter
                } else if (e.which == 13) {
                    self._addItem(parent);
                }
            });

            // Add item
            this.results.on('click', 'li.related-search__result', function () {
                self._addItem($(this));
            });

            // Remove item
            this.items.on('click', 'i.related-item__close', function (e) {
                e.stopPropagation();

                self._removeItem($(this).parent());
            });

            // Hover result
            this.results.on('mouseenter', 'li.related-search__result', function () {
                self._focusResult($(this).index());
            });

            // Sortable
            if (this.mode !== 'single') {
                this.items.sortable({
                    tolerance: 'pointer',
                    placeholder: 'placeholder',
                    opacity: 0.7,
                    delay: 50,
                    stop: function () {
                        self._regenerateValue();
                    }
                });
            }
        },
        _search: function (keywords) {
            var self = this;

            if (!self.searching) {
                $.post(this.searchurl, {q: keywords}, function (data) {
                    self._populateResults(data);
                });
            }
        },
        _hasResults: function () {
            return (this.results.find('li.related-search__result').length > 0);
        },
        _focusResult: function (i) {
            var results = $(this.results).find('li.related-search__result'),
                result = results.eq(i);

            results.removeClass('related-search__result--selected');
            result.addClass('related-search__result--selected');

            result.find('input').focus();
        },
        _focusSearch: function() {
            $(this.results).find('li.related-search__result').removeClass('related-search__result--selected');

            this.search.focus();
        },
        _populateResults: function (items) {
            this.results.empty();

            for (var key in items) {
                if (this.itemKeys.indexOf(parseInt(key)) == -1) {
                    var item = this._addResult(key, items[key]);

                    this.results.append(item);
                }
            }
        },
        _addResult: function (id, title) {
            return $('<li class="related-search__result">' + title + '<input class="related-search__input" type="text" value="' + id + '"></li>');
        },
        _addItem: function(item) {
            var id = item.find('input').val();

            var item = $('<li class="related-item" data-id="' + id + '">' + item.text() + '<i class="icon-cancel related-item__close"></i></li>');

            if (this.mode === 'single') {
                this.items.empty();
                this.itemKeys = [];
            }

            this.items.append(item);

            this.itemKeys.push(item.data('id'));

            this._regenerateValue();

            this._clearSearch();

            this.search.focus();
        },
        _removeItem: function(item) {
            var i = this.itemKeys.indexOf(item.data('id'));
            delete this.itemKeys[i];

            item.remove();

            this._regenerateValue();
        },
        _regenerateValue: function () {
            var val = '';

            if (this.mode === 'single') {
                var item = this.items.find('li.related-item:first-child');

                if (item.length == 1) {
                    val = item.data('id');
                }
            } else {
                var array = [],
                    items = this.items.find('li.related-item');

                for (var i = 0; i < items.length; i++) {
                    array.push($(items[i]).data('id'));
                }

                val = JSON.stringify(array);
            }

            this.value.val(val);
        },
        _clearSearch: function () {
            this.results.empty();
            this.search.val('');
        },
        _showResults: function () {
            this.results.removeClass('related-search__results--hidden');
        },
        _hideResults: function () {
            this.results.addClass('related-search__results--hidden');
        }
    };

    window.RelationField = RelationField;

})(window);
;( function(window) {
    'use strict';

    // Constructor
    function Slug(el) {
        this.el = el;

        this._init();
    }

    // Slug prototype
    Slug.prototype = {
        // Initialize
        _init : function() {
            this.input = this.el.find('input[type="text"]');

            var follow = typeof this.input.data('follows') !== 'undefined' ?
                this.input.data('follows') :
                '#title';

            this.follow = $(follow);

            this.dirty = (this.input.val() !== '') ? true : false;

            this._initEvents();
        },
        _initEvents : function() {
            var self = this;

            this.input.on('keyup', function() {
                self.dirty = true;
            });

            this.follow.on('keyup', function() {
                if(!self.dirty) { self._setSlug(); }
            });

            this.input.on('blur', function() {
                if(self.input.val() === '') {
                    self.changed = false;
                    self._setSlug();
                }
            });
        },
        // Set slug
        _setSlug : function() {
            var slug = this._slugify(this.follow.val());

            this.input.val(slug);
        },
        _slugify : function(str) {
            str = str.replace(/^\s+|\s+$/g, '').toLowerCase();

            // Remove accents
            var from = "àáäâèéëêıìíïîòóöôùúüûñçğş·/_,:;", to = "aaaaeeeeiiiiioooouuuuncgs------";

            for(var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            return str.replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
                .replace(/\s+/g, '-') // Collapse whitespace and replace by -
                .replace(/-+/g, '-'); // Collapse dashes
        }
    };

    window.Slug = Slug;

}) (window);
// GENERAL LABEL HIGHLIGHTERS
$('.form-group input, .form-group textarea').focus(function () {
    $(this).closest('.form-group').find('.form-group__label').addClass('form-group__label--focus');
});

$('.form-group input, .form-group textarea').blur(function () {
    $(this).closest('.form-group').find('.form-group__label').removeClass('form-group__label--focus');
});

// LOCATE FORM BUTTONS
var formContainer = $('#content'),
    formButtons = $('#formButtons');

function locateFormButtons() {
    var wH = $(window).height(),
        fcH = formContainer.outerHeight();

    // This 12px thing is because of the content container needs to have an
    // extra of 12px bottom padding in order to ensure scrollbar not showing
    if ((wH + 12) > fcH) {
        formButtons.css('bottom', (wH - fcH + 28) + 'px');
    } else {
        formButtons.css('bottom', '');
    }
}

locateFormButtons();
$(window).on('resize.formbuttons', function () {
    locateFormButtons();
});

// PASSWORD FIELDS
$('.form-group--password').each(function () {
    new PasswordMeter($(this));
});

// SLUG FIELDS
$('.form-group--slug').each(function () {
    new Slug($(this));
});

// COLOR FIELDS
$('input.minicolors').minicolors({
    position: 'top left'
});

// RELATION FIELDS
$('.form-group__relation').each(function () {
    new RelationField($(this));
});
//# sourceMappingURL=forms.js.map
