const $ = require('jquery');

$(function() {
    $('ul.collections').each(function() {
        var $collectionHolder = $(this);

        // Get the add button
        var $addTagButton = $collectionHolder.find('button.collection-add');

        // add a delete link to all of the existing tag form li elements
        $collectionHolder.find('li').children().each(function() {
            addTagFormDeleteLink($collectionHolder, $(this));
        });

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addTagButton.on('click', function(e) {
            // add a new tag form (see next code block)
            addTagForm($collectionHolder, $addTagButton);
        });
    });

    function addTagForm($collectionHolder, $addTagButton) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your files field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li></li>').append(newForm);
        var $newFormDiv = $newFormLi.children();
        $newFormDiv.addClass('form-inline mb-4');
        $newFormDiv.children().addClass('form-group pr-4');

        $addTagButton.before($newFormLi);
        addTagFormDeleteLink($collectionHolder, $newFormDiv);
    }
    function addTagFormDeleteLink($collectionHolder, $tagFormLi) {
        var $removeFormButton = $($collectionHolder.data('delete'));
        $tagFormLi.append($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            $tagFormLi.remove();
        });
    }
})
