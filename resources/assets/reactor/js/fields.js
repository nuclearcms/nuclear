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

// Slug fields
$('.form-group-tag').each(function () {
    new Tag($(this));
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

window.editorDialog = new EditorDialog();

// Editors
$('.form-group-markdown').each(function () {
    var editor = new Editor($(this), window.documentsLibrary, window.editorDialog);
});