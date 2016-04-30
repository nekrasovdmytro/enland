h1. Lazy Load Plugin for jQuery

Lazy Load delays loading of images in long web pages. Images outside of viewport wont be loaded before user scrolls to them. This is opposite of image preloading.

Using Lazy Load on long web pages containing many large images makes the page load faster. Browser will be in ready state after loading visible images. In some cases it can also help to reduce server load.

Lazy Load is inspired by "YUI ImageLoader":http://developer.yahoo.com/yui/imageloader/ Utility by Matt Mlinac.

h2. How to Use?

Lazy Load depends on jQuery. Include them both in end of your HTML code:

<pre><script src="jquery.js" type="text/javascript"></script>
<script src="jquery.lazyload.js" type="text/javascript"></script></pre>

You must alter your HTML code. URL of the real image must be put into data-original attribute. It is good idea to give Lazy Loaded image a specific class. This way you can easily control which images plugin is binded to. Note that you should have width and height attributes in your image tag.

<pre><img class="lazy" data-original="img/example.jpg" width="640" height="480"></pre>

then in your code do:

<pre>$("img.lazy").lazyload();</pre>

This causes all images of class lazy to be lazy loaded.

More information on "Lazy Load":http://www.appelsiini.net/projects/lazyload project page.

h4. Install with "bower":http://bower.io

<pre>$ bower install jquery.lazyload</pre>

h1. License

All code licensed under the "MIT License":http://www.opensource.org/licenses/mit-license.php. All images licensed under "Creative Commons Attribution 3.0 Unported License":http://creativecommons.org/licenses/by/3.0/deed.en_US. In other words you are basically free to do whatever you want. Just don't remove my name from the source.

h1. Changelog

h2. 1.9.3

* Improved Bower support

h2. 1.9.2

* Bower support ("mrzmyr":https://github.com/mrzmyr)

h2. 1.9.1

* Fix iOS5 detection for iPhone  ("Berik Visschens":https://github.com/berikv)
* Use .attr() instead of .data() since jQuery caches values when using latter. Fixes "#37":https://github.com/tuupola/jquery_lazyload/pull/37, "#144":https://github.com/tuupola/jquery_lazyload/issues/144 and "#101":https://github.com/tuupola/jquery_lazyload/issues/101 ("Lorenz an Mey":https://github.com/swiftyone).
* Do not add data:uri placeholder for non image elements.

h3. 1.9.0

* Add support for CSS background images.
* Make external placeholder image optional by providing default 1x1 grey image as data uri ("Dave Mc Nicoll":https://github.com/mcNdave)
* Fix bug "#47":https://github.com/tuupola/jquery_lazyload/pull/47 and "#71":https://github.com/tuupola/jquery_lazyload/issues/71. Mobile Safari window height changes when scrolling. ("Girvan":https://github.com/girvan)

h3. 1.8.5

* Revert "#70":https://github.com/tuupola/jquery_lazyload/issues/70 because it causes more problem than solves. Only proper fix in Webkit browsers is to set width and height either as attributes or in CSS. Without width and height Webkit sees image as size 0x0 and causes jQuery to assume they are not visible. Fixes bugs "#99":https://github.com/tuupola/jquery_lazyload/pull/99, "#98":https://github.com/tuupola/jquery_lazyload/issues/98 and "#88":https://github.com/tuupola/jquery_lazyload/issues/88.
* Fix bug "#118":https://github.com/tuupola/jquery_lazyload/issues/118. Scrollstop event was not compatible with jQuery 1.9.x.
* Fix bug "#120":https://github.com/tuupola/jquery_lazyload/pull/120. Sometimes event.originalEvent was not defined under iOS. ("David G. Durand":https://github.com/daviddurand)

h3. 1.8.4

* Support for "jQuery plugin repository":http://plugins.jquery.com/

h3. 1.8.3

* Proper fix for "#48":https://github.com/tuupola/jquery_lazyload/pull/48. If image did not have width and height set Webkit browsers needed initial scroll for images to display. ("@sc-aboudreau":https://github.com/sc-aboudreau)

h3. 1.8.2

* Workaround for bug "#30":https://github.com/tuupola/jquery_lazyload/issues/30 IOS5 Safari did not load images when navigating with back button.

h3. 1.8.1

* Fix bug "#48":https://github.com/tuupola/jquery_lazyload/pull/48. In some cases initial scroll was needed for images to load. ("Nick George":https://github.com/Izzmo)
* Fix bug "#42":https://github.com/tuupola/jquery_lazyload/pull/42. Reset internal failure counter when image is found. Makes counter logic more intuitive. ("Josep del Rio":https://github.com/joseprio)
* Fix bug "#52":https://github.com/tuupola/jquery_lazyload/pull/42. Fix :in-viewport convenience method. ("Jonathan Palardy":https://github.com/jpalardy)


h3. 1.8.0

* Allow different elements to use different containers. ("Rob Walch":https://github.com/robwalch)

h3. 1.7.1

* Fix bug "#18":https://github.com/tuupola/jquery_lazyload/pull/18. Document was always scrolled to top issue on IE 7 and Chrome 17 if using jQuery 1.6 or older. ("Ross Allen":https://github.com/ssorallen)
* General code speedup ("Valentin Zwick":https://github.com/vzwick)

h3. 1.7.0

* Optimized viewport selectors. Around 25% "speed increase":http://jsperf.com/lazyload-1-7-0 compared to "1.6.0":http://jsperf.com/lazyload-1-6-0.
* Add _data_attribute_ parameter. Allows custom naming of original data attribute. ("Bryan Chow":https://github.com/bryanchow)
* Track window resize event. ("Simon Baynes":https://github.com/baynezy)
* Add _appear_ event. This function is called when image appears to viewport but before it is loaded.
* Add _load_ event. This function is called when image is loaded. ("Nick Larson":https://github.com/ifightcrime)
* Renamed _effectspeed_ parameter to _effect_speed_. Old version will still works couple of versions. This parameter was previously undocumented.
* Fix _failure_limit_ bug "#19":https://github.com/tuupola/jquery_lazyload/issues/19.  ("Brandon":https://github.com/Brandon0)

h3. 1.6.0

* Rename original attribute to data-original to be HTML5 friendly.
* Remove all code regarding placeholder and automatically removing src attribute. It does not work with modern browsers. Must use data-original attribute instead.
* Add support for James Padolseys "scrollstop event":http://james.padolsey.com/javascript/special-scroll-events-for-jquery/. Use when you have hundreds of images.
* Add _skip_invisible_ parameter. When true plugin will skip invisible images. ("Valentin Zwick":https://github.com/vzwick)
* Renamed _failurelimit_ parameter to _failure_limit_. Old version will still work couple of versions.

h3. 1.5.0

* Support for removing the src attribute already in HTML. This is not a drop in solution but gives additional speed for those who need it. (Jeremy Pollock)

h3. 1.4.0

* When scrolling down quickly do not load the images above the top. (Bart Bruil)

h3. 1.3.2

* Support for scrolling within a container.
* Fixed IE not loading images.

# Lazy Load Plugin for jQuery

Lazy Load delays loading of images in long web pages. Images outside of viewport wont be loaded before user scrolls to them. This is opposite of image preloading.

Using Lazy Load on long web pages containing many large images makes the page load faster. Browser will be in ready state after loading visible images. In some cases it can also help to reduce server load.

Lazy Load is inspired by [YUI ImageLoader](http://developer.yahoo.com/yui/imageloader/) Utility by Matt Mlinac.

## How to Use?

Lazy Load depends on jQuery. Include them both in end of your HTML code:

```html
<script src="jquery.js" type="text/javascript"></script>
<script src="jquery.lazyload.js" type="text/javascript"></script>
```

You must alter your HTML code. URL of the real image must be put into data-original attribute. It is good idea to give Lazy Loaded image a specific class. This way you can easily control which images plugin is binded to. Note that you should have width and height attributes in your image tag.

```html
<img class="lazy" data-original="img/example.jpg" width="640" height="480">
```

then in your code do:

```js
$("img.lazy").lazyload();
```

This causes all images of class lazy to be lazy loaded.

More information on [Lazy Load](http://www.appelsiini.net/projects/lazyload) project page.

## Install

You can install with [bower](http://bower.io/) or [npm](https://www.npmjs.com/).


```sh
$ bower install jquery.lazyload
$ npm install jquery-lazyload
```


# License

All code licensed under the [MIT License](http://www.opensource.org/licenses/mit-license.php). All images licensed under [Creative Commons Attribution 3.0 Unported License](http://creativecommons.org/licenses/by/3.0/deed.en_US). In other words you are basically free to do whatever you want. Just don't remove my name from the source.


/*!
 * Lazy Load - jQuery plugin for lazy loading images
 *
 * Copyright (c) 2007-2015 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/lazyload
 *
 * Version:  1.9.7
 *
 */

(function($, window, document, undefined) {
    var $window = $(window);

    $.fn.lazyload = function(options) {
        var elements = this;
        var $container;
        var settings = {
            threshold       : 0,
            failure_limit   : 0,
            event           : "scroll",
            effect          : "show",
            container       : window,
            data_attribute  : "original",
            skip_invisible  : false,
            appear          : null,
            load            : null,
            placeholder     : "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
        };

        function update() {
            var counter = 0;

            elements.each(function() {
                var $this = $(this);
                if (settings.skip_invisible && !$this.is(":visible")) {
                    return;
                }
                if ($.abovethetop(this, settings) ||
                    $.leftofbegin(this, settings)) {
                        /* Nothing. */
                } else if (!$.belowthefold(this, settings) &&
                    !$.rightoffold(this, settings)) {
                        $this.trigger("appear");
                        /* if we found an image we'll load, reset the counter */
                        counter = 0;
                } else {
                    if (++counter > settings.failure_limit) {
                        return false;
                    }
                }
            });

        }

        if(options) {
            /* Maintain BC for a couple of versions. */
            if (undefined !== options.failurelimit) {
                options.failure_limit = options.failurelimit;
                delete options.failurelimit;
            }
            if (undefined !== options.effectspeed) {
                options.effect_speed = options.effectspeed;
                delete options.effectspeed;
            }

            $.extend(settings, options);
        }

        /* Cache container as jQuery as object. */
        $container = (settings.container === undefined ||
                      settings.container === window) ? $window : $(settings.container);

        /* Fire one scroll event per scroll. Not one scroll event per image. */
        if (0 === settings.event.indexOf("scroll")) {
            $container.bind(settings.event, function() {
                return update();
            });
        }

        this.each(function() {
            var self = this;
            var $self = $(self);

            self.loaded = false;

            /* If no src attribute given use data:uri. */
            if ($self.attr("src") === undefined || $self.attr("src") === false) {
                if ($self.is("img")) {
                    $self.attr("src", settings.placeholder);
                }
            }

            /* When appear is triggered load original image. */
            $self.one("appear", function() {
                if (!this.loaded) {
                    if (settings.appear) {
                        var elements_left = elements.length;
                        settings.appear.call(self, elements_left, settings);
                    }
                    $("<img />")
                        .bind("load", function() {

                            var original = $self.attr("data-" + settings.data_attribute);
                            $self.hide();
                            if ($self.is("img")) {
                                $self.attr("src", original);
                            } else {
                                $self.css("background-image", "url('" + original + "')");
                            }
                            $self[settings.effect](settings.effect_speed);

                            self.loaded = true;

                            /* Remove image from array so it is not looped next time. */
                            var temp = $.grep(elements, function(element) {
                                return !element.loaded;
                            });
                            elements = $(temp);

                            if (settings.load) {
                                var elements_left = elements.length;
                                settings.load.call(self, elements_left, settings);
                            }
                        })
                        .attr("src", $self.attr("data-" + settings.data_attribute));
                }
            });

            /* When wanted event is triggered load original image */
            /* by triggering appear.                              */
            if (0 !== settings.event.indexOf("scroll")) {
                $self.bind(settings.event, function() {
                    if (!self.loaded) {
                        $self.trigger("appear");
                    }
                });
            }
        });

        /* Check if something appears when window is resized. */
        $window.bind("resize", function() {
            update();
        });

        /* With IOS5 force loading images when navigating with back button. */
        /* Non optimal workaround. */
        if ((/(?:iphone|ipod|ipad).*os 5/gi).test(navigator.appVersion)) {
            $window.bind("pageshow", function(event) {
                if (event.originalEvent && event.originalEvent.persisted) {
                    elements.each(function() {
                        $(this).trigger("appear");
                    });
                }
            });
        }

        /* Force initial check if images should appear. */
        $(document).ready(function() {
            update();
        });

        return this;
    };

    /* Convenience methods in jQuery namespace.           */
    /* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

    $.belowthefold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = (window.innerHeight ? window.innerHeight : $window.height()) + $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top + $(settings.container).height();
        }

        return fold <= $(element).offset().top - settings.threshold;
    };

    $.rightoffold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left + $(settings.container).width();
        }

        return fold <= $(element).offset().left - settings.threshold;
    };

    $.abovethetop = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top;
        }

        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };

    $.leftofbegin = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left;
        }

        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.inviewport = function(element, settings) {
         return !$.rightoffold(element, settings) && !$.leftofbegin(element, settings) &&
                !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
     };

    /* Custom selectors for your convenience.   */
    /* Use as $("img:below-the-fold").something() or */
    /* $("img").filter(":below-the-fold").something() which is faster */

    $.extend($.expr[":"], {
        "below-the-fold" : function(a) { return $.belowthefold(a, {threshold : 0}); },
        "above-the-top"  : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-screen": function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-screen" : function(a) { return !$.rightoffold(a, {threshold : 0}); },
        "in-viewport"    : function(a) { return $.inviewport(a, {threshold : 0}); },
        /* Maintain BC for couple of versions. */
        "above-the-fold" : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-fold"  : function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-fold"   : function(a) { return !$.rightoffold(a, {threshold : 0}); }
    });

})(jQuery, window, document);

/* http://james.padolsey.com/javascript/special-scroll-events-for-jquery/ */

(function(){
    
    var special = jQuery.event.special,
        uid1 = "D" + (+new Date()),
        uid2 = "D" + (+new Date() + 1);
        
    special.scrollstart = {
        setup: function() {
            
            var timer,
                handler =  function(evt) {
                    
                    var _self = this,
                        _args = arguments;
                    
                    if (timer) {
                        clearTimeout(timer);
                    } else {
                        evt.type = "scrollstart";
                        jQuery.event.dispatch.apply(_self, _args);
                    }
                    
                    timer = setTimeout( function(){
                        timer = null;
                    }, special.scrollstop.latency);
                    
                };
            
            jQuery(this).bind("scroll", handler).data(uid1, handler);
            
        },
        teardown: function(){
            jQuery(this).unbind( "scroll", jQuery(this).data(uid1) );
        }
    };
    
    special.scrollstop = {
        latency: 300,
        setup: function() {
            
            var timer,
                    handler = function(evt) {
                    
                    var _self = this,
                        _args = arguments;
                    
                    if (timer) {
                        clearTimeout(timer);
                    }
                    
                    timer = setTimeout( function(){
                        
                        timer = null;
                        evt.type = "scrollstop";
                        jQuery.event.dispatch.apply(_self, _args);
                        
                        
                    }, special.scrollstop.latency);
                    
                };
            
            jQuery(this).bind("scroll", handler).data(uid2, handler);
            
        },
        teardown: function() {
            jQuery(this).unbind( "scroll", jQuery(this).data(uid2) );
        }
    };
    
})();
{
  "name": "jquery-lazyload",
  "version": "1.9.7",
  "engines": {
    "node": ">= 0.8.0"
  },
  "repository": {
    "type": "git",
    "url": "git+ssh://git@github.com/tuupola/jquery_lazyload.git"
  },
  "author": {
    "name": "Mika Tuupola",
    "email": "tuupola@appelsiini.net"
  },
  "scripts": {
    "test": "grunt test"
  },
  "devDependencies": {
    "grunt": "~0.4.1",
    "grunt-contrib-jshint": "~0.6.4",
    "grunt-contrib-uglify": "~0.2.4",
    "grunt-contrib-jasmine": "~0.5.2",
    "grunt-contrib-watch": "~0.5.3"
  },
  "description": "Lazyload images with jQuery",
  "bugs": {
    "url": "https://github.com/tuupola/jquery_lazyload/issues"
  },
  "homepage": "http://www.appelsiini.net/projects/lazyload",
  "main": "jquery.lazyload.js",
  "files": [
    "jquery.lazyload.js",
    "jquery.scrollstop.js"
  ],
  "keywords": [
    "jquery-plugin",
    "ecosystem:jquery"
  ],
  "license": "MIT",
  "gitHead": "218e50eb4999fe59ac94b939a65c8c988d1d420b",
  "_id": "jquery-lazyload@1.9.7",
  "_shasum": "9982b388c533c0b611214b3c5aaa0b9fede071f7",
  "_from": "jquery-lazyload@",
  "_npmVersion": "2.10.1",
  "_nodeVersion": "0.12.4",
  "_npmUser": {
    "name": "tuupola",
    "email": "tuupola@appelsiini.net"
  },
  "dist": {
    "shasum": "9982b388c533c0b611214b3c5aaa0b9fede071f7",
    "tarball": "http://registry.npmjs.org/jquery-lazyload/-/jquery-lazyload-1.9.7.tgz"
  },
  "maintainers": [
    {
      "name": "tuupola",
      "email": "tuupola@appelsiini.net"
    }
  ],
  "directories": {},
  "_resolved": "https://registry.npmjs.org/jquery-lazyload/-/jquery-lazyload-1.9.7.tgz"
}
