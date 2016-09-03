// DOCUMENTS BAG
window.documentsBag = new DocumentsBag;

// DOCUMENTS LIBRARY
window.documentsLibrary = new DocumentsLibrary($('#libraryModal'), window.documentsBag);

// GALLERY FIELDS
$('.form-group--gallery').each(function () {
    new Gallery($(this), window.documentsLibrary, window.documentsBag);
});

// DOCUMENT FIELDS
$('.form-group--document').each(function () {
    new Document($(this), window.documentsLibrary, window.documentsBag);
});

// MARKDOWN FIELDS
$('.form-group__markdown').each(function () {
    new MarkdownEditor($(this));
});