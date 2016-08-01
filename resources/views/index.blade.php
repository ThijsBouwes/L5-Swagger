<?php

    if (app()->environment() != 'testing') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With");
    }

?>

        <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('l5-swagger.api.title')}}</title>
    <link href='{{config('l5-swagger.paths.assets_public')}}/css/index.css' rel="stylesheet"/>
    <link href='{{config('l5-swagger.paths.assets_public')}}/css/standalone.css' rel='stylesheet'/>
    <link href='{{config('l5-swagger.paths.assets_public')}}/css/api-explorer.css' rel='stylesheet' type='text/css'/>
    <link href='{{config('l5-swagger.paths.assets_public')}}/css/screen.css' media='screen' rel='stylesheet' type='text/css'/>

    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/jquery-1.8.0.min.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/jquery.slideto.min.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/jquery.wiggle.min.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/jquery.ba-bbq.min.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/handlebars-2.0.0.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/underscore-min.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/backbone-min.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/swagger-ui.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/jsoneditor.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/highlight.7.3.pack.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/marked.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/swagger-oauth.js' type='text/javascript'></script>
    <script src='{{config('l5-swagger.paths.assets_public')}}/lib/bootstrap.min.js' type='text/javascript'></script>

    <script type="text/javascript">
        jQuery.browser = jQuery.browser || {};
        (function () {
            jQuery.browser.msie = jQuery.browser.msie || false;
            jQuery.browser.version = jQuery.browser.version || 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();
    </script>

    <script type="text/javascript">
        $(function () {
            var url = window.location.search.match(/url=([^&]+)/);
            if (url && url.length > 1) {
                url = decodeURIComponent(url[1]);
            } else {
                url = "{!! $urlToDocs !!}";
            }

            window.swaggerUi = new SwaggerUi({
                url: url,
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                onComplete: function (swaggerApi, swaggerUi) {
                    if (typeof initOAuth == "function") {

                        initOAuth({
                            clientId: "ffe7748a-3a3f-4860-a02a-42ab08e4fde2",
                            realm: "realm",
                            appName: "Swagger"
                        });

                    }

                    $('pre code').each(function (i, e) {
                        hljs.highlightBlock(e)
                    });

                    if (swaggerUi.options.url) {
                        $('#input_baseUrl').val(swaggerUi.options.url);
                    }
                    if (swaggerUi.options.apiKey) {
                        $('#input_apiKey').val(swaggerUi.options.apiKey);
                    }

                    $("[data-toggle='tooltip']").tooltip();

                    addApiKeyAuthorization();
                },
                onFailure: function (data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "none",
                sorter: "alpha"
            });

            function addApiKeyAuthorization() {
                var key = encodeURIComponent($('#input_apiKey')[0].value);
                if (key && key.trim() != "") {
                    var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("Authorization", "Bearer " + key, "header");
                    window.swaggerUi.api.clientAuthorizations.add("key", apiKeyAuth);
                    log("added key " + key);
                }
            }

            $('#input_apiKey').change(addApiKeyAuthorization);
            // if you have an apiKey you would like to pre-populate on the page for demonstration purposes...
            /*
             var apiKey = "myApiKeyXXXX123456789";
             $('#input_apiKey').val(apiKey);
             */

            window.swaggerUi.load();

            function log() {
                if ('console' in window) {
                    console.log.apply(console, arguments);
                }
            }
        });
    </script>

    <script type="text/javascript">

        $(function () {

            $(window).scroll(function () {
                var sticky = $(".sticky-nav");

                i(sticky);
                r(sticky);

                function n() {
                    return window.matchMedia("(min-width: 992px)").matches
                }

                function e() {
                    n() ? sticky.parents(".sticky-nav-placeholder").removeAttr("style") : sticky.parents(".sticky-nav-placeholder").css("min-height", sticky.outerHeight())
                }

                function i(n) {
                    n.hasClass("fixed") || (navOffset = n.offset().top);
                    e();
                    $(window).scrollTop() > navOffset ? $(".modal.in").length || n.addClass("fixed") : n.removeClass("fixed")
                }

                function r(e) {
                    function i() {
                        var i = $(window).scrollTop(), r = e.parents(".sticky-nav");
                        return r.hasClass("fixed") && !n() && (i = i + r.outerHeight() + 40), i
                    }

                    function r(e) {
                        var t = o.next("[data-endpoint]"), n = o.prev("[data-endpoint]");
                        return "next" === e ? t.length ? t : o.parent().next().find("[data-endpoint]").first() : "prev" === e ? n.length ? n : o.parent().prev().find("[data-endpoint]").last() : []
                    }

                    var nav = e.find("[data-navigator]");
                    if (nav.find("[data-endpoint][data-selected]").length) {
                        var o = nav.find("[data-endpoint][data-selected]"),
                                a = $("#" + o.attr("data-endpoint")),
                                s = a.offset().top,
                                l = (s + a.outerHeight(), r("next")),
                                u = r("prev");
                        if (l.length) {
                            {
                                var d = $("#" + l.attr("data-endpoint")), f = d.offset().top;
                                f + d.outerHeight()
                            }
                            i() >= f && c(l)
                        }
                        if (u.length) {
                            var p = $("#" + u.attr("data-endpoint")),
                                    g = u.offset().top;
                            v = (g + p.outerHeight(), 100);
                            i() < s - v && c(u)
                        }
                    }
                }

                function s() {
                    var e = $(".sticky-nav [data-navigator]"),
                            n = e.find("[data-endpoint]").first();
                    n.attr("data-selected", "");
                    u.find("[data-selected-value]").html(n.text())
                }

                function c(e) {
                    {
                        var n = $(".sticky-nav [data-navigator]");
                        $("#" + e.attr("data-endpoint"))
                    }
                    n.find("[data-resource]").removeClass("active");
                    n.find("[data-selected]").removeAttr("data-selected");
                    e.closest("[data-resource]").addClass("active");
                    e.attr("data-selected", "");
                    sticky.find("[data-selected-value]").html(e.text())
                }
            });

        });
    </script>

    <script type="text/javascript">
        $(function () {
            $("[data-toggle='tooltip']").tooltip();
        });
    </script>

</head>

<body class="page-docs" style="zoom: 1;">
<header class="site-header">
    <nav role="navigation" class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target="#navbar-collapse" class="navbar-toggle"><span
                            class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                            class="icon-bar"></span><span class="icon-bar"></span></button>
                <h1 class="navbar-brand"><a href="http://swagger.io"><span>swagger explorer</span></a></h1>
            </div>
            <div id="navbar-collapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li class="li-why"><a href="http://swagger.io" style="font-size: 25px; padding-left: 0px">Swagger
                            explorer</a></li>

                </ul>
            </div>
        </div>
    </nav>
</header>

<section class="content">
    <div id="api2-explorer">
        <div class="swagger-section page-docs" style="zoom: 1">
            <div class="main-section">
                <div id="swagger-ui-container" class="swagger-ui-wrap">
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

