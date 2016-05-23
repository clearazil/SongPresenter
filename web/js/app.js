// dynamically add verse form fields

var $collectionHolder;

var $addVerseLink = $('<a href="#" class="add-verse-link">Add a verse</a>');
var $newLinkLi = $('<li></li>').append($addVerseLink);

$(document).ready(function() {
    $collectionHolder = $('div.verses');

    $collectionHolder.append($addVerseLink);

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

    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li></li>').append($newForm);
    $addVerseLink.before($newForm);
}