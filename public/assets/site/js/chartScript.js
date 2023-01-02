var chart = {
    graph: null,
    create: function () {
        chart.graph = nokhbe.chartView.graph()
    },
    run: function (callback) {
        function createNodeWithImage(node) {
            var radius = 12;
            // First, we create a fill pattern and add it to SVG's defs:
            var pattern = nokhbe.chartView.svg('pattern')
                .attr('id', "imageFor_" + node.id)
                .attr('patternUnits', "userSpaceOnUse")
                .attr('width', 100)
                .attr('height', 100)
            var image = nokhbe.chartView.svg('image')
                .attr('x', '0')
                .attr('y', '0')
                .attr('height', radius * 2)
                .attr('width', radius * 2)
                .link(node.data.url);
            pattern.append(image);
            defs.append(pattern);

            // now create actual node and reference created fill pattern:
            var ui = nokhbe.chartView.svg('g');
            var circle = nokhbe.chartView.svg('circle')
                .attr('cx', radius)
                .attr('cy', radius)
                .attr('fill', 'url(#imageFor_' + node.id + ')')
                .attr('r', radius);

            ui.append(circle);
            return ui;
        }

        function placeNodeWithTransform(nodeUI, pos) {
            // Shift image to let links go to the center:
            nodeUI.attr('transform', 'translate(' + (pos.x - 12) + ',' + (pos.y - 12) + ')');
        }

        var graphics = nokhbe.chartView.View.svgchartViewics();
        var defs = nokhbe.chartView.svg('defs');
        graphics.getSvgRoot().append(defs);

        graphics.node(createNodeWithImage).placeNode(placeNodeWithTransform);
        var renderer = nokhbe.chartView.View.renderer(chart.graph, {
            graphics: graphics
        });
        renderer.run();
    },
    addNode: function (model) {
        this.create();
        for (var i = 0; i < model.length; i++) {
            chart.graph.addNode(model[i].id, model[i].data);
        };
        this.run();
    },
    addLink: function (model) {
        for (var i = 0; i < model.length; i++) {
            if (model[i].data.connectTo != null && model[i].data.connectTo != undefined) {
                chart.graph.addLink(model[i].id, model[i].data.connectTo);
            }

        };
    },
    clickHandler: function () {
        $(document).ready(function () {
            $('g').click(function (e) {
                var name = $(this).attr('name');
                var field = $(this).attr('field');
                var src = $(this).attr('xlink:href');
                $('#chart-detials #name').text(name);
                $('#chart-detials #field').text(field);
                $('#chart-detials #src').attr('src', src);

            });
            $('g').dblclick(function () {
                var link = $(this).attr('link');
                var id = $(this).attr('id');
                $('svg').remove();
                $.ajax({
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    url: "friends-ajax/" + id,
                    dataType: "json",
                    success: function (data) {

                        model = data;
                        chart.addNode(model);
                        chart.addLink(model);
                        var parent = null;
                        for (var i = 0; i < model.length; i++) {
                            if (model[i].data.connectTo === null) {
                                parent = model[i];
                            }
                        };
                        $('svg image').each(function (index, object) {
                            if ($(object).attr('connectTo') === null) {
                                var parent = $(object);
                            }
                        });

                        var name = parent.data.name;
                        var field = parent.data.field;
                        var src = parent.data.url;
                        $('#chart-detials #name').text(name);
                        $('#chart-detials #field').text(field);
                        $('#chart-detials #src').attr('src', src);

                        chart.clickHandler();
                    },
                    error: function (result) {

                    }

                });
            });
        });
    },

}

var model = [];
$.ajax({
    type: "Get",
    contentType: "application/json; charset=utf-8",
    url: "friends-ajax",
    dataType: "json",
    success: function (data) {
        model = data;
        chart.addNode(model);
        chart.addLink(model);
        var parent = null;
        for (var i = 0; i < model.length; i++) {
            if (model[i].data.connectTo === null) {
                parent = model[i];
            }
        };
        $('svg image').each(function (index, object) {
            if ($(object).attr('connectTo') === null) {
                var parent = $(object);
            }
        });

        var name = parent.data.name;
        var field = parent.data.field;
        var src = parent.data.url;
        $('#chart-detials #name').text(name);
        $('#chart-detials #field').text(field);
        $('#chart-detials #src').attr('src', src);

        chart.clickHandler();
    },
    error: function (result) {

    }
});
$(document).ready(function () {
    $('image').click(function (e) {
        var name = $(this).attr('name');
        var field = $(this).attr('field');
        var src = $(this).attr('xlink:href');
        $('#chart-detials #name').text(name);
        $('#chart-detials #field').text(field);
        $('#chart-detials #src').attr('src', src);

    });
    $('image').dblclick(function () {
        var link = $(this).attr('link');
        var id = $(this).attr('id');
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            url: "friends-ajax/" + id,
            dataType: "json",
            success: function (data) {

                model = data;
                chart.addNode(model);
                chart.addLink(model);
                var parent = null;
                for (var i = 0; i < model.length; i++) {
                    if (model[i].data.connectTo === null) {
                        parent = model[i];
                    }
                };
                $('svg image').each(function (index, object) {
                    if ($(object).attr('connectTo') === null) {
                        var parent = $(object);
                    }
                });

                var name = parent.data.name;
                var field = parent.data.field;
                var src = parent.data.url;
                $('#chart-detials #name').text(name);
                $('#chart-detials #field').text(field);
                $('#chart-detials #src').attr('src', src);

                chart.clickHandler();
            },
            error: function (result) {

            }
        });
    });
});