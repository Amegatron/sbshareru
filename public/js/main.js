$(document).ready(function() {
    $("#delete-planet").click(function() {
        return confirm("Вы уверены, что хотите удалить планету?");
    });

    $("#submit-button").click(function() {
        $(this).attr("disabled", "disabled");
        $(this).html($(this).data("submit-message"));
        $(this).closest("form").submit();
    });

    var wysibbOpts = {
        buttons: 'bold,italic,underline,|,img'
    };

//    $(".bbeditor").wysibb(wysibbOpts);

    $(".bbeditor").textcomplete([
        {
            match: /\B@(\w*)$/,
            search: function (term, callback) {
                callback($.map(mentions, function (mention) {
                    mentionTest = mention.toLowerCase();
                    termTest = term.toLowerCase();
                    return mentionTest.indexOf(termTest) === 0 ? mention : null;
                }));
            },
            index: 1,
            replace: function (mention) {
                return '@' + mention + ' ';
            }
        },
        { // emoji strategy
            match: /\B:([\-+\w]*)$/,
            search: function (term, callback) {
                callback($.map(emojies, function (emoji) {
                    return emoji.indexOf(term) === 0 ? emoji : null;
                }));
            },
            replace: function (value) {
                return ':' + value + ': ';
            },
            template: function (value) {
                return '<img src="/img/emoji/' + value + '.png" class="emoji" />' + value;
            },
            index: 1,
            maxCount: 5
        },
        {
            // BBCode strategy
            match: /\B\[(\w*)$/,
            search: function(term, callback) {
                callback($.map(window.bbtags, function (bbtag) {
                    tagTest = bbtag.toLowerCase();
                    termTest = term.toLowerCase();
                    return tagTest.indexOf(termTest) === 0 ? bbtag : null;
                }));
            },
            index: 1,
            replace: function(element) {
                return ['[' + element + ']', '[/' + element + ']'];
            }
        }
    ]);

    $("#planet-tags").tagit({
        fieldName: "tags[]",
        allowSpaces: true,
        caseSensitive: false,
        autocomplete: {
            source: function(request, response) {
                $.ajax({
                    url: "/tags/suggest",
                    data: {
                        term: request.term
                    },
                    datatype: "json",
                    success: function(data, textStatus, jqXHR) {
                        response(data);
                    },
                    error: function() {
                        response([]);
                    }
                });
            }
        }
    });

    $(".preview-button").click(function (e) {
        e.preventDefault();

        var source = $("textarea[name=" + $(this).data('source-input') + "]");

        var that = this;
        $(that).text('Обработка ...');
        $(that).attr('disabled', 'disabled');
        $.ajax({
            url: '/preview/make',
            type: 'POST',
            dataType: 'json',
            data: {
                text: $(source).val()
            }
        }).done(function(response) {
            var previewContainer = $(".preview-container");
            if (response.preview) {
                if (previewContainer) {
                    var previewDiv = $(previewContainer).find(".preview");
                    $(previewDiv).html(response.preview);
                    $(previewContainer).fadeIn(300);
                }
            } else {
                $(previewContainer.hide());
            }
        }).always(function (response) {
            $(that).text('Предварительный просмотр');
            $(that).removeAttr('disabled');
        });

        return false;
    });
});
