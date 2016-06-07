// dynamically add verse form fields

var $collectionHolder;

var $addVerseLink = $("#song_add_verse");

$(document).ready(function() {
    $collectionHolder = $('div.verses');

    $("#button-spot").prepend($addVerseLink);

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addVerseLink.on('click', function(event) {
        event.preventDefault();

        addVerseForm($collectionHolder, $addVerseLink);
    });
});

function addVerseForm($collectionHolder, $addVerseLink) {
    var prototype = $collectionHolder.data('prototype');

    var index = $collectionHolder.data('index');

    var newForm = prototype.replace(/__name__/g, index);

    $newForm = $(newForm);

    $label = $newForm.find('label');

    $label.text($label.text().replace('%no%', (index + 1)));

    $collectionHolder.data('index', index + 1);

    $collectionHolder.append($newForm);
}