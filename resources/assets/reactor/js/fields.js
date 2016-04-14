// General highlighters
$('.form-group input, .form-group textarea').focus(function () {
    $(this).closest('.form-group').addClass('focus');
});

$('.form-group input, .form-group textarea').blur(function () {
    $(this).closest('.form-group').removeClass('focus');
});

// Password strength meter
$('.form-group-password').each(function () {
    new Meter($(this));
});

// Slug fields
$('.form-group-slug').each(function () {
    new Slug($(this));
});

// Tag(Legacy) fields
$('.form-group-tag').each(function () {
    new TagLegacy($(this));
});

// Initialize color pickers
$('input.minicolors').minicolors();

window.documentsLibrary = new Library($('#library-modal-container'));

// Initialize gallery fields
$('.form-group-gallery').each(function () {
    var gallery = new Gallery($(this), window.documentsLibrary);
});

// Initialize document fields
$('.form-group-document').each(function () {
    var document = new Document($(this), window.documentsLibrary);
});

// Initialize node collection fields
$('.form-group-node-collection').each(function () {
    var collection = new NodeCollection($(this));
});

// Initialize single node fields
$('.form-group-node').each(function () {
    var collection = new NodeCollection($(this), true);
});

window.editorDialog = new EditorDialog();

// Editors
$('.form-group-markdown').each(function () {
    var editor = new Editor($(this), window.documentsLibrary, window.editorDialog);
});

// Publish and save button
$('button.publish-save').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var form = $(this).closest('form');

    $('<input name="_publish" type="hidden" value="publish">').appendTo(form);

    form.submit();
});

// Node options menu
$('.node-option-formable').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var form = create_form_from($(this));

    append_and_submit_form(form);
});