/*  ОПРЕДЕЛЕНИЕ БРАУЗЕРА БЕЗ jQuery

.[ОС].[Браузер] css селектор

 Селекторы ОСи:
.win — Windows
 .linux — Linux
 .mac — MacOS

 Селекторы браузеров:
.ie — все версии ИЕ
 .ie8 — ИЕ 8.х
 .ie7 — ИЕ 7.x
 .ie6 — ИЕ 6.x
 .ie5 — ИЕ 5.x
 .gecko — все версии фаерфокса, и остальные гекко-браузеры
 .ff2 — фаерфокс 2
 .ff3 — фаерфокс 3
 .opera — все версии оперы
 .opera8 — опера 8.x
 .opera9 — опера 9.x
 .konqueror — konqueror
 .safari — сафари */


var cssFix = function(){
  var u = navigator.userAgent.toLowerCase(),
  addClass = function(el,val){
    if(!el.className) {
      el.className = val;
    } else {
      var newCl = el.className;
      newCl+=(" "+val);
      el.className = newCl;
    }
  },
  is = function(t){return (u.indexOf(t)!=-1)};
  addClass(document.getElementsByTagName('html')[0],[
    (!(/opera|webtv/i.test(u))&&/msie (\d)/.test(u))?('ie ie'+RegExp.$1)
      :is('firefox/2')?'gecko ff2'
      :is('firefox/3')?'gecko ff3'
      :is('gecko/')?'gecko'
      :is('opera/9')?'opera opera9':/opera (\d)/.test(u)?'opera opera'+RegExp.$1
      :is('konqueror')?'konqueror'
      :is('applewebkit/')?'webkit safari'
      :is('mozilla/')?'gecko':'',
    (is('x11')||is('linux'))?' linux'
      :is('mac')?' mac'
      :is('win')?' win':''
  ].join(" "));
}();