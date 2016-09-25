
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Html" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Html.html">Html</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Html_Html" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Html/Html.html">Html</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Html.html", "name": "Html", "doc": "Namespace Html"},
            
            {"type": "Class", "fromName": "Html", "fromLink": "Html.html", "link": "Html/Html.html", "name": "Html\\Html", "doc": "&quot;Class Html&quot;"},
                                                        {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_createElement", "name": "Html\\Html::createElement", "doc": "&quot;Statically creates an html element string.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_createAttribute", "name": "Html\\Html::createAttribute", "doc": "&quot;Statically create an attribute.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_renderNode", "name": "Html\\Html::renderNode", "doc": "&quot;Renders an instance of Html.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method___construct", "name": "Html\\Html::__construct", "doc": "&quot;Html constructor.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_id", "name": "Html\\Html::id", "doc": "&quot;Define the element&#039;s id attribute.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_getId", "name": "Html\\Html::getId", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_addClass", "name": "Html\\Html::addClass", "doc": "&quot;Add a single class to an element.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_addClasses", "name": "Html\\Html::addClasses", "doc": "&quot;Add an array of classes to an element.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_addAttribute", "name": "Html\\Html::addAttribute", "doc": "&quot;Add an attribute to an element.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_addAttributes", "name": "Html\\Html::addAttributes", "doc": "&quot;Add an array of attributes to an element.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_addStyle", "name": "Html\\Html::addStyle", "doc": "&quot;Add a style to an element.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_addStyles", "name": "Html\\Html::addStyles", "doc": "&quot;Add an array of styles to an element.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_getStyles", "name": "Html\\Html::getStyles", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_append", "name": "Html\\Html::append", "doc": "&quot;Append content to the elements content body.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_prepend", "name": "Html\\Html::prepend", "doc": "&quot;Prepend content to the element&#039;s content body.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_setContent", "name": "Html\\Html::setContent", "doc": "&quot;Initialize the element&#039;s content body.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_newChild", "name": "Html\\Html::newChild", "doc": "&quot;Instantiates a new element instance,\npushes it on to the parent&#039;s array of children,\nand returns the newly created child instance.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_renderChildren", "name": "Html\\Html::renderChildren", "doc": "&quot;Render the child elements (recursive).&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method_render", "name": "Html\\Html::render", "doc": "&quot;Render the element object to an html string.&quot;"},
                    {"type": "Method", "fromName": "Html\\Html", "fromLink": "Html/Html.html", "link": "Html/Html.html#method___toString", "name": "Html\\Html::__toString", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


