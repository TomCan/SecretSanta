webpackJsonp([5],{X9XS:function(t,e,n){var o,l,a;/*!
 * jQuery Smooth Scroll - v2.2.0 - 2017-05-05
 * https://github.com/kswedberg/jquery-smooth-scroll
 * Copyright (c) 2017 Karl Swedberg
 * Licensed MIT
 */
!function(i){l=[n("7t+N")],o=i,void 0!==(a="function"==typeof o?o.apply(e,l):o)&&(t.exports=a)}(function(t){var e={},n={exclude:[],excludeWithin:[],offset:0,direction:"top",delegateSelector:null,scrollElement:null,scrollTarget:null,autoFocus:!1,beforeScroll:function(){},afterScroll:function(){},easing:"swing",speed:400,autoCoefficient:2,preventDefault:!0},o=function(e){var n=[],o=!1,l=e.dir&&"left"===e.dir?"scrollLeft":"scrollTop";return this.each(function(){var e=t(this);if(this!==document&&this!==window)return!document.scrollingElement||this!==document.documentElement&&this!==document.body?void(e[l]()>0?n.push(this):(e[l](1),o=e[l]()>0,o&&n.push(this),e[l](0))):(n.push(document.scrollingElement),!1)}),n.length||this.each(function(){this===document.documentElement&&"smooth"===t(this).css("scrollBehavior")&&(n=[this]),n.length||"BODY"!==this.nodeName||(n=[this])}),"first"===e.el&&n.length>1&&(n=[n[0]]),n},l=/^([\-\+]=)(\d+)/;t.fn.extend({scrollable:function(t){var e=o.call(this,{dir:t});return this.pushStack(e)},firstScrollable:function(t){var e=o.call(this,{el:"first",dir:t});return this.pushStack(e)},smoothScroll:function(e,n){if("options"===(e=e||{}))return n?this.each(function(){var e=t(this),o=t.extend(e.data("ssOpts")||{},n);t(this).data("ssOpts",o)}):this.first().data("ssOpts");var o=t.extend({},t.fn.smoothScroll.defaults,e),l=function(e){var n=function(t){return t.replace(/(:|\.|\/)/g,"\\$1")},l=this,a=t(this),i=t.extend({},o,a.data("ssOpts")||{}),r=o.exclude,c=i.excludeWithin,s=0,p=0,u=!0,f={},h=t.smoothScroll.filterPath(location.pathname),d=t.smoothScroll.filterPath(l.pathname),m=location.hostname===l.hostname||!l.hostname,v=i.scrollTarget||d===h,g=n(l.hash);if(g&&!t(g).length&&(u=!1),i.scrollTarget||m&&v&&g){for(;u&&s<r.length;)a.is(n(r[s++]))&&(u=!1);for(;u&&p<c.length;)a.closest(c[p++]).length&&(u=!1)}else u=!1;u&&(i.preventDefault&&e.preventDefault(),t.extend(f,i,{scrollTarget:i.scrollTarget||g,link:l}),t.smoothScroll(f))};return null!==e.delegateSelector?this.off("click.smoothscroll",e.delegateSelector).on("click.smoothscroll",e.delegateSelector,l):this.off("click.smoothscroll").on("click.smoothscroll",l),this}});var a=function(t){var e={relative:""},n="string"==typeof t&&l.exec(t);return"number"==typeof t?e.px=t:n&&(e.relative=n[1],e.px=parseFloat(n[2])||0),e},i=function(e){var n=t(e.scrollTarget);e.autoFocus&&n.length&&(n[0].focus(),n.is(document.activeElement)||(n.prop({tabIndex:-1}),n[0].focus())),e.afterScroll.call(e.link,e)};t.smoothScroll=function(n,o){if("options"===n&&"object"==typeof o)return t.extend(e,o);var l,r,c,s,p=a(n),u={},f=0,h="offset",d="scrollTop",m={},v={};p.px?l=t.extend({link:null},t.fn.smoothScroll.defaults,e):(l=t.extend({link:null},t.fn.smoothScroll.defaults,n||{},e),l.scrollElement&&(h="position","static"===l.scrollElement.css("position")&&l.scrollElement.css("position","relative")),o&&(p=a(o))),d="left"===l.direction?"scrollLeft":d,l.scrollElement?(r=l.scrollElement,p.px||/^(?:HTML|BODY)$/.test(r[0].nodeName)||(f=r[d]())):r=t("html, body").firstScrollable(l.direction),l.beforeScroll.call(r,l),u=p.px?p:{relative:"",px:t(l.scrollTarget)[h]()&&t(l.scrollTarget)[h]()[l.direction]||0},m[d]=u.relative+(u.px+f+l.offset),c=l.speed,"auto"===c&&(s=Math.abs(m[d]-r[d]()),c=s/l.autoCoefficient),v={duration:c,easing:l.easing,complete:function(){i(l)}},l.step&&(v.step=l.step),r.length?r.stop().animate(m,v):i(l)},t.smoothScroll.version="2.2.0",t.smoothScroll.filterPath=function(t){return t=t||"",t.replace(/^\//,"").replace(/(?:index|default).[a-zA-Z]{3,4}$/,"").replace(/\/$/,"")},t.fn.smoothScroll.defaults=n})},Z57j:function(t,e,n){(function(t,o){function l(e,n,o){var l=e.attr("data-prototype"),i=e.children().length-1,r=l.replace(/__name__/g,i).replace(/__participantcount__/g,i+1),c=t(r);e.append(c),void 0!==n&&void 0!==o?(t(c).find(".participant-mail").attr("value",n),t(c).find(".participant-name").attr("value",o),c.show()):c.show(300),a(),t(".remove-participant").removeClass("disabled")}function a(){t("button.remove-participant").each(function(e){t(this).off("click"),t(this).click(function(n){n.preventDefault(),t("table tr.participant.not-owner:gt("+e+")").each(function(n){var o=t("table tr.participant.not-owner:eq("+(e+n+1)+") input.participant-name").val(),l=t("table tr.participant.not-owner:eq("+(e+n+1)+") input.participant-mail").val();t("table tr.participant.not-owner:eq("+(e+n)+") input.participant-name").val(o),t("table tr.participant.not-owner:eq("+(e+n)+") input.participant-mail").val(l)}),t("table tr.participant.not-owner:last").remove(),t("table tr.participant.not-owner").length<3&&(t("table tr.participant.not-owner button.remove-participant").addClass("disabled"),t("table tr.participant.not-owner button.remove-participant").off("click"))})})}n("X9XS"),e.addNewParticipant=function(t,e,n){l(t,e,n)};var i=t("table.participants tbody");o(document).ready(function(){t(".add-new-participant").click(function(t){t.preventDefault(),l(i)}),t("table tr.participant").length>3&&(a(),t(".remove-participant").removeClass("disabled")),t("a.btn-started").click(function(){return t.smoothScroll({scrollTarget:"#mysanta"}),!1})})}).call(e,n("7t+N"),n("7t+N"))}},["Z57j"]);