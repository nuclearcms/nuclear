/**
 * Escapes html characters
 *
 * @param string
 * @return string
 */
function html_entities(str) {
    return $('<div/>').text(str).html();
}

/**
 * Returns the readable size
 *
 * @param int
 * @return string
 */
function readable_size(bytes) {
    var s = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'];
    var e = Math.floor(Math.log(bytes) / Math.log(1024));
    return (bytes / Math.pow(1024, e)).toFixed(2) + " " + s[e];
}

/**
 * Adds http to a url
 *
 * @param string
 * @return string
 */
function add_http(url) {
    // Set pattern
    var pattern = /^(f|ht)tps?:\/\//;
    // Add http if the url does not have any protocol prefix
    if(!pattern.test(url)) {
        url = "http://" + url;
    }
    // Return
    return url;
}

/**
 * Calculates ajax event load percentage
 *
 * @param xhr event
 * @return int
 */
function loaded(e) {
    var percent = 0,
        position = e.loaded || e.position,
        total = e.total;
    if(e.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    return percent;
}

/**
 * Creates a form from given DOM object
 *
 * @param DOMObject
 * @return DOMObject
 */
function create_form_from(item)
{
    var form = $('<form>').attr({
        method: 'post',
        action: item.data('action')
    });

    var type = $('<input>').attr({
        name: '_method',
        type: 'hidden',
        value: item.data('method')
    });

    var token = $('<input>').attr({
        name: '_token',
        type: 'hidden',
        value: $('meta[name="csrf-token"]').attr('content')
    });

    type.appendTo(form);
    token.appendTo(form);

    return form;
}

/**
 * Appends a given form to body and submits it
 *
 * @param DOMObject
 */
function append_and_submit_form(form)
{
    form.appendTo($('body'));

    form.submit();
}