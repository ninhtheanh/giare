Prototype.Browser.IE6 = Prototype.Browser.IE && parseInt( navigator.userAgent.substring(navigator.userAgent.indexOf("MSIE")+5), 10 ) <= 6;

function $(element) {
  if (arguments.length > 1) {
    for (var i = 0, elements = [], length = arguments.length; i < length; i++)
      elements.push($(arguments[i]));
    return elements;
  }
  if (Object.isString(element))
    element = document.getElementById(element.replace('#', ''));
  return Element.extend(element);
}


Object.extend(Element.Methods, {
  
  animateToggle: function(el, speed, callback){
    var duration = 0;
    if(speed && typeof speed == "string"){
      switch(speed) {
        case "slow":
          duration = 0.6;
          break;
        case "medium":
          duration = 0.4;
          break;
        case "fast":
          duration = 0.25;
          break;
      }
    }
    else if(speed && (speed = parseInt(speed, 10)))
      duration = speed;
    else
      duration = 0.4;
    if(Effect)
      Effect.toggle(el, 'slide', {
        duration: duration,
        afterFinish: function() {
          if(callback)
            callback.call(this, el);
        }
      });
    else
      el.toggle();
    return el;
  },
  
  show: function(el, speed, callback) {
    if ( speed || speed === 0) {
      return el.slideDown({
        duration: .25,
        afterFinish: function() {
          if(callback)
            callback.call(this, el);
        }
      });
		}
		else {
		  //fixing prototypes show method so that it works for elements hidden via css too (like jquery)
  		var display = el.getStyle("display");
  		if(display === "none") {
  		  var elem = new Element(el.tagName);
  		  $$("body").invoke("insert", elem);
  		  display = elem.getStyle("display");
  		  if (display === "none")
  		    display = "block";
  		  elem.remove();
  		}
      el.setStyle({"display": display});
      return el;
		}
  },
  
  hide: function(el, speed, callback) {
    el = $(el);
    if ( speed || speed === 0) {
      return el.slideUp({
        duration: .25,
        afterFinish: function() {
					if (callback) {
						callback.call(this, el);
					}
        }
      });
		}
		else {
      el.style.display = 'none';
      return el;
		}
  },
  
  truncateAt: function(el, length, str) {
    if(el.innerHTML.length > length)
      el.innerHTML = el.innerHTML.substr(0, length) + str;
  },
  
  toggleHTML: function(el) {
    var args = [];
    $A(arguments).each(function(el, i) {
      args.push(el);
    });
    
    if(args[0].nodeName)
      var el = args.shift();
      
    if(args[0] instanceof Array) {
      var texts = args[0];
    }
    else {
      var texts = args;
    }
    for(var i = 0; i <= texts.length; i++) {
      if(texts[i] == el.innerHTML) {
        
        if(texts[i] == texts[texts.length - 1]){
          el.update(texts[0]);
        }
        else {
          el.update(texts[i + 1]);
        }
        break;
      }
    }
    return el;
  },
  
  dbID: function(element) {
    var regex = /([\w_]+)_/;
    return element.id.sub(regex, '');
  },
  
  startWaiting: function(element) {
    element.insert("<div class='loading'></div>");
    return element;
  },
  
  stopWaiting: function(element) {
    element.select('.loading').invoke("remove");
    return element;
  },
  
  setCaretPosition: function(element, position) {
    if (position == 'end') 
      position = element.getValue().length;
      
    if (element.createTextRange) {
      var range = element.createTextRange();
      range.move('character', position);
      range.select();
    } else {
      element.focus();
      if (element.setSelectionRange)
        element.setSelectionRange(position, position);
    }
  },

  visible: function(el) {
    return el.offsetWidth + el.offsetHeight > 0;
  }
  
});


Element.addMethods();

Object.extend(Array.prototype, {
  get: function(i){
    return this[i];
  }
});




LowPro = {};
LowPro.Version = '0.5';
LowPro.CompatibleWithPrototype = '1.6';

if (Prototype.Version.indexOf(LowPro.CompatibleWithPrototype) != 0 && window.console && window.console.warn)
  console.warn("This version of Low Pro is tested with Prototype " + LowPro.CompatibleWithPrototype +
                  " it may not work as expected with this version (" + Prototype.Version + ")");

if (!Element.addMethods)
  Element.addMethods = function(o) { Object.extend(Element.Methods, o) };

// Simple utility methods for working with the DOM
DOM = {};

// DOMBuilder for prototype
DOM.Builder = {
	tagFunc : function(tag) {
    return function() {
     var attrs, children;
     if (arguments.length>0) {
       if (arguments[0].constructor == Object) {
         attrs = arguments[0];
         children = Array.prototype.slice.call(arguments, 1);
       } else {
         children = arguments;
       };
       children = $A(children).flatten()
     }
     return DOM.Builder.create(tag, attrs, children);
    };
  },
	create : function(tag, attrs, children) {
		attrs = attrs || {}; children = children || []; tag = tag.toLowerCase();
		var el = new Element(tag, attrs);

		for (var i=0; i<children.length; i++) {
			if (typeof children[i] == 'string')
			  children[i] = document.createTextNode(children[i]);
			el.appendChild(children[i]);
		}
		return $(el);
	}
};

// Automatically create node builders as $tagName.
(function() {
	var els = ("p|div|span|strong|em|img|table|tr|td|th|thead|tbody|tfoot|pre|code|" +
				     "h1|h2|h3|h4|h5|h6|ul|ol|li|form|input|textarea|legend|fieldset|" +
				     "select|option|blockquote|cite|br|hr|dd|dl|dt|address|a|button|abbr|acronym|" +
				     "script|link|style|bdo|ins|del|object|param|col|colgroup|optgroup|caption|" +
				     "label|dfn|kbd|samp|var").split("|");
  var el, i=0;
	while (el = els[i++])
	  window['$' + el] = DOM.Builder.tagFunc(el);
})();

DOM.Builder.fromHTML = function(html) {
  var root;
  if (!(root = arguments.callee._root))
    root = arguments.callee._root = document.createElement('div');
  root.innerHTML = html;
  return root.childNodes[0];
};



// Wraps the 1.6 contentloaded event for backwards compatibility
//
// Usage:
//
// Event.onReady(callbackFunction);
if (typeof Event == 'undefined') Event = {};
Object.extend(Event, {
  onReady : function(f) {
    if (document.body) f();
    else document.observe('dom:loaded', f);
  }
});

// Based on event:Selectors by Justin Palmer
// http://encytemedia.com/event-selectors/
//
// Usage:
//
// Event.addBehavior({
//      "selector:event" : function(event) { /* event handler.  this refers to the element. */ },
//      "selector" : function() { /* runs function on dom ready.  this refers to the element. */ }
//      ...
// });
//
// Multiple calls will add to exisiting rules.  Event.addBehavior.reassignAfterAjax and
// Event.addBehavior.autoTrigger can be adjusted to needs.
Event.addBehavior = function(rules) {
  var ab = this.addBehavior;
  Object.extend(ab.rules, rules);

  if (!ab.responderApplied) {
    Ajax.Responders.register({
      onComplete : function() {
        if (Event.addBehavior.reassignAfterAjax)
          setTimeout(function() { ab.reload() }, 10);
      }
    });
    ab.responderApplied = true;
  }

  if (ab.autoTrigger) {
    this.onReady(ab.load.bind(ab, rules));
  }

};

Event.delegate = function(rules) {
  return function(e) {
      var element = $(e.element());
      for (var selector in rules)
        if (element.match(selector)) return rules[selector].apply(this, $A(arguments));
    }
}

Object.extend(Event.addBehavior, {
  rules : {}, cache : [],
  reassignAfterAjax : false,
  autoTrigger : true,

  load : function(rules) {
    for (var selector in rules) {
      var observer = rules[selector];
      var sels = selector.split(',');
      sels.each(function(sel) {
        var parts = sel.split(/:(?=[a-z]+$)/), css = parts[0], event = parts[1];
        $$(css).each(function(element) {
          if (event) {
            observer = Event.addBehavior._wrapObserver(observer);
            $(element).observe(event, observer);
            Event.addBehavior.cache.push([element, event, observer]);
          } else {
            if (!element.$$assigned || !element.$$assigned.include(observer)) {
              if (observer.attach) observer.attach(element);

              else observer.call($(element));
              element.$$assigned = element.$$assigned || [];
              element.$$assigned.push(observer);
            }
          }
        });
      });
    }
  },

  unload : function() {
    this.cache.each(function(c) {
      Event.stopObserving.apply(Event, c);
    });
    this.cache = [];
  },

  reload: function() {
    var ab = Event.addBehavior;
    ab.unload();
    ab.load(ab.rules);
  },

  _wrapObserver: function(observer) {
    return function(event) {
      if (observer.call(this, event) === false) event.stop();
    }
  }

});

Event.observe(window, 'unload', Event.addBehavior.unload.bind(Event.addBehavior));

// A silly Prototype style shortcut for the reckless
$$$ = Event.addBehavior.bind(Event);

// Behaviors can be bound to elements to provide an object orientated way of controlling elements
// and their behavior.  Use Behavior.create() to make a new behavior class then use attach() to
// glue it to an element.  Each element then gets it's own instance of the behavior and any
// methods called onxxx are bound to the relevent event.
//
// Usage:
//
// var MyBehavior = Behavior.create({
//   onmouseover : function() { this.element.addClassName('bong') }
// });
//
// Event.addBehavior({ 'a.rollover' : MyBehavior });
//
// If you need to pass additional values to initialize use:
//
// Event.addBehavior({ 'a.rollover' : MyBehavior(10, { thing : 15 }) })
//
// You can also use the attach() method.  If you specify extra arguments to attach they get passed to initialize.
//
// MyBehavior.attach(el, values, to, init);
//
// Finally, the rawest method is using the new constructor normally:
// var draggable = new Draggable(element, init, vals);
//
// Each behaviour has a collection of all its instances in Behavior.instances
//
var Behavior = {
  create: function() {
    var parent = null, properties = $A(arguments);
    if (Object.isFunction(properties[0]))
      parent = properties.shift();

      var behavior = function() {
        var behaving = arguments.callee;
        if (!this.initialize) {
          var args = $A(arguments);

          return function() {
            var initArgs = [this].concat(args);
            behavior.attach.apply(behaving, initArgs);
          };
        } else {
          var args = (arguments.length == 2 && arguments[1] instanceof Array) ?
                      arguments[1] : Array.prototype.slice.call(arguments, 1);

          this.element = $(arguments[0]);
          this.initialize.apply(this, args);
          behaving._bindEvents(this);
          behaving.instances.push(this);
        }
      };

    Object.extend(behavior, Class.Methods);
    Object.extend(behavior, Behavior.Methods);
    behavior.superclass = parent;
    behavior.subclasses = [];
    behavior.instances = [];

    if (parent) {
      var subclass = function() { };
      subclass.prototype = parent.prototype;
      behavior.prototype = new subclass;
      parent.subclasses.push(behavior);
    }

    for (var i = 0; i < properties.length; i++)
      behavior.addMethods(properties[i]);

    if (!behavior.prototype.initialize)
      behavior.prototype.initialize = Prototype.emptyFunction;

    behavior.prototype.constructor = behavior;

    return behavior;
  },
  Methods : {
    attach : function(element) {
      return new this(element, Array.prototype.slice.call(arguments, 1));
    },
    _bindEvents : function(bound) {
      for (var member in bound)
        if (member.match(/^on(.+)/) && typeof bound[member] == 'function')
          bound.element.observe(RegExp.$1, Event.addBehavior._wrapObserver(bound[member].bindAsEventListener(bound)));
    }
  }
};



Remote = Behavior.create({
  initialize: function(options) {
    if (this.element.nodeName == 'FORM') new Remote.Form(this.element, options);
    else new Remote.Link(this.element, options);
  }
});

Remote.Base = Class.create({
  initialize : function(options) {
    this.options = Object.extend({
      evaluateScripts : true
    }, options || {});

    this._bindCallbacks();
  },
  _makeRequest : function(options) {
    if (options.update) new Ajax.Updater(options.update, options.url, options);
    else new Ajax.Request(options.url, options);
    return false;
  },
  _bindCallbacks: function() {
    $w('onCreate onComplete onException onFailure onInteractive onLoading onLoaded onSuccess').each(function(cb) {
      if (Object.isFunction(this.options[cb]))
        this.options[cb] = this.options[cb].bind(this);
    }.bind(this));
  }
});

Remote.Link = Behavior.create(Remote.Base, {
  onclick : function() {
    var options = Object.extend({ url : this.element.href, method : 'get' }, this.options);
    return this._makeRequest(options);
  }
});


Remote.Form = Behavior.create(Remote.Base, {
  onclick : function(e) {
    var sourceElement = e.element();

    if (['input', 'button'].include(sourceElement.nodeName.toLowerCase()) &&
        sourceElement.type == 'submit')
      this._submitButton = sourceElement;
  },
  onsubmit : function() {
    var options = Object.extend({
      url : this.element.action,
      method : this.element.method || 'get',
      parameters : this.element.serialize({ submit: this._submitButton.name })
    }, this.options);
    this._submitButton = null;
    return this._makeRequest(options);
  }
});

Observed = Behavior.create({
  initialize : function(callback, options) {
    this.callback = callback.bind(this);
    this.options = options || {};
    this.observer = (this.element.nodeName == 'FORM') ? this._observeForm() : this._observeField();
  },
  stop: function() {
    this.observer.stop();
  },
  _observeForm: function() {
    return (this.options.frequency) ? new Form.Observer(this.element, this.options.frequency, this.callback) :
                                      new Form.EventObserver(this.element, this.callback);
  },
  _observeField: function() {
    return (this.options.frequency) ? new Form.Element.Observer(this.element, this.options.frequency, this.callback) :
                                      new Form.Element.EventObserver(this.element, this.callback);
  }
});


if (typeof Groupon === 'undefined') Groupon = {};
Groupon.Attributes = {};

var AttributeReader = function(element) {
	this.initialize(element);
}

AttributeReader.prototype = {
	BOOLEAN: /^false|true$/,
  DATE:    /^\d{1,2}\/\d\d?\/\d{4}$/,
  JSON:    /^\{.*\}$/,

	initialize: function(element) {
		this.element = element;
		Groupon.Attributes[ $(this.element).readAttribute("id") ] = this.typeCoerce( $(this.element).readAttribute("data-value") );
	},
	
	typeCoerce: function(val) {
    if ( this.BOOLEAN.test(val) ) return val == "false" ? false : true;
    if ( this.JSON.test(val) )    return (typeof Prototype != 'undefined') ? val.evalJSON() : jQuery.parseJSON( val );
    if ( this.DATE.test(val) )    return Date.parse(val);
    if ( !isNaN(val) )            return parseFloat(val);
    
    return val;
  }
}

Event.addBehavior({
  '.js_attribute': function() {
		new AttributeReader(this);
	}
});


/** 
 *  Script lazy loader 0.5
 *  Copyright (c) 2008 Bob Matsuoka
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2
 *  of the License, or (at your option) any later version.
 */

var LazyLoader = {}; //namespace
LazyLoader.timer = {}; // contains timers for scripts
LazyLoader.scripts = []; // contains called script references
LazyLoader.load = function (url, callback) {
    // handle object or path
    var classname = null;
    var properties = null;
    try {
        // make sure we only load once
        if ($A(LazyLoader.scripts).indexOf(url) == -1) {
            // note that we loaded already
            LazyLoader.scripts.push(url);
            var script = document.createElement("script");
            script.src = url;
            script.type = "text/javascript";
            $$("head")[0].appendChild(script); // add script tag to head element
            // was a callback requested
            if (callback) {
                // test for onreadystatechange to trigger callback
                script.onreadystatechange = function () {
                    if (script.readyState == 'loaded' || script.readyState == 'complete') {
                        callback();
                    }
                }
                // test for onload to trigger callback
                script.onload = function () {
                    callback();
                    return;
                }
                // safari doesn't support either onload or readystate, create a timer
                // only way to do this in safari
                if ((Prototype.Browser.WebKit && !navigator.userAgent.match(/Version\/3/)) || Prototype.Browser.Opera) { // sniff
                    LazyLoader.timer[url] = setInterval(function () {
                        if (/loaded|complete/.test(document.readyState)) {
                            clearInterval(LazyLoader.timer[url]);
                            callback(); // call the callback handler
                        }
                    }, 10);
                }
            }
        } else {
            if (callback) {
                callback();
            }
        }
    } catch (e) {
        alert(e);
    }
}

var PromptingField = Behavior.create({

    initialize: function() {
        this.changed = false;
        this.onblur();
        this.element.writeAttribute('autocomplete', 'off');
        this.element.up('form').observe('click', this.handleFormSubmission.bindAsEventListener(this));
    },

    setPrompt: function() {
        this.element.value = '';
        this.element.addClassName('prompting');
        this.element.value = this.element.title;
        this.changed = false;
    },

    clearPrompt: function() {
        this.element.value = '';
        this.element.removeClassName('prompting');
    },

		defaultPromptEnabled: function() {
			var whitespace_regex = /(#[^;]*;|\s)/;
			return (this.element.value.gsub(whitespace_regex, '') == this.element.title.gsub(whitespace_regex, ''));
		},

    onblur: function(event) {
        if (this.element.value.blank()) {
            this.setPrompt();
        }
    },

    onfocus: function(event) {
        if(this.defaultPromptEnabled()) {
            this.clearPrompt();
        }
    },

    handleFormSubmission: function(event) {
        var element = event.element();
        if (element.match('input[type=submit]') || element.match('button[type=submit]') || element.match('input[type=image]') || element.match('button[type=submit] span') ) {
            if(this.defaultPromptEnabled()) {
							this.clearPrompt();
            }
        }
    },

    onkeyup: function(event) { this.changed = true; },
    onchange: function(event) { this.changed = true; }

});


Event.addBehavior({'input.prompting_field, textarea.prompting_field': PromptingField});


/* 
Correctly handle PNG transparency in Win IE6.
http://homepage.ntlworld.com/bobosola. 
Updated 31-Aug-2007 by Richard Navarrete (richardun@gmail.com)
*/

/*
  This script based on http://homepage.ntlworld.com AND OPTIMIZED BY http://codeprostitute.com/2007/08/31/transparent-png-in-rails-app-not-working-in-ie/
  for a rails environment making use of cache-busting.  
*/
document.observe("dom:loaded", function(){
  var arVersion = navigator.appVersion.split("MSIE");
  var version = parseFloat(arVersion[1]);

  if ((version == 6) && (document.body.filters)) 
  {
    for(var i=0; i<document.images.length; i++)
    {
      var img = document.images[i];
      var imgName = img.src.toUpperCase();
      if (imgName.match(/\.PNG/))
      {
        var imgID = (img.id) ? "id='" + img.id + "' " : ""
        var imgClass = (img.className) ? "class='" + img.className + "' " : ""
        var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
        var imgDisplay = (img.className == "ib") ? "display:inline-block;" : "display:block"
        var imgStyle = imgDisplay + img.style.cssText
        if (img.align == "left") imgStyle = "float:left;" + imgStyle
        if (img.align == "right") imgStyle = "float:right;" + imgStyle
        if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
        var strNewHTML = "<span " + imgID + imgClass + imgTitle
        + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
        + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
        + "(src=\'" + img.src + "\', sizingMethod='image');\"></span>"
        img.outerHTML = strNewHTML;
        i = i-1;
      }
    }
  }
})

var Countdown = Class.create({
  initialize: function(opts) {
    var defaults = {
      periods : ["days", "hours", "minutes", "seconds"],
      lengths : ["86400","3600","60","1"],
      domContainer : '#countdown_container',
      beforeWidget: "",
      afterWidget: "",
      pad: false,
      numOfIntervalsToShow: 3,
      outputFormat: {
        days: "{days} day(s) ",
        hours: "{hours} hour(s) ",
        minutes: "{minutes} minute(s) ",
        seconds: "{seconds} second(s)"
      }
    };
    this.opts = Object.extend(defaults, opts);
    this.targetTime = Date.parse(this.opts.targetTime);
    this.timer = {};
    this._buildInitialDom();
    return this;
  },

  tick: function(){
    var now = new Date().getTime();
    var difference = (this.targetTime - now)/1000;
    var timeIntervalsArray = [];
    var storeIfZero = false;
    for(var j = 0; j < this.opts.periods.length; j++) {
      var timeHash = {};
      if(Math.ceil(difference) >= this.opts.lengths[j]){
        storeIfZero = true;
        var remainingTimeForInterval = Math.floor(difference / this.opts.lengths[j]);
        if(j > 1 && this.opts.pad && remainingTimeForInterval < 10)
          remainingTimeForInterval = "0" + remainingTimeForInterval;     
        timeHash[this.opts.periods[j]] =  remainingTimeForInterval;
        timeIntervalsArray.push(timeHash);  
        difference = (difference % this.opts.lengths[j]);
      }
      else if(storeIfZero) {
        timeHash[this.opts.periods[j]] =  this.opts.pad ? 00 : 0;
        timeIntervalsArray.push(timeHash);
      }
    }
    if(timeIntervalsArray.length > this.opts.numOfIntervalsToShow)
      timeIntervalsArray = timeIntervalsArray.splice(0, this.opts.numOfIntervalsToShow);
    var timeHash = timeIntervalsArray.inject({}, function(acc, obj) { return Object.extend(acc, obj); });
    this.update(timeHash);
    return timeHash;
  },

  start: function() {
    var self = this;
    this.tick();
    this.timer = setInterval(function(){ self.tick(); }, 1000);
    return self;
  },

  stop: function() {
    clearInterval(this.timer);
    return self;
  },

  update: function(timeHash) {
    var self = this;
    // if inserting into dom by dom parts
    if(typeof this.opts.domContainer == "object") {
      this.opts.periods.each(function(interval){
        if(timeHash[interval] != undefined){
          var tmpHash = {};
          tmpHash[interval] = timeHash[interval];
          $$(self.opts.domContainer.container +  " " + self.opts.domContainer[interval]).first().innerHTML = self.template(tmpHash);
        }
      });
    }
    else {
      var container = $$(this.opts.domContainer);
      //prototype compatibility
      if(container.first)
        container = container.first();
      container.update(this.opts.beforeWidget + this.template(timeHash) + this.opts.afterWidget)
    }
    return this;
  },
  
  template: function(obj) {
    var output = "";
    for(var interval in obj){
      var intervalTemplate = this.opts.outputFormat[interval].replace(/\((\w+)\)/g, function(a, b){
        return obj[interval] > 1 || obj[interval] == 0 ? b : "";
      })
      if(this.opts.outputFormat[interval])
        output += this.interpolate(intervalTemplate, obj)
    }
    return output
  },

  // Simple templating. This also exists as a prototype method we add to String, but putting
  // this here keeps Countdown without external dependencies.
  interpolate: function(string, o) {
    return string.replace(/{([^{}]*)}/g,
      function (a, b) {
        var r = o[b];
        return typeof r === 'string' || typeof r === 'number' ? r : a;
      }
    );
  },

  destroy: function() {
    clearInterval(this.timer);
    this.targetTime = null;
  },
  
  _buildInitialDom: function() {
    if(typeof this.opts.domContainer == "object") {
      $$(this.opts.domContainer.container).first().insert({top: this.opts.beforeWidget});
      $$(this.opts.domContainer.container).first().insert({bottom: this.opts.afterWidget});
    }
  }
});


/**
 * @author Ryan Johnson <http://syntacticx.com/>
 * @copyright 2008 PersonalGrid Corporation <http://personalgrid.com/>
 * @package LivePipe UI
 * @license MIT
 * @url http://livepipe.net/core
 * @require prototype.js
 */

if(typeof(Control) == 'undefined')
    Control = {};
    
var $proc = function(proc){
    return typeof(proc) == 'function' ? proc : function(){return proc};
};

var $value = function(value){
    return typeof(value) == 'function' ? value() : value;
};

Object.Event = {
    extend: function(object){
        object._objectEventSetup = function(event_name){
            this._observers = this._observers || {};
            this._observers[event_name] = this._observers[event_name] || [];
        };
        object.observe = function(event_name,observer){
            if(typeof(event_name) == 'string' && typeof(observer) != 'undefined'){
                this._objectEventSetup(event_name);
                if(!this._observers[event_name].include(observer))
                    this._observers[event_name].push(observer);
            }else
                for(var e in event_name)
                    this.observe(e,event_name[e]);
        };
        object.stopObserving = function(event_name,observer){
            this._objectEventSetup(event_name);
            if(event_name && observer)
                this._observers[event_name] = this._observers[event_name].without(observer);
            else if(event_name)
                this._observers[event_name] = [];
            else
                this._observers = {};
        };
        object.observeOnce = function(event_name,outer_observer){
            var inner_observer = function(){
                outer_observer.apply(this,arguments);
                this.stopObserving(event_name,inner_observer);
            }.bind(this);
            this._objectEventSetup(event_name);
            this._observers[event_name].push(inner_observer);
        };
        object.notify = function(event_name){
            this._objectEventSetup(event_name);
            var collected_return_values = [];
            var args = $A(arguments).slice(1);
            try{
                for(var i = 0; i < this._observers[event_name].length; ++i)
                    collected_return_values.push(this._observers[event_name][i].apply(this._observers[event_name][i],args) || null);
            }catch(e){
                if(e == $break)
                    return false;
                else
                    throw e;
            }
            return collected_return_values;
        };
        if(object.prototype){
            object.prototype._objectEventSetup = object._objectEventSetup;
            object.prototype.observe = object.observe;
            object.prototype.stopObserving = object.stopObserving;
            object.prototype.observeOnce = object.observeOnce;
            object.prototype.notify = function(event_name){
                if(object.notify){
                    var args = $A(arguments).slice(1);
                    args.unshift(this);
                    args.unshift(event_name);
                    object.notify.apply(object,args);
                }
                this._objectEventSetup(event_name);
                var args = $A(arguments).slice(1);
                var collected_return_values = [];
                try{
                    if(this.options && this.options[event_name] && typeof(this.options[event_name]) == 'function')
                        collected_return_values.push(this.options[event_name].apply(this,args) || null);
                    for(var i = 0; i < this._observers[event_name].length; ++i)
                        collected_return_values.push(this._observers[event_name][i].apply(this._observers[event_name][i],args) || null);
                }catch(e){
                    if(e == $break)
                        return false;
                    else
                        throw e;
                }
                return collected_return_values;
            };
        }
    }
};

/* Begin Core Extensions */

//Element.observeOnce
Element.addMethods({
    observeOnce: function(element,event_name,outer_callback){
        var inner_callback = function(){
            outer_callback.apply(this,arguments);
            Element.stopObserving(element,event_name,inner_callback);
        };
        Element.observe(element,event_name,inner_callback);
    }
});

//mouseenter, mouseleave
//from http://dev.rubyonrails.org/attachment/ticket/8354/event_mouseenter_106rc1.patch
Object.extend(Event, (function() {
    var cache = Event.cache;

    function getEventID(element) {
        if (element._prototypeEventID) return element._prototypeEventID[0];
        arguments.callee.id = arguments.callee.id || 1;
        return element._prototypeEventID = [++arguments.callee.id];
    }

    function getDOMEventName(eventName) {
        if (eventName && eventName.include(':')) return "dataavailable";
        //begin extension
        if(!Prototype.Browser.IE){
            eventName = {
                mouseenter: 'mouseover',
                mouseleave: 'mouseout'
            }[eventName] || eventName;
        }
        //end extension
        return eventName;
    }

    function getCacheForID(id) {
        return cache[id] = cache[id] || { };
    }

    function getWrappersForEventName(id, eventName) {
        var c = getCacheForID(id);
        return c[eventName] = c[eventName] || [];
    }

    function createWrapper(element, eventName, handler) {
        var id = getEventID(element);
        var c = getWrappersForEventName(id, eventName);
        if (c.pluck("handler").include(handler)) return false;

        var wrapper = function(event) {
            if (!Event || !Event.extend ||
                (event.eventName && event.eventName != eventName))
                    return false;

            Event.extend(event);
            handler.call(element, event);
        };
        
        //begin extension
        if(!(Prototype.Browser.IE) && ['mouseenter','mouseleave'].include(eventName)){
            wrapper = wrapper.wrap(function(proceed,event) {    
                var rel = event.relatedTarget;
                var cur = event.currentTarget;             
                if(rel && rel.nodeType == Node.TEXT_NODE)
                    rel = rel.parentNode;      
                if(rel && rel != cur && !rel.descendantOf(cur))      
                    return proceed(event);   
            });     
        }
        //end extension

        wrapper.handler = handler;
        c.push(wrapper);
        return wrapper;
    }

    function findWrapper(id, eventName, handler) {
        var c = getWrappersForEventName(id, eventName);
        return c.find(function(wrapper) { return wrapper.handler == handler });
    }

    function destroyWrapper(id, eventName, handler) {
        var c = getCacheForID(id);
        if (!c[eventName]) return false;
        c[eventName] = c[eventName].without(findWrapper(id, eventName, handler));
    }

    function destroyCache() {
        for (var id in cache)
            for (var eventName in cache[id])
                cache[id][eventName] = null;
    }

    if (window.attachEvent) {
        window.attachEvent("onunload", destroyCache);
    }

    return {
        observe: function(element, eventName, handler) {
            element = $(element);
            var name = getDOMEventName(eventName);

            var wrapper = createWrapper(element, eventName, handler);
            if (!wrapper) return element;

            if (element.addEventListener) {
                element.addEventListener(name, wrapper, false);
            } else {
                element.attachEvent("on" + name, wrapper);
            }

            return element;
        },

        stopObserving: function(element, eventName, handler) {
            element = $(element);
            var id = getEventID(element), name = getDOMEventName(eventName);

            if (!handler && eventName) {
                getWrappersForEventName(id, eventName).each(function(wrapper) {
                    element.stopObserving(eventName, wrapper.handler);
                });
                return element;

            } else if (!eventName) {
                Object.keys(getCacheForID(id)).each(function(eventName) {
                    element.stopObserving(eventName);
                });
                return element;
            }

            var wrapper = findWrapper(id, eventName, handler);
            if (!wrapper) return element;

            if (element.removeEventListener) {
                element.removeEventListener(name, wrapper, false);
            } else {
                element.detachEvent("on" + name, wrapper);
            }

            destroyWrapper(id, eventName, handler);

            return element;
        },

        fire: function(element, eventName, memo) {
            element = $(element);
            if (element == document && document.createEvent && !element.dispatchEvent)
                element = document.documentElement;

            var event;
            if (document.createEvent) {
                event = document.createEvent("HTMLEvents");
                event.initEvent("dataavailable", true, true);
            } else {
                event = document.createEventObject();
                event.eventType = "ondataavailable";
            }

            event.eventName = eventName;
            event.memo = memo || { };

            if (document.createEvent) {
                element.dispatchEvent(event);
            } else {
                element.fireEvent(event.eventType, event);
            }

            return Event.extend(event);
        }
    };
})());

Object.extend(Event, Event.Methods);

Element.addMethods({
    fire:            Event.fire,
    observe:        Event.observe,
    stopObserving:    Event.stopObserving
});

Object.extend(document, {
    fire:            Element.Methods.fire.methodize(),
    observe:        Element.Methods.observe.methodize(),
    stopObserving:    Element.Methods.stopObserving.methodize()
});

//mouse:wheel
(function(){
    function wheel(event){
        var delta;
        // normalize the delta
        if(event.wheelDelta) // IE & Opera
            delta = event.wheelDelta / 120;
        else if (event.detail) // W3C
            delta =- event.detail / 3;
        if(!delta)
            return;
        var custom_event = Event.element(event).fire('mouse:wheel',{
            delta: delta
        });
        if(custom_event.stopped){
            Event.stop(event);
            return false;
        }
    }
    document.observe('mousewheel',wheel);
    document.observe('DOMMouseScroll',wheel);
})();

/* End Core Extensions */

//from PrototypeUI
var IframeShim = Class.create({
    initialize: function() {
        this.element = new Element('iframe',{
            style: 'position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);display:none',
            src: 'javascript:void(0);',
            frameborder: 0 
        });
        $(document.body).insert(this.element);
    },
    hide: function() {
        this.element.hide();
        return this;
    },
    show: function() {
        this.element.show();
        return this;
    },
    positionUnder: function(element) {
        var element = $(element);
        var offset = element.cumulativeOffset();
        var dimensions = element.getDimensions();
        this.element.setStyle({
            left: offset[0] + 'px',
            top: offset[1] + 'px',
            width: dimensions.width + 'px',
            height: dimensions.height + 'px',
            zIndex: element.getStyle('zIndex') - 1
        }).show();
        return this;
    },
    setBounds: function(bounds) {
        for(prop in bounds)
            bounds[prop] += 'px';
        this.element.setStyle(bounds);
        return this;
    },
    destroy: function() {
        if(this.element)
            this.element.remove();
        return this;
    }
});

/**
 * @author Ryan Johnson <http://syntacticx.com/>
 * @copyright 2008 PersonalGrid Corporation <http://personalgrid.com/>
 * @package LivePipe UI
 * @license MIT
 * @url http://livepipe.net/control/window
 * @require prototype.js, effects.js, draggable.js, resizable.js, livepipe.js
 */

//adds onDraw and constrainToViewport option to draggable
if(typeof(Draggable) != 'undefined'){
    //allows the point to be modified with an onDraw callback
    Draggable.prototype.draw = function(point) {
        var pos = Position.cumulativeOffset(this.element);
        if(this.options.ghosting) {
            var r = Position.realOffset(this.element);
            pos[0] += r[0] - Position.deltaX; pos[1] += r[1] - Position.deltaY;
        }
        
        var d = this.currentDelta();
        pos[0] -= d[0]; pos[1] -= d[1];
        
        if(this.options.scroll && (this.options.scroll != window && this._isScrollChild)) {
            pos[0] -= this.options.scroll.scrollLeft-this.originalScrollLeft;
            pos[1] -= this.options.scroll.scrollTop-this.originalScrollTop;
        }
        
        var p = [0,1].map(function(i){ 
            return (point[i]-pos[i]-this.offset[i]) 
        }.bind(this));
        
        if(this.options.snap) {
            if(typeof this.options.snap == 'function') {
                p = this.options.snap(p[0],p[1],this);
            } else {
                if(this.options.snap instanceof Array) {
                    p = p.map( function(v, i) {return Math.round(v/this.options.snap[i])*this.options.snap[i] }.bind(this))
                } else {
                    p = p.map( function(v) {return Math.round(v/this.options.snap)*this.options.snap }.bind(this))
                  }
            }
        }
        
        if(this.options.onDraw)
            this.options.onDraw.bind(this)(p);
        else{
            var style = this.element.style;
            if(this.options.constrainToViewport){
                var viewport_dimensions = document.viewport.getDimensions();
                var container_dimensions = this.element.getDimensions();
                var margin_top = parseInt(this.element.getStyle('margin-top'));
                var margin_left = parseInt(this.element.getStyle('margin-left'));
                var boundary = [[
                    0 - margin_left,
                    0 - margin_top
                ],[
                    (viewport_dimensions.width - container_dimensions.width) - margin_left,
                    (viewport_dimensions.height - container_dimensions.height) - margin_top
                ]];
                if((!this.options.constraint) || (this.options.constraint=='horizontal')){ 
                    if((p[0] >= boundary[0][0]) && (p[0] <= boundary[1][0]))
                        this.element.style.left = p[0] + "px";
                    else
                        this.element.style.left = ((p[0] < boundary[0][0]) ? boundary[0][0] : boundary[1][0]) + "px";
                } 
                if((!this.options.constraint) || (this.options.constraint=='vertical')){ 
                    if((p[1] >= boundary[0][1] ) && (p[1] <= boundary[1][1]))
                        this.element.style.top = p[1] + "px";
                  else
                        this.element.style.top = ((p[1] <= boundary[0][1]) ? boundary[0][1] : boundary[1][1]) + "px";               
                }
            }else{
                if((!this.options.constraint) || (this.options.constraint=='horizontal'))
                  style.left = p[0] + "px";
                if((!this.options.constraint) || (this.options.constraint=='vertical'))
                  style.top     = p[1] + "px";
            }
            if(style.visibility=="hidden")
                style.visibility = ""; // fix gecko rendering
        }
    };
}

if(typeof(Prototype) == "undefined")
    throw "Control.Window requires Prototype to be loaded.";
if(typeof(IframeShim) == "undefined")
    throw "Control.Window requires IframeShim to be loaded.";
if(typeof(Object.Event) == "undefined")
    throw "Control.Window requires Object.Event to be loaded.";
/*
    known issues:
        - when iframe is clicked is does not gain focus
        - safari can't open multiple iframes properly
        - constrainToViewport: body must have no margin or padding for this to work properly
        - iframe will be mis positioned during fade in
        - document.viewport does not account for scrollbars (this will eventually be fixed in the prototype core)
    notes
        - setting constrainToViewport only works when the page is not scrollable
        - setting draggable: true will negate the effects of position: center
*/
Control.Window = Class.create({
    initialize: function(container,options){
        Control.Window.windows.push(this);
        
        //attribute initialization
        this.container = false;
        this.isOpen = false;
        this.href = false;
        this.sourceContainer = false; //this is optionally the container that will open the window
        this.ajaxRequest = false;
        this.remoteContentLoaded = false; //this is set when the code to load the remote content is run, onRemoteContentLoaded is fired when the connection is closed
        this.numberInSequence = Control.Window.windows.length + 1; //only useful for the effect scoping
        this.indicator = false;
        this.effects = {
            fade: false,
            appear: false
        };
        this.indicatorEffects = {
            fade: false,
            appear: false
        };
        
        //options
        this.options = Object.extend({
            //lifecycle
            beforeOpen: Prototype.emptyFunction,
            afterOpen: Prototype.emptyFunction,
            beforeClose: Prototype.emptyFunction,
            afterClose: Prototype.emptyFunction,
            //dimensions and modes
            height: null,
            width: null,
            className: false,
            position: 'center', //'center', 'relative', [x,y], [function(){return x;},function(){return y;}]
            offsetLeft: 0, //available only for anchors opening the window, or windows set to position: hover
            offsetTop: 0, //""
            iframe: false, //if the window has an href, this will display the href as an iframe instead of requesting the url as an an Ajax.Request
            hover: false, //element object to hover over, or if "true" only available for windows with sourceContainer (an anchor or any element already on the page with an href attribute)
            indicator: false, //element to show or hide when ajax requests, images and iframes are loading
            closeOnClick: false, //does not work with hover,can be: true (click anywhere), 'container' (will refer to this.container), or element (a specific element)
            iframeshim: true, //whether or not to position an iFrameShim underneath the window 
            //effects
            fade: false,
            fadeDuration: 0.75,
            //draggable
            draggable: false,
            onDrag: Prototype.emptyFunction,
            //resizable
            resizable: false,
            minHeight: false,
            minWidth: false,
            maxHeight: false,
            maxWidth: false,
            onResize: Prototype.emptyFunction,
            //draggable and resizable
            constrainToViewport: false,
            //ajax
            method: 'post',
            parameters: {},
            onComplete: Prototype.emptyFunction,
            onSuccess: Prototype.emptyFunction,
            onFailure: Prototype.emptyFunction,
            onException: Prototype.emptyFunction,
            //any element with an href (image,iframe,ajax) will call this after it is done loading
            onRemoteContentLoaded: Prototype.emptyFunction,
            insertRemoteContentAt: false //false will set this to this.container, can be string selector (first returned will be selected), or an Element that must be a child of this.container
        },options || {});
        
        //container setup
        this.indicator = this.options.indicator ? $(this.options.indicator) : false;
        if(container){
            if(typeof(container) == "string" && container.match(Control.Window.uriRegex))
                this.href = container;
            else{
                this.container = $(container);
                //need to create the container now for tooltips (or hover: element with no container already on the page)
                //second call made below will not create the container since the check is done inside createDefaultContainer()
                this.createDefaultContainer(container);
                //if an element with an href was passed in we use it to activate the window
                if(this.container && ((this.container.readAttribute('href') && this.container.readAttribute('href') != '') || (this.options.hover && this.options.hover !== true))){                        
                    if(this.options.hover && this.options.hover !== true)
                        this.sourceContainer = $(this.options.hover);
                    else{
                        this.sourceContainer = this.container;
                        this.href = this.container.readAttribute('href');
                        var rel = this.href.match(/^#(.+)$/);
                        if(rel && rel[1]){
                            this.container = $(rel[1]);
                            this.href = false;
                        }else
                            this.container = false;
                    }
                    //hover or click handling
                    this.sourceContainerOpenHandler = function(event){
                        this.open(event);
                        event.stop();
                        return false;
                    }.bindAsEventListener(this);
                    this.sourceContainerCloseHandler = function(event){
                        this.close(event);
                    }.bindAsEventListener(this);
                    this.sourceContainerMouseMoveHandler = function(event){
                        this.position(event);
                    }.bindAsEventListener(this);
                    if(this.options.hover){
                        this.sourceContainer.observe('mouseenter',this.sourceContainerOpenHandler);
                        this.sourceContainer.observe('mouseleave',this.sourceContainerCloseHandler);
                        if(this.options.position == 'mouse')
                            this.sourceContainer.observe('mousemove',this.sourceContainerMouseMoveHandler);
                    }else
                        this.sourceContainer.observe('click',this.sourceContainerOpenHandler);
                }
            }
        }
        this.createDefaultContainer(container);
        if(this.options.insertRemoteContentAt === false)
            this.options.insertRemoteContentAt = this.container;
        var styles = {
            margin: 0,
            position: 'absolute',
            zIndex: Control.Window.initialZIndexForWindow()
        };
        if(this.options.width)
            styles.width = $value(this.options.width) + 'px';
        if(this.options.height)
            styles.height = $value(this.options.height) + 'px';
        this.container.setStyle(styles);
        if(this.options.className)
            this.container.addClassName(this.options.className);
        this.positionHandler = this.position.bindAsEventListener(this);
        this.outOfBoundsPositionHandler = this.ensureInBounds.bindAsEventListener(this);
        this.bringToFrontHandler = this.bringToFront.bindAsEventListener(this);
        this.container.observe('mousedown',this.bringToFrontHandler);
        this.container.hide();
        this.closeHandler = this.close.bindAsEventListener(this);
        //iframeshim setup
        if(this.options.iframeshim){
            this.iFrameShim = new IframeShim();
            this.iFrameShim.hide();
        }
        //resizable support
        this.applyResizable();
        //draggable support
        this.applyDraggable();
        
        //makes sure the window can't go out of bounds
        Event.observe(window,'resize',this.outOfBoundsPositionHandler);
        
        this.notify('afterInitialize');
    },
    open: function(event){
        if(this.isOpen){
            this.bringToFront();
            return false;
        }
        if(this.notify('beforeOpen') === false)
            return false;
        //closeOnClick
        if(this.options.closeOnClick){
            if(this.options.closeOnClick === true)
                this.closeOnClickContainer = $(document.body);
            else if(this.options.closeOnClick == 'container')
                this.closeOnClickContainer = this.container;
            else if (this.options.closeOnClick == 'overlay'){
                Control.Overlay.load();
                this.closeOnClickContainer = Control.Overlay.container;
            }else
                this.closeOnClickContainer = $(this.options.closeOnClick);
            this.closeOnClickContainer.observe('click',this.closeHandler);
        }
        if(this.href && !this.options.iframe && !this.remoteContentLoaded){
            //link to image
            this.remoteContentLoaded = true;
            if(this.href.match(/\.(jpe?g|gif|png|tiff?)$/i)){
                var img = new Element('img');
                img.observe('load',function(img){
                    this.getRemoteContentInsertionTarget().insert(img);
                    this.position();
                    if(this.notify('onRemoteContentLoaded') !== false){
                        if(this.options.indicator)
                            this.hideIndicator();
                        this.finishOpen();
                    }
                }.bind(this,img));
                img.writeAttribute('src',this.href);
            }else{
                //if this is an ajax window it will only open if the request is successful
                if(!this.ajaxRequest){
                    if(this.options.indicator)
                        this.showIndicator();
                    this.ajaxRequest = new Ajax.Request(this.href,{
                        method: this.options.method,
                        parameters: this.options.parameters,
                        onComplete: function(request){
                            this.notify('onComplete',request);
                            this.ajaxRequest = false;
                        }.bind(this),
                        onSuccess: function(request){
                            this.getRemoteContentInsertionTarget().insert(request.responseText);
                            this.notify('onSuccess',request);
                            if(this.notify('onRemoteContentLoaded') !== false){
                                if(this.options.indicator)
                                    this.hideIndicator();
                                this.finishOpen();
                            }
                        }.bind(this),
                        onFailure: function(request){
                            this.notify('onFailure',request);
                            if(this.options.indicator)
                                this.hideIndicator();
                        }.bind(this),
                        onException: function(request,e){
                            this.notify('onException',request,e);
                            if(this.options.indicator)
                                this.hideIndicator();
                        }.bind(this)
                    });
                }
            }
            return true;
        }else if(this.options.iframe && !this.remoteContentLoaded){
            //iframe
            this.remoteContentLoaded = true;
            if(this.options.indicator)
                this.showIndicator();
            this.getRemoteContentInsertionTarget().insert(Control.Window.iframeTemplate.evaluate({
                href: this.href
            }));
            var iframe = this.container.down('iframe');
            iframe.onload = function(){
                this.notify('onRemoteContentLoaded');
                if(this.options.indicator)
                    this.hideIndicator();
                iframe.onload = null;
            }.bind(this);
        }
        this.finishOpen(event);
        return true
    },
    close: function(event){ //event may or may not be present
        if(!this.isOpen || this.notify('beforeClose',event) === false)
            return false;
        if(this.options.closeOnClick)
            this.closeOnClickContainer.stopObserving('click',this.closeHandler);
        if(this.options.fade){
            this.effects.fade = new Effect.Fade(this.container,{
                queue: {
                    position: 'front',
                    scope: 'Control.Window' + this.numberInSequence
                },
                from: 1,
                to: 0,
                duration: this.options.fadeDuration / 2,
                afterFinish: function(){
                    if(this.iFrameShim)
                        this.iFrameShim.hide();
                    this.isOpen = false;
                    this.notify('afterClose');
                }.bind(this)
            });
        }else{
            this.container.hide();
            if(this.iFrameShim)
                this.iFrameShim.hide();
        }
        if(this.ajaxRequest)
            this.ajaxRequest.transport.abort();
        if(!(this.options.draggable || this.options.resizable) && this.options.position == 'center')
            Event.stopObserving(window,'resize',this.positionHandler);
        if(!this.options.draggable && this.options.position == 'center')
            Event.stopObserving(window,'scroll',this.positionHandler);
        if(this.options.indicator)
            this.hideIndicator();
        if(!this.options.fade){
            this.isOpen = false;
            this.notify('afterClose');
        }
        return true;
    },
    position: function(event){
        //this is up top for performance reasons
        if(this.options.position == 'mouse'){
            var xy = [Event.pointerX(event),Event.pointerY(event)];
            this.container.setStyle({
                top: xy[1] + $value(this.options.offsetTop) + 'px',
                left: xy[0] + $value(this.options.offsetLeft) + 'px'
            });
            return;
        }
        var container_dimensions = this.container.getDimensions();
        var viewport_dimensions = document.viewport.getDimensions();
        Position.prepare();
        var offset_left = (Position.deltaX + Math.floor((viewport_dimensions.width - container_dimensions.width) / 2));
        var offset_top = (Position.deltaY + ((viewport_dimensions.height > container_dimensions.height) ? Math.floor((viewport_dimensions.height - container_dimensions.height) / 2) : 0));
        if(this.options.position == 'center'){
            this.container.setStyle({
                top: (container_dimensions.height <= viewport_dimensions.height) ? ((offset_top != null && offset_top > 0) ? offset_top : 0) + 'px' : 0,
                left: (container_dimensions.width <= viewport_dimensions.width) ? ((offset_left != null && offset_left > 0) ? offset_left : 0) + 'px' : 0
            });
        }else if(this.options.position == 'relative'){
            var xy = this.sourceContainer.cumulativeOffset();
            
            var top = xy[1] + $value(this.options.offsetTop);
            var left = xy[0] + $value(this.options.offsetLeft);
            this.container.setStyle({
                top: (container_dimensions.height <= viewport_dimensions.height) ? (this.options.constrainToViewport ? Math.max(0,Math.min(viewport_dimensions.height - (container_dimensions.height),top)) : top) + 'px' : 0,
                left: (container_dimensions.width <= viewport_dimensions.width) ? (this.options.constrainToViewport ? Math.max(0,Math.min(viewport_dimensions.width - (container_dimensions.width),left)) : left) + 'px' : 0
            });
        }else if(this.options.position.length){
            var top = $value(this.options.position[1]) + $value(this.options.offsetTop);
            var left = $value(this.options.position[0]) + $value(this.options.offsetLeft);
            this.container.setStyle({
                top: (container_dimensions.height <= viewport_dimensions.height) ? (this.options.constrainToViewport ? Math.max(0,Math.min(viewport_dimensions.height - (container_dimensions.height),top)) : top) + 'px' : 0,
                left: (container_dimensions.width <= viewport_dimensions.width) ? (this.options.constrainToViewport ? Math.max(0,Math.min(viewport_dimensions.width - (container_dimensions.width),left)) : left) + 'px' : 0
            });
        }
        if(this.iFrameShim)
            this.updateIFrameShimZIndex();
    },
    ensureInBounds: function(){
        if(!this.isOpen)
            return;
        var viewport_dimensions = document.viewport.getDimensions();
        var container_offset = this.container.cumulativeOffset();
        var container_dimensions = this.container.getDimensions();
        if(container_offset.left + container_dimensions.width > viewport_dimensions.width){
            this.container.setStyle({
                left: (Math.max(0,viewport_dimensions.width - container_dimensions.width)) + 'px'
            });
        }
        if(container_offset.top + container_dimensions.height > viewport_dimensions.height){
            this.container.setStyle({
                top: (Math.max(0,viewport_dimensions.height - container_dimensions.height)) + 'px'
            });
        }
    },
    bringToFront: function(){
        Control.Window.bringToFront(this);
        this.notify('bringToFront');
    },
    destroy: function(){
        this.container.stopObserving('mousedown',this.bringToFrontHandler);
        if(this.draggable){
            Draggables.removeObserver(this.container);
            this.draggable.handle.stopObserving('mousedown',this.bringToFrontHandler);
            this.draggable.destroy();
        }
        if(this.resizable){
            Resizables.removeObserver(this.container);
            this.resizable.handle.stopObserving('mousedown',this.bringToFrontHandler);
            this.resizable.destroy();
        }
        if(this.container && !this.sourceContainer)
            this.container.remove();
        if(this.sourceContainer){
            if(this.options.hover){
                this.sourceContainer.stopObserving('mouseenter',this.sourceContainerOpenHandler);
                this.sourceContainer.stopObserving('mouseleave',this.sourceContainerCloseHandler);
                if(this.options.position == 'mouse')
                    this.sourceContainer.stopObserving('mousemove',this.sourceContainerMouseMoveHandler);
            }else
                this.sourceContainer.stopObserving('click',this.sourceContainerOpenHandler);
        }
        if(this.iFrameShim)
            this.iFrameShim.destroy();
        Event.stopObserving(window,'resize',this.outOfBoundsPositionHandler);
        Control.Window.windows = Control.Window.windows.without(this);
        this.notify('afterDestroy');
    },
    //private
    applyResizable: function(){
        if(this.options.resizable){
            if(typeof(Resizable) == "undefined")
                throw "Control.Window requires resizable.js to be loaded.";
            var resizable_handle = null;
            if(this.options.resizable === true){
                resizable_handle = new Element('div',{
                    className: 'resizable_handle'
                });
                this.container.insert(resizable_handle);
            }else
                resizable_handle = $(this.options.resziable);
            this.resizable = new Resizable(this.container,{
                handle: resizable_handle,
                minHeight: this.options.minHeight,
                minWidth: this.options.minWidth,
                maxHeight: this.options.constrainToViewport ? function(element){
                    //viewport height - top - total border height
                    return (document.viewport.getDimensions().height - parseInt(element.style.top || 0)) - (element.getHeight() - parseInt(element.style.height || 0));
                } : this.options.maxHeight,
                maxWidth: this.options.constrainToViewport ? function(element){
                    //viewport width - left - total border width
                    return (document.viewport.getDimensions().width - parseInt(element.style.left || 0)) - (element.getWidth() - parseInt(element.style.width || 0));
                } : this.options.maxWidth
            });
            this.resizable.handle.observe('mousedown',this.bringToFrontHandler);
            Resizables.addObserver(new Control.Window.LayoutUpdateObserver(this,function(){
                if(this.iFrameShim)
                    this.updateIFrameShimZIndex();
                this.notify('onResize');
            }.bind(this)));
        }
    },
    applyDraggable: function(){
        if(this.options.draggable){
            if(typeof(Draggables) == "undefined")
                throw "Control.Window requires dragdrop.js to be loaded.";
            var draggable_handle = null;
            if(this.options.draggable === true){
                draggable_handle = new Element('div',{
                    className: 'draggable_handle'
                });
                this.container.insert(draggable_handle);
            }else
                draggable_handle = $(this.options.draggable);
            this.draggable = new Draggable(this.container,{
                handle: draggable_handle,
                constrainToViewport: this.options.constrainToViewport,
                zindex: this.container.getStyle('z-index'),
                starteffect: function(){
                    if(Prototype.Browser.IE){
                        this.old_onselectstart = document.onselectstart;
                        document.onselectstart = function(){
                            return false;
                        };
                    }
                }.bind(this),
                endeffect: function(){
                    document.onselectstart = this.old_onselectstart;
                }.bind(this)
            });
            this.draggable.handle.observe('mousedown',this.bringToFrontHandler);
            Draggables.addObserver(new Control.Window.LayoutUpdateObserver(this,function(){
                if(this.iFrameShim)
                    this.updateIFrameShimZIndex();
                this.notify('onDrag');
            }.bind(this)));
        }
    },
    createDefaultContainer: function(container){
        if(!this.container){
            //no container passed or found, create it
            this.container = new Element('div',{
                id: 'control_window_' + this.numberInSequence
            });
            $(document.body).insert(this.container);
            if(typeof(container) == "string" && $(container) == null && !container.match(/^#(.+)$/) && !container.match(Control.Window.uriRegex))
                this.container.update(container);
        }
    },
    finishOpen: function(event){
        this.bringToFront();
        if(this.options.fade){
            if(typeof(Effect) == "undefined")
                throw "Control.Window requires effects.js to be loaded."
            if(this.effects.fade)
                this.effects.fade.cancel();
            this.effects.appear = new Effect.Appear(this.container,{
                queue: {
                    position: 'end',
                    scope: 'Control.Window.' + this.numberInSequence
                },
                from: 0,
                to: 1,
                duration: this.options.fadeDuration / 2,
                afterFinish: function(){
                    if(this.iFrameShim)
                        this.updateIFrameShimZIndex();
                    this.isOpen = true;
                    this.notify('afterOpen');
                }.bind(this)
            });
        }else
            this.container.show();
        this.position(event);
        if(!(this.options.draggable || this.options.resizable) && this.options.position == 'center')
            Event.observe(window,'resize',this.positionHandler,false);
        if(!this.options.draggable && this.options.position == 'center')
            Event.observe(window,'scroll',this.positionHandler,false);
        if(!this.options.fade){
            this.isOpen = true;
            this.notify('afterOpen');
        }
        return true;
    },
    showIndicator: function(){
        this.showIndicatorTimeout = window.setTimeout(function(){
            if(this.options.fade){
                this.indicatorEffects.appear = new Effect.Appear(this.indicator,{
                    queue: {
                        position: 'front',
                        scope: 'Control.Window.indicator.' + this.numberInSequence
                    },
                    from: 0,
                    to: 1,
                    duration: this.options.fadeDuration / 2
                });
            }else
                this.indicator.show();
        }.bind(this),Control.Window.indicatorTimeout);
    },
    hideIndicator: function(){
        if(this.showIndicatorTimeout)
            window.clearTimeout(this.showIndicatorTimeout);
        this.indicator.hide();
    },
    getRemoteContentInsertionTarget: function(){
        return typeof(this.options.insertRemoteContentAt) == "string" ? this.container.down(this.options.insertRemoteContentAt) : $(this.options.insertRemoteContentAt);
    },
    updateIFrameShimZIndex: function(){
        if(this.iFrameShim)
            this.iFrameShim.positionUnder(this.container);
    }
});
//class methods
Object.extend(Control.Window,{
    windows: [],
    baseZIndex: 9999,
    indicatorTimeout: 250,
    iframeTemplate: new Template('<iframe src="#{href}" width="100%" height="100%" frameborder="0"></iframe>'),
    uriRegex: /^(\/|\#|https?\:\/\/|[\w]+\/)/,
    bringToFront: function(w){
        Control.Window.windows = Control.Window.windows.without(w);
        Control.Window.windows.push(w);
        Control.Window.windows.each(function(w,i){
            var z_index = Control.Window.baseZIndex + i;
            w.container.setStyle({
                zIndex: z_index
            });
            if(w.isOpen){
                if(w.iFrameShim)
                w.updateIFrameShimZIndex();
            }
            if(w.options.draggable)
                w.draggable.options.zindex = z_index;
        });
    },
    open: function(container,options){
        var w = new Control.Window(container,options);
        w.open();
        return w;
    },
    //protected
    initialZIndexForWindow: function(w){
        return Control.Window.baseZIndex + (Control.Window.windows.length - 1);
    }
});
Object.Event.extend(Control.Window);

//this is the observer for both Resizables and Draggables
Control.Window.LayoutUpdateObserver = Class.create({
    initialize: function(w,observer){
        this.w = w;
        this.element = $(w.container);
        this.observer = observer;
    },
    onStart: Prototype.emptyFunction,
    onEnd: function(event_name,instance){
        if(instance.element == this.element && this.iFrameShim)
            this.w.updateIFrameShimZIndex();
    },
    onResize: function(event_name,instance){
        if(instance.element == this.element)
            this.observer(this.element);
    },
    onDrag: function(event_name,instance){
        if(instance.element == this.element)
            this.observer(this.element);
    }
});

//overlay for Control.Modal
Control.Overlay = {
    id: 'control_overlay',
    loaded: false,
    container: false,
    lastOpacity: 0,
    styles: {
        position: 'fixed',
        top: 0,
        left: 0,
        width: '100%',
        height: '100%',
        zIndex: 9998
    },
    ieStyles: {
        position: 'absolute',
        top: 0,
        left: 0,
        zIndex: 9998
    },
    effects: {
        fade: false,
        appear: false
    },
    load: function(){
        if(Control.Overlay.loaded)
            return false;
        Control.Overlay.loaded = true;
        Control.Overlay.container = new Element('div',{
            id: Control.Overlay.id
        });
        $(document.body).insert(Control.Overlay.container);
        if(Prototype.Browser.IE){
            Control.Overlay.container.setStyle(Control.Overlay.ieStyles);
            Event.observe(window,'scroll',Control.Overlay.positionOverlay);
            Event.observe(window,'resize',Control.Overlay.positionOverlay);
            Control.Overlay.observe('beforeShow',Control.Overlay.positionOverlay);
        }else
            Control.Overlay.container.setStyle(Control.Overlay.styles);
        Control.Overlay.iFrameShim = new IframeShim();
        Control.Overlay.iFrameShim.hide();
        Event.observe(window,'resize',Control.Overlay.positionIFrameShim);
        Control.Overlay.container.hide();
        return true;
    },
    unload: function(){
        if(!Control.Overlay.loaded)
            return false;
        Event.stopObserving(window,'resize',Control.Overlay.positionOverlay);
        Control.Overlay.stopObserving('beforeShow',Control.Overlay.positionOverlay);
        Event.stopObserving(window,'resize',Control.Overlay.positionIFrameShim);
        Control.Overlay.iFrameShim.destroy();
        Control.Overlay.container.remove();
        Control.Overlay.loaded = false;
        return true;
    },
    show: function(opacity,fade){
        if(Control.Overlay.notify('beforeShow') === false)
            return false;
        Control.Overlay.lastOpacity = opacity;
        Control.Overlay.positionIFrameShim();
        Control.Overlay.iFrameShim.show();
        if(fade){
            if(typeof(Effect) == "undefined")
                throw "Control.Window requires effects.js to be loaded."
            if(Control.Overlay.effects.fade)
                Control.Overlay.effects.fade.cancel();
            Control.Overlay.effects.appear = new Effect.Appear(Control.Overlay.container,{
                queue: {
                    position: 'end',
                    scope: 'Control.Overlay'
                },
                afterFinish: function(){
                    Control.Overlay.notify('afterShow');
                },
                from: 0,
                to: Control.Overlay.lastOpacity,
                duration: (fade === true ? 0.75 : fade) / 2
            });
        }else{
            Control.Overlay.container.setStyle({
                opacity: opacity || 1
            });
            Control.Overlay.container.show();
            Control.Overlay.notify('afterShow');
        }
        return true;
    },
    hide: function(fade){
        if(Control.Overlay.notify('beforeHide') === false)
            return false;
        if(Control.Overlay.effects.appear)
            Control.Overlay.effects.appear.cancel();
        Control.Overlay.iFrameShim.hide();
        if(fade){
            Control.Overlay.effects.fade = new Effect.Fade(Control.Overlay.container,{
                queue: {
                    position: 'front',
                    scope: 'Control.Overlay'
                },
                afterFinish: function(){
                    Control.Overlay.notify('afterHide');
                },
                from: Control.Overlay.lastOpacity,
                to: 0,
                duration: (fade === true ? 0.75 : fade) / 2
            });
        }else{
            Control.Overlay.container.hide();
            Control.Overlay.notify('afterHide');
        }
        return true;
    },
    positionIFrameShim: function(){
        if(Control.Overlay.container.visible())
            Control.Overlay.iFrameShim.positionUnder(Control.Overlay.container);
    },
    //IE only
    positionOverlay: function(){
        Control.Overlay.container.setStyle({
            width: document.body.clientWidth + 'px',
            height: document.body.clientHeight + 'px'
        });
    }
};
Object.Event.extend(Control.Overlay);

Control.ToolTip = Class.create(Control.Window,{
    initialize: function($super,container,tooltip,options){
        $super(tooltip,Object.extend(Object.extend(Object.clone(Control.ToolTip.defaultOptions),options || {}),{
            position: 'mouse',
            hover: container
        }));
    }
});
Object.extend(Control.ToolTip,{
    defaultOptions: {
        offsetLeft: 10
    }
});

Control.Modal = Class.create(Control.Window,{
    initialize: function($super,container,options){
        Control.Modal.InstanceMethods.beforeInitialize.bind(this)();
        $super(container,Object.extend(Object.clone(Control.Modal.defaultOptions),options || {}));
    }
});
Object.extend(Control.Modal,{
    defaultOptions: {
        overlayOpacity: 0.5,
        closeOnClick: 'overlay'
    },
    current: false,
    open: function(container,options){
        var modal = new Control.Modal(container,options);
        modal.open();
        return modal;
    },
    close: function(){
        if(Control.Modal.current)
            Control.Modal.current.close();
    },
    InstanceMethods: {
        beforeInitialize: function(){
            Control.Overlay.load();
            this.overlayFinishedOpening = false;
            this.observe('beforeOpen',Control.Modal.Observers.beforeOpen.bind(this));
            this.observe('afterOpen',Control.Modal.Observers.afterOpen.bind(this));
            this.observe('afterClose',Control.Modal.Observers.afterClose.bind(this));
        }
    },
    Observers: {
        beforeOpen: function(){
            if(!this.overlayFinishedOpening){
                Control.Overlay.observeOnce('afterShow',function(){
                    this.overlayFinishedOpening = true;
                    this.open();
                }.bind(this));
                Control.Overlay.show(this.options.overlayOpacity,this.options.fade ? this.options.fadeDuration : false);
                throw $break;
            }else
            Control.Window.windows.without(this).invoke('close');
        },
        afterOpen: function(){
            Control.Modal.current = this;
        },
        afterClose: function(){
            Control.Overlay.hide(this.options.fade ? this.options.fadeDuration : false);
            Control.Modal.current = false;
            this.overlayFinishedOpening = false;
        }
    }
});

Control.LightBox = Class.create(Control.Window,{
    initialize: function($super,container,options){
        this.allImagesLoaded = false;
        if(options.modal){
            var options = Object.extend(Object.clone(Control.LightBox.defaultOptions),options || {});
            options = Object.extend(Object.clone(Control.Modal.defaultOptions),options);
            options = Control.Modal.InstanceMethods.beforeInitialize.bind(this)(options);
            $super(container,options);
        }else
            $super(container,Object.extend(Object.clone(Control.LightBox.defaultOptions),options || {}));
        this.hasRemoteContent = this.href && !this.options.iframe;
        if(this.hasRemoteContent)
            this.observe('onRemoteContentLoaded',Control.LightBox.Observers.onRemoteContentLoaded.bind(this));
        else
            this.applyImageObservers();
        this.observe('beforeOpen',Control.LightBox.Observers.beforeOpen.bind(this));
    },
    applyImageObservers:function(){
        var images = this.getImages();
        this.numberImagesToLoad = images.length;
        this.numberofImagesLoaded = 0;
        images.each(function(image){
            image.observe('load',function(image){
                ++this.numberofImagesLoaded;
                if(this.numberImagesToLoad == this.numberofImagesLoaded){
                    this.allImagesLoaded = true;
                    this.onAllImagesLoaded();
                }
            }.bind(this,image));
            image.hide();
        }.bind(this));
    },
    onAllImagesLoaded: function(){
        this.getImages().each(function(image){
            this.showImage(image);
        }.bind(this));
        if(this.hasRemoteContent){
            if(this.options.indicator)
                this.hideIndicator();
            this.finishOpen();
        }else
            this.open();
    },
    getImages: function(){
        return this.container.select(Control.LightBox.imageSelector);
    },
    showImage: function(image){
        image.show();
    }
});
Object.extend(Control.LightBox,{
    imageSelector: 'img',
    defaultOptions: {},
    Observers: {
        beforeOpen: function(){
            if(!this.hasRemoteContent && !this.allImagesLoaded)
                throw $break;
        },
        onRemoteContentLoaded: function(){
            this.applyImageObservers();
            if(!this.allImagesLoaded)
                throw $break;
        }
    }
});


/**
 * @author Ryan Johnson <http://syntacticx.com/>
 * @copyright 2008 PersonalGrid Corporation <http://personalgrid.com/>
 * @package LivePipe UI
 * @license MIT
 * @url http://livepipe.net/controls/hotkey/
 * @attribution http://www.quirksmode.org/js/cookies.html
 */

/*global document, Prototype, $A */


var Cookie = {
  build: function() {
    return $A(arguments).compact().join("; ");
  },
  secondsFromNow: function(seconds) {
    var d = new Date();
    d.setTime(d.getTime() + (seconds * 1000));
    return d.toGMTString();
  },
  set: function(name,value,seconds, domain){
    var expiry = seconds ? 'expires=' + Cookie.secondsFromNow(seconds) : null;
    var cookieDomain = domain ? 'domain=' + domain : null;
    document.cookie = Cookie.build(name + "=" + value, expiry, "path=/", cookieDomain);
  },
  get: function(name){
    var valueMatch = new RegExp(name + "=([^;]+)").exec(document.cookie);
    return valueMatch ? valueMatch[1] : null;
  },
  unset: function(name, domain){
    Cookie.set(name,'',-1, domain);
  }
};




Event.addBehavior({

  '#tracking_cookies': function() {
  
    if(Groupon.Attributes.tracking_cookies_to_delete)
      Groupon.Attributes.tracking_cookies_to_delete.evalJSON().each(function(cookie, i) {
        Cookie.unset(cookie.value, cookie.domain.replace(/:\d+/, ''));
      });
    
    $H(Groupon.Attributes.tracking_cookies).each(function(cookie_pair) {
      var expires = cookie_pair.value.expires ? (Date.parse(cookie_pair.value.expires) - new Date().getTime()) / 1000 : null;
      var domain = cookie_pair.value.domain ? cookie_pair.value.domain.replace(/:\d+/, '') : null;
      Cookie.set(cookie_pair.key, cookie_pair.value.value, expires, domain);
    });
  }


});



if (typeof Groupon.ui === 'undefined') Groupon.ui = {};

Groupon.ui.openFeedback = function(e) {
  e.stop();
  Zenbox.render();
};

Groupon.ui.onModalClose = function(func) {
  if(Control.Modal.current){
    $(document).observe("modal:closed", func);
  }
  else{
    func.call(this);
  }
};

Groupon.ui.SelectBoxBehavior = Behavior.create({
  initialize: function() {
    var self = this;
    this.open = false;
    if(!this.element.readAttribute('id'))
      this.element.writeAttribute('id', new Date().getTime());
    this.element.select("li:first-child").invoke("observe", "click", self.doToggle.bind(self));
    this.element.select("li:not(li:first-child) a").invoke("observe", "click", self.onSelect.bind(self));
    this.element.select('li:not(li:first-child)').invoke('hide');
    $$("body").first().observe("click", self.onWindowClick.bind(self));
  },
  
  doToggle: function(e) {
    e.stop();
    this.open ? this.doClose(e) : this.doOpen(e);
  },
  
  onSelect: function(e) {
    var clickedOn = $(e.target).up("li");
    var firstLi = $(this.element).select("li:first-child")

    if(clickedOn instanceof jQuery) {
      clickedOn = clickedOn.get(0);
      firstLi = firstLi.get(0);
    }

    if(clickedOn == firstLi) {
      e.stop();
      this.doToggle(e);
    }
    else {
      e.stop();
      var self = this;
      var selected = $(e.element()).up("li").remove().addClassName("with_bg selected").observe("click", self.doToggle.bind(self));
      $(this.element).select("li:first-child").invoke("removeClassName", "with_bg selected");
      $(this.element).insert({top: selected});
      this.doClose(e);
      window.location = e.target.href;
    }
  },
  
  onWindowClick: function(e) {
    if(($(e.target).up('#' + $(this.element).readAttribute('id'))).length == 0){
      this.doClose();
    }
  },
  
  doOpen: function(e) {
    $('#header').setStyle({ 'zIndex': 3 });
    $(this.element).select("li:not(li:first-child)").invoke("show");
    this.open = true;
  },
  
  doClose: function(e) {
    this.element.select("li:not(li:first-child)").invoke("hide");
    $('header').setStyle({ 'zIndex': null });
    this.open = false;
  }
});

var numericalTextFieldBehavior = Behavior.create({
  //add class of .numeric to any text field and this will restrict input to only numbers
  initialize: function(decimal) {
    this.decimal = decimal || ".";
  },
  onkeypress: function(e) {
    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    // allow enter/return key (only when in an input box)
    if(key == 13 && this.element.nodeName.toLowerCase() == "input")
    {
      return true;
    }
    else if(key == 13)
    {
      return false;
    }
    var allow = false;
    // allow Ctrl+A
    if((e.ctrlKey && key == 97 /* firefox */) || (e.ctrlKey && key == 65) /* opera */) return true;
    // allow Ctrl+X (cut)
    if((e.ctrlKey && key == 120 /* firefox */) || (e.ctrlKey && key == 88) /* opera */) return true;
    // allow Ctrl+C (copy)
    if((e.ctrlKey && key == 99 /* firefox */) || (e.ctrlKey && key == 67) /* opera */) return true;
    // allow Ctrl+Z (undo)
    if((e.ctrlKey && key == 122 /* firefox */) || (e.ctrlKey && key == 90) /* opera */) return true;
    // allow or deny Ctrl+V (paste), Shift+Ins
    if((e.ctrlKey && key == 118 /* firefox */) || (e.ctrlKey && key == 86) /* opera */
    || (e.shiftKey && key == 45)) return true;
    // if a number was not pressed
    if(key < 48 || key > 57)
    {
      /* '-' only allowed at start */
      if(key == 45 && this.element.value.length == 0) return true;
      /* only one decimal separator allowed */
      if(key == this.decimal.charCodeAt(0) && this.element.value.indexOf(this.decimal) != -1)
      {
        allow = false;
      }
      // check for other keys that have special purposes
      if(
        key != 8 /* backspace */ &&
        key != 9 /* tab */ &&
        key != 13 /* enter */ &&
        key != 35 /* end */ &&
        key != 36 /* home */ &&
        key != 37 /* left */ &&
        key != 39 /* right */ &&
        key != 46 /* del */
      )
      {
        allow = false;
      }
      else
      {
        // for detecting special keys (listed above)
        // IE does not support 'charCode' and ignores them in keypress anyway
        if(typeof e.charCode != "undefined")
        {
          // special keys have 'keyCode' and 'which' the same (e.g. backspace)
          if(e.keyCode == e.which && e.which != 0)
          {
            allow = true;
          }
          // or keyCode != 0 and 'charCode'/'which' = 0
          else if(e.keyCode != 0 && e.charCode == 0 && e.which == 0)
          {
            allow = true;
          }
        }
      }
      // if key pressed is the this.decimal and it is not already in the field
      if(key == this.decimal.charCodeAt(0) && this.element.value.indexOf(this.decimal) == -1)
      {
        allow = true;
      }
    }
    else
    {
      allow = true;
    }
    return allow;
  },
  onkeydown: function(e) {
    if (e.keyCode == Event.KEY_UP || e.keyCode == Event.KEY_DOWN) {
      e.stop();
      var newValue = this.element.getValue();
      if (newValue == '') newValue = 0;
      newValue = parseInt(newValue, 10);
      (e.keyCode == Event.KEY_UP) ? newValue++ : newValue--;
      if (newValue < 0) newValue = 0;
      this.element.setValue(newValue);
    }
  }
});

Groupon.TwitterWidget = function(opts){
  if (Groupon.Attributes.env == 'production')
    LazyLoader.load('http://widgets.twimg.com/j/2/widget.js', function(){
      return new TWTR.Widget({
        version: 2,
    		id: 'twitter-list-widget',
        type: 'list',
        rpp: 5,
        interval: 6000,
        title: 'Groupon Presents',
        subject: opts.title,
        width: 216,
        height: 300,
        theme: {
          shell: {
            background: '#fff',
            color: '#000'
          },
          tweets: {
            background: '#ffffff',
            color: '#444444',
            links: '#0980ca'
          }
        },
        features: {
          scrollbar: true,
          loop: false,
          live: true,
          hashtags: true,
          timestamp: true,
          avatars: true,
          behavior: 'all'
        }
      }).render().setList(opts.account, 'tweets-around-town').start();
    });
};

Groupon.BitlifiedLink = {
  originalUrl: null,
  pattern: null,

  // Bitlifies the standard-format Twitter message, which ends with a link
  // back to Groupon.
  twitter: function(e){
    pattern = new RegExp("http[s]?://(?:www\.)?twitter.com/.*?(http://.*$)");
    this.pattern = pattern;
    this.create(pattern, e);
  },

  // Bitlifies the standard-format Facebook message, which ends with a link
  // back to Groupon. Pass in the event
  facebook: function(e){
    e.stop();
    pattern = new RegExp("http[s]?://(?:www\.)?facebook.com/.*?(http://.*$)");
    this.pattern = pattern;
    this.create(pattern, e);
  },

  // Issues a #shorten request to Bitly with the section of the
  // request's URL which matches the supplied pattern and delegates the
  // response to BiltlyCB#popupWindowWithShortUrl.
  create: function(pattern, e){
    e.stop(); // stop the original click event so we don't go anywhere
    // Store the current URL so the callback can gain access to it
    // & replace the appropriate content with the new bit.ly URL.
    this.originalUrl = e.element().readAttribute('href');

    // If the user clicked one of the icons, the object may be an
    // '<img>' tag instead of an anchor tag...move up to the
    // encapsulating <a> tag
    if(e.element().inspect() == '<img>' && this.originalUrl == null) {
      this.originalUrl = e.element().up().readAttribute('href');
    }
    // Search for the supplied pattern in the request's URL. If a match
    // is found, send that URL to bit.ly to be shortened...and call
    // BiltlyCB.popupWindowWithShortUrl when the result is returned (the BitlyCB
    // namespace is required by the bit.ly JS library).
   
    var extracted = this.originalUrl.match(pattern);
    if((extracted != null) && (extracted.size(2))){
      Groupon.popup = window.open();
      BitlyClient.shorten(extracted[1], 'BitlyCB.popupWindowWithShortUrl');
    }
  }
};

var BitlyCB = {
  popupWindowWithShortUrl: function(data) {
    var first_result;
    var s = '';
    for( var r in data.results ) {
      first_result = data.results[r]; break;
    }

    var extracted = Groupon.BitlifiedLink.originalUrl.match(Groupon.BitlifiedLink.pattern);
    new_url = Groupon.BitlifiedLink.originalUrl.replace(extracted[1], first_result["shortUrl"]);

    // Open the new, nice URL in a new window ;-)
    Groupon.popup.location = new_url;
  },

  updateLinkWithShortUrl: function(data) {
    for( var r in data.results ) {
      var shortUrl = data.results[r]["shortUrl"];
      $$('a.bitlify.now[href=' + r + ']').each(function(link) {
        link.setAttribute('href', shortUrl);
        link.update(shortUrl);
      });
    }
  }
};

Groupon.ui.ClassEvents = {
  fire: function(key) {
      if (!this._events || !this._events[key]) return false;
      this._events[key].each( function(func) { func.apply(); });
      return true;
    },

  observe: function(key, func) {
    this._events = this._events || {};
    this._events[key] = this._events[key] || [];
    this._events[key].push( func.bind(this) );
    return this;
  }
};


/* Behavior to hide/show an element when a checkbox is checked/unchecked */
Groupon.ElementToggler = Behavior.create({
    initialize: function(element, opts) {
        this.elementToToggle = $(element);
        this.opts = opts || {};
        this.sync();
    },
    onchange: function(event) {
        this.sync();
    },
    sync: function() {
        if (this.element.checked) {
            this.show();
        } else {
            this.hide();
        }
    },
    show: function() {
        this.elementToToggle.show();
    },
    hide: function() {
        this.elementToToggle.hide();
        if(this.opts.afterClose)
          this.opts.afterClose.call(this, this);
    }
});

/* a specialized ElementToggler Behavior that adds enable/disable of any contained input elements 
* on hide/show to prevent posting of hidden elements
*/
Groupon.DisablingElementToggler = Behavior.create(Groupon.ElementToggler, {
    show: function($super) {
        $super();
        this.elementToToggle.select('input,select').invoke('enable');
    },
    hide: function($super) {
        $super();
        this.elementToToggle.select('input,select').invoke('disable');
    }
});

/* a specialized DisablingElementToggler Behavior that adds hide/show of another element in tandem 
* with the primary one; a swap view
*/
Groupon.SwappingElementToggler = Behavior.create(Groupon.DisablingElementToggler,{
  initialize:function($super, element, swapElement){
    this.swapElement = $(swapElement);
    $super(element);
  },
  show:function($super){
    $super();
    this.swapElement.hide();
    this.elementToToggle.select('input,select').invoke('disable')
  },
  hide: function($super){
    $super();
    this.swapElement.show();
    this.elementToToggle.select('input,select').invoke('enable');
  }
});

/* Behavior to hide/show an element when a link is clicked 
 * default behvior will be cancelled if triggering element has class disabled
 */
Groupon.LinkElementToggler = Behavior.create(Groupon.ElementToggler, {
  onclick: function(event) {
    event.stop();
    if (!this.disabled()) {
      if (this.elementToToggle.visible()) {
        this.hide();
        this.element.removeClassName('open');
      } else {
        this.show();
        this.element.addClassName('open');
      }
    }
  },
  sync: function() {
    // disable sync so it doesn't toggle on initialize
    // init code can go here for derived classes
    return true;
  },
  show: function() {
    this.elementToToggle.show(this.opts.speed, this.opts.afterShow);
  },
  hide: function() {
    this.elementToToggle.hide(this.opts.speed, this.opts.afterClose);
  },
  disabled: function() {
    return(this.element.hasClassName('disabled'));
  }
});

/* a specialized LinkElementToggler Behavior that adds enable/disable of any contained input elements 
* on hide/show to prevent posting of hidden elements
* define aftershow or afterhide options for callbacks
*/
Groupon.LinkDisablingElementToggler = Behavior.create(Groupon.LinkElementToggler, {
    initialize: function($super, element, options) {
      this.options = {};
      if (typeof options != "undefined") this.options = options;
      $super(element);
    },
    onclick: function($super, event) {
      if (this.disabled()) {
        if (this.options['ondisabledclick']) this.options['ondisabledclick'](this.element);
      }
      $super(event);
    },
    show: function($super) {
      $super();
      this.enableFields();
      if (this.options['aftershow']) this.options['aftershow'](this.element);
    },
    hide: function($super) {
      $super();
      this.disableFields();
      if (this.options['afterhide']) this.options['afterhide'](this.element);
    },
    sync: function () {
      if (this.elementToToggle.visible()) {
        this.enableFields();
      } else {
        this.disableFields();
      }
    },
    enableFields: function() {
      this.elementToToggle.select('input,select').invoke('enable');
    },
    disableFields: function() {
      this.elementToToggle.select('input,select').invoke('disable');
    }
});


/*
  to show textboxes for unit name and price per unit
*/
Groupon.DropdownElementToggler = Behavior.create(Groupon.DisablingElementToggler,{
  initialize: function($super, element, activeValue){
    this.activeValue = activeValue;
    $super(element);
  },
  sync: function() {
    if (this.element.value == this.activeValue) {
        this.show();
    } else {
        this.hide();
    }
  }
});


var Tooltip = Class.create({

  initialize: function(element, options) {
    this.options = Object.extend({
      delay: 0,
      position: 'bottomRight',
      relativeTo: 'Mouse'
    }, options || {});

    Object.extend(this, Groupon.ui.ClassEvents)

    this.element = $(element);

    if ((!this.element || this.element.nodeName.toLowerCase() != 'a') && !this.options.target)
      throw('ArgumentError: you must initialize Tooltip with an <a> element');

    this.mouseoutTimer = null;
    this.target = this.options.target || this.findTarget();
    if (!this.target) return;

    this.target.addClassName('tooltip_target');
    this.setupTooltip();
    this.setupEvents();
  },

  handleMousemove: function(event) {
    var base = {
      x: Event.pointerX(event) + 15,
      y: Event.pointerY(event)
    };
    var dimensions = this.tooltip.getDimensions();

    switch(this.options.position) {
      case 'bottomRight':
        break;
      case 'bottomLeft':
        base.x = base.x - dimensions.width;
        break;
      case 'centerLeft':
        base.x = base.x - dimensions.width - 25;
        base.y = base.y - dimensions.height / 2;
        break;
      case 'topLeft':
        base.x = base.x - dimensions.width;
        base.y = base.y - dimensions.height - 5;
        break;
      case 'topCenter': 
        base.x = base.x - (dimensions.width/2);
        base.y = base.y - dimensions.height - 10;
    }

    this.setPosition( base.x, base.y );
  },

  handleMouseout: function(event) {
    this.mouseoutTimer = this.hide.bind(this).delay(this.options.delay);
  },

  hide: function() {
    this.tooltip.removeClassName('showing');
  },

  setPosition: function(x, y) {
    if (typeof x == 'number') x += 'px';
    if (typeof y == 'number') y += 'px';
    this.tooltip.setStyle({ left: x, top: y });
  },

  setupEvents: function() {
    if (!this.options.target)
      this.element.observe('click', function(event) { event.stop(); });

    this.element.observe('mouseover', this.show.bind(this));
    this.tooltip.observe('mouseover', this.show.bind(this));

    this.element.observe('mouseout',  this.handleMouseout.bindAsEventListener(this));
    this.tooltip.observe('mouseout',  this.handleMouseout.bindAsEventListener(this));

    if (this.options.relativeTo == 'Mouse')
      this.element.observe('mousemove', this.handleMousemove.bindAsEventListener(this));
  },

  findTarget: function() {
    var fragment = this.element.getAttribute('href');
    return $( fragment.substring( fragment.indexOf('#') + 1 ) );
  },

  setupTooltip: function() {
    this.tooltip = new Element('div', { 'class': 'tooltip' });
    this.tooltip.addClassName(this.target.readAttribute('class'));
    this.tooltip.update(this.target.innerHTML);
    $(document.body).insert({ bottom: this.tooltip });
  },

  show: function() {
    clearTimeout(this.mouseoutTimer);
    this.tooltip.addClassName('showing');
    this.fire('show');
  }

});


var StickyElement = Class.create({
  
  initialize: function(element, options) {
    this.element = $(element);
    if(this.element.get)
      this.element = this.element.get(0);
    if (!this.element)
      throw('ArgumentError: you must initialize StickyElement with an element');
    
    this.options = Object.extend({
      offset: 0,
      containment: false,
      position: this.isIE() ? 'absolute' : 'fixed'
    }, options || {});

    this.isStuck  = false;
    this.isFrozen = false;
    this.top = $(this.element).viewportOffset().top;
    
    this.setupElement();
    this.setupContainer();
    if(this.options.containment)
      this.setupContainment();
    this.setupShim();
    this.setupEvents();
  },
  
  freeze: function() {
    if (!this.isStuck) return;
    
    this.preFreezeElementStyles = {
      'left': this.element.style.left,
      'top':  this.element.style.top
    };
    if(this.options.position == 'fixed') {
      if (this.preFreezeElementStyles.left == '') this.preFreezeElementStyles.left = null;
      if (this.preFreezeElementStyles.top  == '') this.preFreezeElementStyles.top  = null;
      this.container.addClassName('frozen');//.setStyle({width: this.element.getWidth() + 'px'});
      var topValue = document.viewport.getScrollOffsets()[1] + this.options.offset - $(this.container).cumulativeOffset().top;

      if(topValue < 0){
        topValue = 0;
      }
      $(this.element).setStyle({
        'top':  topValue + 'px'
      });

      if(this.containment && $(this.element).cumulativeOffset().top + $(this.element).getHeight() > this.containment[3])
        $(this.element).setStyle({
          top: parseInt($(this.element).getStyle('top')) - (($(this.element).cumulativeOffset().top + $(this.element).getHeight()) - this.containment[3]) + 'px'
        });
    }
    
    if(this.options.position == 'absolute') {
      //do nothing
    }
    this.isFrozen = true;
    this.isStuck = false;
  },
  
  getPosition: function() {
    var scroll = document.viewport.getScrollOffsets()[1];
    var top = 0;
    if(this.containment || (this.group && this.group.containment)) {
      var containment = this.containment || this.group.containment;
      if(scroll < containment[1]){
        top = 0;
      }
      
      else if(scroll > containment[3])
        top = 1000;
      else 
        top = scroll + this.options.offset - $(this.container).cumulativeOffset().top;
    }
    
    else {
      top = scroll + this.options.offset - $(this.container).cumulativeOffset().top;
    }
    return {
      top: top,
      left: 0
    };
  },

  isIE: function() {
    try{
      return $('html').hasClass('ie6');
    }
    catch(error){
      return false;
    }
    return false;
  },
  
  setupContainer: function() {
    if(typeof Prototype != 'undefined')
      this.container = new Element('div', { 'class': 'sticky_element_container sticky_element_container_' + $(this.element).readAttribute('id') });
    else
      this.container = jQuery('<div class="sticky_element_container sticky_element_container_' + $(this.element).readAttribute('id') + '"></div>');
    $(this.element).wrap(this.container);

    if($(this.element).parent)
      this.container = $(this.element).parent('.sticky_element_container');
  },
  
  setupContainment: function() {
    var o = this.options;
    if(o.containment) {
      if(o.containment == 'parent') o.containment = this.element.parentNode;
  		if(o.containment == 'document' || o.containment == 'window') this.containment = [
  			0 - this.element.offset.relative.left - this.element.offset.parent.left,
  			0 - this.element.offset.relative.top - this.element.offset.parent.top,
  			$(o.containment == 'document' ? document : window).getDimensions().width,
  			($(o.containment == 'document' ? document : window).getDimensions().height || document.body.parentNode.scrollHeight)
  		];

  		if(!(/^(document|window|parent)$/).test(o.containment) && o.containment.constructor != Array) {
  			var ce = $$(o.containment)[0]; if(!ce) return;
  			var co = $(ce).cumulativeOffset();
  			var over = ($(ce).getStyle('overflow') != 'hidden');
  			this.containment = [
  				co.left + (parseInt($(ce).getStyle("borderLeftWidth"),10) || 0) + (parseInt($(ce).getStyle("paddingLeft"),10) || 0),
  				co.top + (parseInt($(ce).getStyle("borderTopWidth"),10) || 0) + (parseInt($(ce).getStyle("paddingTop"),10) || 0),
  				co.left + (over ? Math.max(ce.scrollWidth,ce.offsetWidth) : ce.offsetWidth) - (parseInt($(ce).getStyle("borderLeftWidth"),10) || 0) - (parseInt($(ce).getStyle("paddingRight"),10) || 0),
  				co.top + ce.offsetHeight
  			];
  		} else if(o.containment.constructor == Array) {
  			this.containment = o.containment;
  		}
    }
  },
  
  setupElement: function() {
    $(this.element).addClassName('sticky_element');
    $(this.element).setStyle({ 'width': $(this.element).getStyle('width') });
  },
  
  setupEvents: function() {
    var self = this;
    if(typeof Prototype != 'undefined')
      Event.observe(window, 'scroll', function(event) {
        this._handleScroll();
      }.bind(this));
    else {
      $(window).bind('scroll', function(event) {
        this._handleScroll();
      }.bind(this));
      $(window).bind('load', function() {
        self.setupContainment();
      });
    }
  },

  _handleScroll: function() {
    var yOffset = this.container.viewportOffset()[1] + 50;
      var withinYBounds = true;
      if(this.containment){
        withinYBounds = (document.viewport.getScrollOffsets()[1] + this.element.offsetHeight) < this.containment[3];
      }
      if(!this.isFrozen && !withinYBounds)
        this.freeze();
      
      if(this.options.position == 'fixed') {
        if ( withinYBounds && !this.isStuck && (yOffset - this.options.offset <= 0) ){
          if(this.containment && this.isFrozen){
            this.unfreeze();
          }

          else if(!this.containment && !this.isFrozen){
            this.stick();
          }
          else if(this.containment){
            this.stick();
          }
        }
        else if ( this.containment && ($(this.element).offset().top <= (this.containment[1] + 50)) ) {
          this.unstick();
        }

        if(!this.isFrozen && !withinYBounds)
          this.freeze();
      }
      
      if(this.options.position == 'absolute') {
        if ( withinYBounds ){
          if(this.containment && this.isFrozen){
            this.unfreeze();
          }

          else if(!this.containment && !this.isFrozen){
            //this.stick();
            this.isStuck = true;
            $(this.element).setStyle({top: this.getPosition().top + 'px'});
          }
          else if(this.containment){
            //this.stick();
            $(this.element).setStyle({top: this.getPosition().top + 'px'});
          }
        }

      else if(!this.isFrozen && !withinYBounds)
          this.freeze();
      }

  },
  
  setupShim: function() {
    if(typeof Prototype != 'undefined')
      this.shim = new Element('div', { 'class': 'sticky_element_shim' });
    else
      this.shim = jQuery('<div class="sticky_element_shim"></div>');
    this.shim.setStyle({
      'height': this._sumElementStyles('marginTop',  'borderTopWidth',  'paddingTop',  'height', 'paddingBottom', 'borderBottomWidth', 'marginBottom'),
      'width':  this._sumElementStyles('marginLeft', 'borderLeftWidth', 'paddingLeft', 'width',  'paddingRight',  'borderRightWidth',  'marginRight' )
    });
    $(this.container).insert(this.shim);
  },
  
  stick: function() {
    this.previousElementStyles = {
      'left': this.element.style.left,
      'top':  this.element.style.top
    };
    if (this.previousElementStyles.left == '') this.previousElementStyles.left = null;
    if (this.previousElementStyles.top  == '') this.previousElementStyles.top  = null;
    
    this.container.addClassName('stuck');
    var left;
    try{
      left = $(this.container).viewportOffset()[0];
    }
    catch(err) {
      left = 0;
    }
    $(this.element).setStyle({ 
      'top':  this.options.offset + 'px' 
    });
    this.isStuck = true;
  },
  
  _sumElementStyles: function() {
    var sum = 0;
    $A(arguments).each( function(style) {
      sum += (parseInt(this.element.getStyle(style), 10) || 0);
    }.bind(this));
    return sum + 'px';
  },
  
  unfreeze: function() {
    if (!this.isFrozen) return; 
    
    this.isFrozen = false;
    this.container.removeClassName('frozen');
    $(this.element).setStyle(this.preFreezeElementStyles);
  },
  
  unstick: function() {
    this.unfreeze();
    this.isStuck = false;
    this.container.removeClassName('stuck');
    if(this.previousElementStyles && this.previousElementStyles.top && this.previousElementStyles.left)
      $(this.element).setStyle(this.previousElementStyles);
  }
  
});

var StickyElementGroup = Class.create({
  
  initialize: function(options) {
    this.options = Object.extend({
      containment: null
    }, options || {});
    
    this.isFrozen = false;
    this.stickyElements = [];
    this.setupContainment();
    this.setupEvents();
  },
  
  freeze: function() {
    this.isFrozen = true;
    this.stickyElements.invoke('freeze');
  },
  
  getBottom: function() {
    var bottom = 0;
    this.stickyElements.each( function(stickyElement) {
      var newBottom = stickyElement.element.positionedOffset()[1] + stickyElement.element.getHeight();
      if (newBottom > bottom)
        bottom = newBottom;
    });
    return document.viewport.getScrollOffsets()[1] + bottom;
  },
  
  groupHeight: function() {
    var height = 0;
    this.stickyElements.each( function(stickyElement) {
      var newHeight = stickyElement.element.getHeight() + stickyElement.options.offset + 20;
      if (newHeight > height)
        height = newHeight;
    });
    return height;
  },
  
  getBottomOfFreezeElement: function() {
    var el = $(this.options.freezeAtBottomOf);
    if (!el) return null;
    return el.cumulativeOffset()[1] + el.getHeight();
  },
  
  setupContainment: function() {
    var o = this.options;
    if(o.containment) {
      if(o.containment == 'parent') o.containment = this.element.parentNode;
  		if(o.containment == 'document' || o.containment == 'window') this.containment = [
  			0 - this.element.offset.relative.left - this.element.offset.parent.left,
  			0 - this.element.offset.relative.top - this.element.offset.parent.top,
  			$(o.containment == 'document' ? document : window).getDimensions().width,
  			($(o.containment == 'document' ? document : window).getDimensions().height || document.body.parentNode.scrollHeight)
  		];

  		if(!(/^(document|window|parent)$/).test(o.containment) && o.containment.constructor != Array) {
  			var ce = $$(o.containment)[0]; if(!ce) return;
  			var co = ce.cumulativeOffset();
  			var over = (ce.getStyle('overflow') != 'hidden');
  			this.containment = [
  				co.left + (parseInt(ce.getStyle("borderLeftWidth"),10) || 0) + (parseInt(ce.getStyle("paddingLeft"),10) || 0),
  				co.top + (parseInt(ce.getStyle("borderTopWidth"),10) || 0) + (parseInt(ce.getStyle("paddingTop"),10) || 0),
  				co.left + ce.offsetWidth - (parseInt(ce.getStyle("borderLeftWidth"),10) || 0) - (parseInt(ce.getStyle("paddingRight"),10) || 0),
  				co.top + ce.offsetHeight - (parseInt(ce.getStyle("borderTopWidth"),10) || 0) - (parseInt(ce.getStyle("paddingBottom"),10) || 0)
  			];
  		} else if(o.containment.constructor == Array) {
  			this.containment = o.containment;
  		}
    }
  },
  
  getTop: function() {
    var top = 100000;
    this.stickyElements.each( function(stickyElement) {
      var newTop = stickyElement.element.cumulativeOffset()[1];
      if (newTop < top)
        top = newTop;
    });
    return top;
  },
  
  push: function(stickyElement) {
    this.stickyElements.push(stickyElement);
    stickyElement.group = this;
    stickyElement.offset = this.calculateCumulativeOffsets();
  },
  
  calculateCumulativeOffsets: function() {
    var offset = 0;
    this.stickyElements.each(function(sticky, i){
      offset += sticky.element.getHeight() + sticky.options.offset;
    });
    return offset;
  },
  
  setupEvents: function() {
    
    Event.observe(window, 'scroll', function(event) {
      var withinYBounds = true;
      if(this.containment)
        withinYBounds = ( document.viewport.getScrollOffsets()[1] > this.containment[1] ) && 
                        ( (document.viewport.getScrollOffsets()[1] + this.groupHeight()) < this.containment[3] );
      
      if ( !withinYBounds && !this.isFrozen )
        this.freeze();
      else if ( this.isFrozen && withinYBounds){
        this.unfreeze();
      }
    }.bind(this));
  },
  
  unfreeze: function() {
    this.isFrozen = false;
    this.stickyElements.invoke('unfreeze');
  }
  
});


Groupon.ui.PageScroller = {
  scrolled: false,
  fragment: window.location.hash,
  scroll: function() {
    if (!this.scrolled && this.fragment.length > 0) {
      var id = this.fragment.split('#')[1],
          elem = $(id);

      if (elem) {
        window.scroll(0,0);
        if (elem.nodeName !== 'div') elem = elem.up();
        new Effect.ScrollTo(elem, {duration: 1.0, offset: -20, queue: 'end'});
        new Effect.Highlight(elem, {duration: 0.75, queue: 'end'});
        new Effect.Highlight(elem, {duration: 0.75, queue: 'end'});
        new Effect.Highlight(elem, {duration: 0.75, queue: 'end'});
      };
    };

    this.scrolled = true;
  }
}


/* Establish top-level behavior namespace */
if (typeof Groupon === 'undefined') {
  Groupon = {};
}

if (typeof Groupon.ui == 'undefined') {
  Groupon.ui = {};
}

if (typeof Groupon.ui.Modals == 'undefined') {
  Groupon.ui.Modals = {};
}

if(typeof(Prototype) != 'undefined'){
  Element.addMethods({
    addError: function(element, message) {
      element = $(element);
      element.insert("<span class='error'> " + message + "</span>");
      return element;
    },

    removeError: function(element) {
      element = $(element);
      element.select('.error').invoke('remove');
      return element;
    },

    //  patches prototype v1.6.1 bug that affects ie8 autocompleter result positioning
    //  https://prototype.lighthouseapp.com/projects/8886-prototype/tickets/618-getoffsetparent-returns-body-for-new-hidden-elements-in-ie8-final#ticket-618-9
    getOffsetParent: function(element) {
      //    if (element.offsetParent) return $(element.offsetParent);
      if (element.offsetParent  && Element.visible(element)) return $(element.offsetParent);
      if (element == document.body) return $(element);

      while ((element = element.parentNode) && element != document.body)
        if (Element.getStyle(element, 'position') != 'static')
          return $(element);

      return $(document.body);
    }
  });
}

Groupon.Application = function () {
  var division = '';
  var loggedIn = false;
  var connectedWithFacebook = false;
  var facebookTemplateBundleId = null;
  var _needsAttributesOnFacebookDisconnect = false;

  return {
    // State Helpers
    setDivision: function(div) {
      division = div;
    },
    getDivision: function() {
      return division;
    },
    setLoggedIn: function() {
      loggedIn = true;
    },
    isLoggedIn: function() {
      return loggedIn;
    },
    setConnectedWithFacebook: function() {
      connectedWithFacebook = true;
    },
    isConnectedWithFacebook: function() {
      return connectedWithFacebook;
    },
    setNeedsAttributesOnFacebookDisconnect: function() {
      _needsAttributesOnFacebookDisconnect = true;
    },
    needsAttributesOnFacebookDisconnect: function() {
      return _needsAttributesOnFacebookDisconnect;
    },
    logOut: function() {
      window.location.href = "/logout";
    },
    reloadPage: function() {
      window.location.reload(true);
    },

    // Ajax helpers
    get: function(url, parameters) {
      parameters.method = 'get';
      return new Ajax.Request(url, parameters);
    },
    post: function(url, parameters) {
      parameters.method = 'post';
      return new Ajax.Request(url, parameters);
    },
    put: function(url, parameters) {
      parameters.method = 'put';
      return new Ajax.Request(url, parameters);
    },
    del: function(url, parameters) {
      parameters.method = 'delete';
      return new Ajax.Request(url, parameters);
    },
    // General helpers
    popup: function(name, url) {
      return window.open(url, name);
    }
  };
}();

//simple templating
String.prototype.template = function (o) {
  return this.replace(/{([^{}]*)}/g,
    function (a, b) {
      var r = o[b];
      return typeof r === 'string' || typeof r === 'number' ? r : a;
    }
  );
};

// behavior class applied to anything intended to close a modal window
var modalCloseBehavior = Behavior.create({
  initialize: function() {},

  onclick: function(e) {
    e.stop();
    Control.Modal.close();
  }
});

//fire global close event whenever modal is closed
if(typeof(Control) != 'undefined')
  Object.extend(Control.Modal.Observers,{
      afterClose: function(){
        Control.Overlay.hide(this.options.fade ? this.options.fadeDuration : false);
        Control.Modal.current = false;
        this.overlayFinishedOpening = false;
        $(document).fire("modal:closed");
      }
  });

//completely disable modals for mobile devices
Event.onReady(function(){
  if(Groupon.Attributes.mobile_device)
    Object.extend(Control.Modal.Observers,{
      afterOpen: function(){
        if(!$(this.container).hasClassName('multi_option_modal')){
          this.close();
          return false;
        }
      }
    });
});

Groupon.ui.showHideBehavior = Behavior.create({
  initialize: function(){
    if(this.element.next('.toggle_content'))
      this.element.next('.toggle_content').hide();
  },

  onclick: function(e){
    e.stop();
    var target = e.target.hasClassName('toggle_handle') ? e.target : e.target.up('.toggle_handle');
    var toggleContent = target.next(".toggle_content");
    var contentToToggle = target.next('.toggle_content');
    if(contentToToggle.down())
      contentToToggle.animateToggle('fast');
    else
      contentToToggle.toggle();
    target.toggleClassName('open');
  }
});


Groupon.DoubleClickPreventer = Behavior.create({
  disable_form_on_submit: function() {
    if(this.element.disabled) {return event.stop();}
    this.element.disable();
    this.element.up('form').submit();
  },

  disable_field_on_submit: function(event) {
    if(this.element.hasClassName('disabled')) {return event.stop();}
    this.element.addClassName('disabled');
  },

  onclick: function(event) {
    if(this.element.tagName == 'FORM') {
      this.disable_form_on_submit(event);
    }
    else {
       this.disable_field_on_submit(event);
    }
  }
});

Groupon.ExternalLink = Behavior.create({
  initialize: function(force){
    this.force = force || false;
  },

  onclick: function(e) {
    var domain = new RegExp("^https?://" + document.domain);
    var el = e.target.nodeName != "A" ? $(e.target).up('a') : e.target;
    if((!domain.test(el.href) && $(el).readAttribute("rel") != "skip_external") || this.force){
      e.stop();
      window.open($(el).readAttribute('href'))
    }
  }
});


Event.addBehavior({
  'a.remote, #canvas.logged_in a.logged_in_remote, #main a.logged_in_remote, .main a.logged_in_remote' : Behavior.create({
    onclick : function(e) {
      e.stop();
      var sourceElement = e.element();
      if (sourceElement.tagName.toLowerCase() != 'a')
        sourceElement = sourceElement.up('a');
      var linkToRemote = new LinkToRemote(sourceElement);

      if (sourceElement.hasClassName('confirm')) {
        confirm_message_wrapper = sourceElement.select('span[name=confirm]').first();
        if (confirm_message_wrapper) {
          confirm_message = confirm_message_wrapper.innerHTML
        } else {
          confirm_message = "Are you sure?"
        }
        if(confirm(confirm_message))
          linkToRemote.makeRequest();
        else
          e.stop();
      } else {
        linkToRemote.makeRequest();
      }
    }
  }),
  'ul.alerts li.error': function() { new Effect.Highlight( this, { startcolor: '#ff6699' }); },
  'ul.alerts li.info': function() { new Effect.Highlight( this, { startcolor: '#ffcc66' }); },
  'ul.alerts li.success': function() { new Effect.Highlight( this, { startcolor: '#ccff66' }); },
  'ul.form_errors': function() { new Effect.Highlight( this, { startcolor: '#ff6699' }); },

  'a.disabled': Behavior.create({ onclick: function(e) { e.stop(); } })
});

// This should be done using Event.addBehavior, but Low Pro was not re-attaching the behavior upon AJAX response
function submitRewardInvite(form)
{
	new Ajax.Request(form.action, {
    sourceElement: form,
    method: form.method,
    parameters: form.serialize(),
		onLoading: function(e) {
			form.insert("<div id=\"" + form.id + "_loading\" class=\"loading\"></div>");
		},
		onComplete: function(e) {
			Element.remove(form.id + "_loading");
		}
	});
	return false;
}

/*
 * Progress Indicators for asynchronous activity
 */
ProgressIndicator = {}
ProgressIndicator.Spinner = Class.create({
  spinnerElementClass : 'submitRemoteSpinner',
  initialize : function(element, insertion, spinnerUrl) {
    this.sourceElement = element;
    this.insertion = insertion || 'after';
    this.spinnerUrl = spinnerUrl || '/images/icons/spinner.gif'
  },
  start : function() {
    var progress_markup = $span({ 'class' : this.spinnerElementClass }, $img({ src : this.spinnerUrl, border : 0}));
    var position = {};
    position[this.insertion] = progress_markup;
    this.sourceElement.insert(position);
    switch (this.insertion) {
      case 'after':
        this.spinnerElement = this.sourceElement.next();
        break;
      case 'before':
        this.spinnerElement = this.sourceElement.next();
        break;
      case 'top':
        this.spinnerElement = this.sourceElement.childElements().first();
        break;
    }
  },
  stop : function() {
    if (this.spinnerElement.up()) this.spinnerElement.remove();
  }
});
ProgressIndicator.Spinner.start = function(sourceElement, insertion) {
  var indicator = new this(sourceElement, insertion);
  indicator.start();
  return indicator;
}

LinkToRemote = Class.create({
  progressIndicator : ProgressIndicator.Spinner,

  initialize : function(element) {
    this.element = element;
  },

  makeRequest : function() {
    var url = this.element.down('.fields > *[name=url]').innerHTML;
    var methodField = this.element.down('.fields > .form_data > .method');

    parameters = {};
    parameters[methodField.attributes.name.value] = methodField.innerHTML;

    new Ajax.Request(url, {
      sourceElement: this.element,
      progressIndication: this.progressIndicator.start(this.element),
      method: methodField.innerHTML,
      parameters: parameters,
      onComplete: function(transport) {
        var options = transport.request.options;
        options.progressIndication.stop();
        Event.addBehavior.reload();
      }
    });
  }
});

var EventDelegationBehavior = Behavior.create({

  onclick: Event.delegate({

    '.bitlify.tw': function(e) {
      e.stop();
      Groupon.BitlifiedLink.twitter(e);
    },

    // Facebook links with class of 'bitlify' and 'fb'
    '.bitlify.fb.share_url_with_facebook': function(e) {
      e.stop();
      Groupon.BitlifiedLink.facebook(e);
    },

    '.E-Share_Email_deal': function(e) {
      e.stop();
      Groupon.BitlifiedLink.mail(e);
    }

  })

});

// This ensures that LowPro behaviors continue
// to function after an AJAX call. Don't remove!
Event.addBehavior.reassignAfterAjax = true;

Event.addBehavior({
  'body': EventDelegationBehavior,

  '.disabled_on_submit': Groupon.DoubleClickPreventer,

  '.lightbox': function(){
    var first_child = $(this).down('div');
    Control.Modal.open(first_child, {
      beforeOpen: function() {
        $('control_overlay').setStyle({
          width: '100%'
        });
      },
      fade: false,
      overlayOpacity: .3
    });
  },

  '.announcement_dismissal:click' : function(e) {
    var announcement_id = this.dbID();
    $(this.id).up("#announcement").animateToggle("fast");
    //new Ajax.Request(e.target.href);
    var curr_announcement_cookies = (Cookie.get("dismiss_announcements") || " ").split("&");
    Cookie.set('dismiss_announcements', e.target.href.toQueryParams().announcements.split(/,/).concat(curr_announcement_cookies).join("&"), (365*24*60*60));
    e.stop();
  },

  '#division_drawer select:change' : function(){
    var w = window.open();
    w.opener = null;
    w.document.location = this.getValue();
  },

  '.social ul li a:click' : function(e){
     pageTracker._trackEvent('Follow', this.classNames()+"_follow", '');
  },

  '.link_out:click' : function(){
    $(this).classNames().each(function(classname){
      if(classname.indexOf("E-")>-1){
        var params = classname.replace("E-","").split("_");
        for(i=0;i<3;i++){
          params[i] = params[i] || " "
        }
        pageTracker._trackEvent(params[0],params[1],params[2]);
      }
    });
  },
  'ul.mail_services li:click' : function(e) {
    if (e.target.className == "gmail") {
      window.open('https://www.plaxo.com/ab_chooser?t=import&cb=http://groupon.thepoint.local:3000/plaxo.html&noactivex=&actionType=&ab=gmail&signin.email=&signin.password=&x=53&y=23',"plaxo")
    }else{
      showPlaxoABChooser('user_referral_plaxo_recipient_list', '/plaxo.html');
    }
    //https://www.plaxo.com/ab_chooser?t=import&cb=http://groupon.thepoint.local:3000/plaxo.html&noactivex=&actionType=&ab=gmail&signin.email=&signin.password=&x=53&y=23
  },

  '.manual:click' : function(ev){
    ev.stop();
    $('user_referral_manual_recipient_list').toggle();
    ev.target.toggleClassName('off');
  },

  '#division_drawer_anchor a:click' : function(e) {
    var el = e.target;
    e.stop();
    (($('#follow_drawer') != null) && ($('#follow_drawer').visible())) ? Effect.toggle('follow_drawer', 'slide', { duration: 0.25, queue: 'drawer' }) : null
    Effect.toggle('division_drawer', 'slide', { duration: 0.25, queue: 'drawer' });
    if($('#division_drawer').visible()){
      pageTracker._trackEvent('Drawer', 'close', 'cities');
    }else{
      pageTracker._trackEvent('Drawer', 'open', 'cities');
    }
    
    e.stop();
    setActiveDrawerAnchor('division_drawer_anchor');
  },

  '#new_drawer_anchor a:click' : function(e) {
    var el = e.element();
    if(el.hasClassName('animating')){return false;}

    el.addClassName('animating');

    Effect.toggle('division_new','slide',{duration: 0.25, queue: 'end'});

    if($('division_new').visible()){
      if(pageTracker){pageTracker._trackEvent('CitySelector','close','cities');}
    } else {
      if(pageTracker){pageTracker._trackEvent('CitySelector','open','cities');}
    }
    setTimeout(function(){el.removeClassName('animating')},300);
    e.stop();
  },

  '#hide_division_new:click' : function(e){
    Effect.toggle('division_new','slide',{duration:0.25});
    pageTracker._trackEvent('CitySelector','close','cities');
  },

  '#state_chooser li:click' : function(e){
    $$('#state_chooser li.selected').each(function(obj){
        obj.removeClassName('selected');
    });
    var el=e.element();
    el.addClassName('selected');
    if(el.id=="state_Country" || el.id=="state_Canada"){
      var theList=el.id.substring(el.id.indexOf("_")+1).toLowerCase();
      $$('#division_list_new .current').invoke('removeClassName', 'current');
      $$('#division_list_new .'+theList+'').invoke('addClassName', 'current');

    } else {
      $$('#division_list_new .current').invoke('removeClassName', 'current');
      $$('.'+el.id).invoke('addClassName', 'current');
    }
  },

  '.article p a:click' : function(){
    pageTracker._trackEvent('Editorial', 'click_link', this.innerHTML);
  },

  '#follow_drawer_anchor a:click' : function(e) {
    var el = e.element();
    ($('#division_drawer').visible()) ? Effect.toggle('division_drawer', 'slide', { duration: 0.25, queue: 'drawer' }) : null

    Effect.toggle('follow_drawer', 'slide', { duration: 0.25, queue: 'drawer' });
    if($('#follow_drawer').visible()){
      pageTracker._trackEvent('Drawer', 'close', 'alerts');
    }else{
      pageTracker._trackEvent('Drawer', 'open', 'alerts');
    }
    
    e.stop();
    setActiveDrawerAnchor('follow_drawer_anchor');
  },
  '.fb_button:click' : function(){
    pageTracker._trackEvent('FBConnect', 'login_attempt', '');
  },
  '#hide_follow:click' : function(e) {
    Effect.toggle('follow_drawer', 'slide', { duration: 0.25 });
    Cookie.set("close_subscribe_drawer", "true", Math.pow(10, 8));
    setActiveDrawerAnchor();
  },
  '#hide_divisions:click' : function(e) {
    Effect.toggle('division_drawer', 'slide', { duration: 0.25 });
    setActiveDrawerAnchor();
  },
  '#admin_link:click' : function(e) {
    Effect.toggle('admin_nav', 'slide', { duration: 0.25 });
  },
  '#division_drawer a.current:click' : function(e) {
    Effect.toggle('division_drawer', 'slide', { duration: 0.25 });
    e.stop();
    setActiveDrawerAnchor();
  },
  'ul.alerts span#close:click' : function(e) {
    $("alerts").animateToggle("fast");
    e.stop();
  },
	'#closeAjaxAlert:click' : function() {
    $("alerts").animateToggle("fast");
		e.stop();
		removeAlert();
	},
  '.modal_close, #post_purchase #close:click' : modalCloseBehavior,
  '.collapsible_panel .toggle_handle': Groupon.ui.showHideBehavior,

  'input.numerical' : function(){
    if(typeof numericalTextFieldBehavior != 'undefined')
      new numericalTextFieldBehavior(this);
  },

  '.auto_select:click' : function(e){
    e.target.select();
  },

  '.areas': Groupon.ui.SelectBoxBehavior,


  '.twitter_widget': function() {
    var link = $('twitter_widget_link');
    Groupon.TwitterWidget({'account': link.readAttribute("href").gsub(/http:\/\/[^\/]*/,''), 'title' : link.readAttribute("title")});

    link.remove();
  },

  '.choose_your_area': function() {
    //pull the modal out from wherever it is, then stick it just before the </body> tag
    //this is so modals can go in any view without worrying about relative positioned parents
    //...damn relative positioned parents
    var modal = $('modal_window').remove();
    $$('body').first().insert(modal)
    Control.Modal.open('modal_window', {
      beforeOpen: function() {
        $('control_overlay').setStyle({
          width: '100%'
        });
      },
      fade: false,
      overlayOpacity: .3,
      afterClose: function(e){
        var num_times_closed = Cookie.get("closed_area_modal") || 0;
        ++num_times_closed;
        Cookie.set("closed_area_modal", num_times_closed, 10*365*24*60*60);
        if(num_times_closed >= 2){
          Cookie.set("home_area", Groupon.Attributes.primary_area, 10*365*24*60*60);
        }
      }
    });
  },

  '#follow_drawer.show_drawer': function() {
    ($('follow_drawer') != null) ? Effect.toggle('follow_drawer', 'slide') : null;
    setActiveDrawerAnchor('follow_drawer_anchor');
  },

  '#zenbox_tab:click, #give_rewards_feedback a:click, #show_rewards_feedback:click': Groupon.ui.openFeedback,

  '.notification_bubble .close:click' : function(e){
    e.stop();
    this.up('.notification_bubble').morph("opacity: 0; bottom: 30px;", {
      duration: .3,
      afterFinish: function(obj) {
        obj.element.remove();
      }
    });
  },

  '.notification_bubble_on': function() {
    var rewardPointsEarned = Groupon.Attributes.reward_points_earned || 100;
    var el = this;
    var rewardPointsText = this.select(".message p")[0];
    var rewardPointsTotal = 100 || parseInt(rewardPointsText.innerHTML);
    //var currentGsAmount = rewardPointsTotal - rewardPointsEarned;
    var currentGsAmount = 0;
    var startingFontSize = 90;
    var numOfBounces = 1;
    var bounced = 0;

    Groupon.ui.onModalClose(function(){
      this.setStyle({display: "block", opacity: 0});
      var origY = this.getStyle("bottom");
      var distance = 10;
      var speed = .3;
      this.setStyle({display: "block", bottom: parseInt(origY) + distance + "px", opacity: 0});
      this.morph("bottom: " + origY + "; opacity: 1", {duration: speed});
      //tally3(el);
    }.bind(this));
  },

  '.list_item_toggle': function() {
    var elToToggle = this.up().next();
    if(!this.hasClassName('open'))
      elToToggle.hide();

    new Groupon.LinkElementToggler(this, elToToggle, {
      afterShow: function(e) {
        $$('.list_item_toggle.exclusive.open').each(function(el){
          el.removeClassName('open');
          el.up().next().hide();
        });
      },

      afterClose: function(e) {
        e.element.removeClassName('open');
      }
    });
  },

  'a.put:click, a[data-method="put"]:click': function(e) {
    e.stop();
    var form = new Element('form', { action: this.readAttribute('href'), method: "post" });
    form.insert( new Element('input', { type: 'hidden', name: '_method', value: 'put'}) );
    document.body.appendChild(form);
    form.submit();
  },

  '.zebra tbody > tr:not(.header_row):nth-child(even), .zebra > li:nth-child(even)' : function() {
    $(this).addClassName("odd");
  },

  'a.tooltip': function() {
    new Tooltip(this);
  },

  '.for_friend:click' : function(e) {
    Cookie.set('modalForGiftOnLoad', true, 60);
  },

  '#number_sold_container': function(e) {
      if(typeof PeriodicalExexuter != 'undefined') 
        new PeriodicalExecuter(function() {
              new Ajax.Request('/deals/' + Groupon.Attributes.deal_permalink + '/deal_status.json', {
                method: "get",
                       onSuccess: function(transport) {
                              json = transport.responseJSON;
                              $('number_sold_container').innerHTML = json.number_sold_container;
                              new Effect.Highlight("number_sold_container",{});
              }})

        Groupon.FacebookConnect.findFriendsWhoBought('friends_who_bought', Groupon.Attributes.user_permalink, Groupon.Attributes.deal_permalink ,
          function(friends_who_bought,container){
            $(container).update('')
            var fwb_count = friends_who_bought.length;
            friends_who_bought.each(function(uid){
              FB.api( '/'+uid, function(friend){
                  var friend_who_bought = new Element('li',{'id': uid});
                  var profile_pic = new Element('img',{'src': 'http://graph.facebook.com/'+uid+'/picture'})
                  profile_pic.setAttribute('title',friend.name);
                  var profile_link = new Element('a',{'href': friend.link,'target': '_new'});
                  $(profile_link).insert(profile_pic);
                  $(friend_who_bought).insert(profile_link);
                  $(container).insert(friend_who_bought);
                });
            });
            if (fwb_count !== 0){
            $('fwb_count').show();
            $(container).show();
            if(fwb_count == 1){
              fwb_count = fwb_count+' friend bought this deal';
            }else{
              fwb_count = fwb_count+' friends bought this deal';
            }
            $('fwb_count').update(fwb_count);
            $('fwb_count').insert({top:'<div class="fb_logo"></div>'});
            }else{
            $('fwb_count').hide();
            $(container).hide();
            }
        });

        }, Groupon.Attributes.deal_refresh_interval || 300)
  },

  'a.opens_modal': function() {
    var modal = new Control.Modal(this, { overlayOpacity: 0.3, className: 'modal', fade: false });
    if (this.hasClassName('begins_opened')) {
        modal.open();
    }
  },

  '#touch_footer a': function() {
    this.writeAttribute('rel', 'skip_external');
  },

  'a[href^="http"]': Groupon.ExternalLink,

  '.clickable:click': function(e) {
    var a = this.down('a');
    if (!a) return;

    e.stop();

    if (e.shiftKey || e.metaKey)
      window.open( a.getAttribute('href'), a.readAttribute('href').replace(/[^\w]+/g, '_') );
    else
      window.location = a.getAttribute('href');
  },

  '#invites_modal form.reward_invites:submit': function(e) {
    e.stop();
    e.target.request(function(response) {

    });
  },

  '.user_rewards_status .user_level.linked_level': function(e) {
    this.setAttribute('title', 'Learn more about ' + this.innerHTML);
  },

  '.user_rewards_status .user_level.linked_level:click': function(e) {
    Control.Modal.open('level_unlocked_modal', {
      afterOpen: function() {
        if ($('local_rewards_link'))
          $('local_rewards_link').remove();
      }
    });
  },

  '.jpeg-or-png-only:change' : function(e) {
    var elem = e.element();
    var file = $F(elem).split('.').last();
    if (/jpg|png|jpeg/i.test(file)) {
      return;
    }

    alert('You can only upload a JPEG or PNG file.');
    elem.value = '';
  },

  '#faqs': function() {
    var newFaqs = this.clone(true);

    newFaqs.select('li').each( function(li, i) {
      li.select(':not(h4)').invoke('remove');
      li.select('h4').each( function(h4) {
        var link = new Element('a', { 'href': '#faq_' + i });
        link.update(h4.innerHTML);
        h4.update(link);
      });
    });

    this.insert({ before: newFaqs });

    this.select('li').each( function(li, i) {
      li.writeAttribute('id', 'faq_' + i);
    });
  },

  '#touch_footer a:click': function() {
    Cookie.set('vmobile', 'true');
  },

  'form.unfollow_merchant:submit, form.follow_merchant:submit': function(e) {
    e.stop();
		var form = $(e.target);
    form.request({
      onSuccess: function(response){
        form.replace(response.responseText);
      }
    });
  },

  'form.unfollow_merchant button, form.follow_merchant button': function() {
    var currentState,
        button = $(this),
        span = $(button).down('span'),
        currentText = span.innerHTML || span.html(),
        followText = $F('follow_button_text'),
        unfollowText = $F('unfollow_button_text'),
        unfollowHoverText = $F('unfollow_button_hover_text');

    $(button).observe('mouseover', function(e) {
      if (currentStateIs('unfollow')) {
        button.writeAttribute("value", unfollowHoverText);
        span.update(unfollowHoverText);
        button.addClassName("unfollow_hover");
      };
    });

    $(button).observe('mouseout', function(e) {
      if (currentStateIs('unfollow')) {
        button.writeAttribute("value", currentText);
        span.update(currentText);
        button.removeClassName("unfollow_hover");
      };
    });

    function currentStateIs (state) {
      return button.hasClassName(state);
    }
  }
});

// pass in activeAnchorId as a string, or leave blank to clear active states
function setActiveDrawerAnchor(activeAnchorId) {
  if (typeof activeAnchorId == "undefined") activeAnchorId = '';
  anchors = ['division_drawer_anchor', 'follow_drawer_anchor'];
  anchors.each(function(e){
    if (e == activeAnchorId) {
      $(e).toggleClassName('active');
    } else {
      $(e).removeClassName('active');
    }
  });
}

Event.onReady(function() {
  $$('a.bitlify.now').each(function(e) {
    BitlyClient.shorten(e.href, 'BitlyCB.updateLinkWithShortUrl');
  });
});

// Simplifies converting standard link to a shortened URL using http://bit.ly
// on an event so URLs are converted on demand vs. on every page load.
//
// Implemented under the assumption that the request would be made on (and
// passed in) a "click" event.  Other situations should be tested.
Groupon.BitlifiedLink = {
  originalUrl: null,
  pattern: null,

  // Bitlifies the standard-format Twitter message, which ends with a link
  // back to Groupon.
  twitter: function(e){
    pattern = new RegExp("http[s]?://(?:www\.)?twitter.com/.*?(http://.*$)");
    this.pattern = pattern;
    this.create(pattern, e);
  },

  mail: function(e){
    this.pattern = /body=(?:.+)(http.+)$/
    this.create(this.pattern, e);
  },

  // Bitlifies the standard-format Facebook message, which ends with a link
  // back to Groupon. Pass in the event
  facebook: function(e){
    e.stop();
    doBitlify = function(){
        var imgMatchRegexp = new RegExp("^<img(?: .+)?>$");

        var longUrl = e.element().readAttribute('href');
        if(imgMatchRegexp.match(e.element().inspect()) && longUrl == null) {
            longUrl = e.element().up().readAttribute('href');
        }
        BitlyClient.shorten(longUrl, 'Groupon.FacebookConnect.shareBitlyCBURL');
    }
    FB.getLoginStatus(function(response) {
      if (response.session) {
        // user successfully logged in
        doBitlify();
      } else {
        FB.login(function(r){
              doBitlify();
          });
      }
    });

  },

  // Issues a #shorten request to Bitly with the section of the
  // request's URL which matches the supplied pattern and delegates the
  // response to BiltlyCB#popupWindowWithShortUrl.
  create: function(pattern, e){
    e.stop(); // stop the original click event so we don't go anywhere
    // Store the current URL so the callback can gain access to it
    // & replace the appropriate content with the new bit.ly URL.
    this.originalUrl = e.element().readAttribute('href');

    // Search for the supplied pattern in the request's URL. If a match
    // is found, send that URL to bit.ly to be shortened...and call
    // BiltlyCB.popupWindowWithShortUrl when the result is returned (the BitlyCB
    // namespace is required by the bit.ly JS library).
    var extracted = this.originalUrl.match(pattern);
    if(extracted && extracted[1]){
      Groupon.popup = window.open();
      BitlyClient.shorten(unescape(extracted[1]), 'BitlyCB.popupWindowWithShortUrl');
    }
  }
}



// Bitly requires its callbacks to be namespaced underBitlyCB,
// if not, they won't work.
var BitlyCB = {
  popupWindowWithShortUrl: function(data) {
    var first_result;
    var s = '';

    // The response is keyed by the URL, so we need to grab the first one
    // (it's possible to send up multiple URLs at once...but we don't in
    // this case).
    for( var r in data.results ) {
      first_result = data.results[r]; break;
    }

    // Replace the old long URL w/ the bit.ly URL
    var extracted = Groupon.BitlifiedLink.originalUrl.match(Groupon.BitlifiedLink.pattern);
    new_url = Groupon.BitlifiedLink.originalUrl.replace(extracted[1], first_result["shortUrl"]);

    // Open the new, nice URL in a new window ;-)
    Groupon.popup.location = new_url;
  },

  // Finds an <a> that matches the long url and updates its href and text
  updateLinkWithShortUrl: function(data) {
    for( var r in data.results ) {
      var shortUrl = data.results[r]["shortUrl"];
      if (shortUrl) {
        $$('a.bitlify.now[href=' + r + ']').each(function(link) {
          link.setAttribute('href', shortUrl);
          link.update(shortUrl);
        });
      }
    }
  }
}

/* Easy way to leverage our alert messaging via a JS call in RJS templates */
var addAlertViaRJS = function(className, message){
  if (!$('nav')) return;

  if(!$("alerts"))
    $("nav").insert({after: "<div id='alerts'></div>"})
  var alertsList = document.createElement('ul');
  Element.addClassName(alertsList, 'alerts');

  var alertItem = document.createElement("li");
  Element.addClassName(alertItem, className);
  alertItem.innerHTML = "<div>" + message + "</div>";

  alertsList.insert(alertItem);
  $("alerts").update(alertsList);
}

var addAlert = addAlertViaRJS;

var removeAlert = function(){
  $("alerts").update('');
}

function closeWelcomeModal() {
  if (window.modals) {
    window.modals.invoke('close');
  }
}


/**
  Trigger a modal if the document.location.hash corresponds with a modal on the page
*/
if(document.location.hash) {
  var elem = $(document.location.hash.replace('#', ''));
  if (elem && elem.hasClassName('modal_window')) {
    new Control.Modal(elem.identify()).open();
  }
}



if (typeof Groupon === 'undefined') {
  Groupon = {};
}

Groupon.Metrics = {
  trackEvent: function(eventType, params, optional) {
    if (typeof(params)== 'string'){
      if(params.search(/new_membership/) > -1){
        params = ['new_membership', params.replace('new_membership',''), 'undefined']
      }else{
        params = [params, 'undefined', 'undefined'];
      }
    }

    optional = Object.extend({
       'click': params[2],
       'alt': params[1]
    }, optional);

    (function triggerPageTracker() {
      if (typeof pageTracker == 'undefined') {
        setTimeout(triggerPageTracker, 1500);
      } else {
        pageTracker._trackEvent(params[0], params[1], params[2]);
      }
    }());

    _kmq.push([eventType, params[0], optional]);
  },

  setCustomVar: function(label, value, slot, scope) {
    pageTracker._setCustomVar(slot, label, value, scope);
  },

  setDivisionCustomVar: function(newDivision) {
    this.setCustomVar("Division", newDivision, 3, this.Google.sessionScope);
  },

  setTestIdCustomVar: function(testId, variant) {
    this.setCustomVar("GWO Version", testId + "/" + variant, 2, this.Google.visitorScope);
  },

  enablePDFTracking: function() {
    $$('a[href$=pdf]').each(function(a) {
      $(a).observe('click', function(event) {
        Groupon.Metrics.trackEvent('trackClick', ['DownloadPDF', a.pathname, location.pathname]);
      });
    });
  }
}

Groupon.Metrics.Google = {
  visitorScope: 1,
  sessionScope: 2,
  pageScope: 3,

  getVariantId: function() {
    var variantId = utmx('combination');
    if (typeof variantId == 'undefined') {
      return '';
    } else {
      return variantId;
    }
  }
}

Groupon.Metrics.EventTracking = Behavior.create({
  initialize: function() {
    this.trackOnClick = !$(this.element).hasClassName('trackNow');

    if (!this.trackOnClick) {
      this.track('trackLoad');
    }
  },

  onclick: function() {
    if (!this.trackOnClick) { return; }

    this.track('trackClick');
  },

  track: function(eventType) {
    $(this.element).classNames().each(function(classname){
      if (classname.indexOf("E-") != -1){
        var params = classname.replace("E-","").split("_");
        for (i = 0; i < 3; i++) {
          params[i] = params[i] || " "
        }
        Groupon.Metrics.trackEvent(eventType, params);
      }
    });
  }
})

Event.addBehavior({
  '.G_event': Groupon.Metrics.EventTracking
});
