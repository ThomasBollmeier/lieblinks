const $ = selector => document.querySelector(selector);

document.addEventListener("DOMContentLoaded", () => {

    bookmarks.readAll().then(displayBookmarks);

    $("#create-form").addEventListener("submit", onCreateFormSubmit);

    const $url = $("#url");
    const $description = $("#description");

    $url.focus();
    $url.addEventListener("blur", () => {

        if ($description.value != "") {
            return;
        }

        getPageTitle($url.value).then((title) => {
           $description.value = title;
        });
    });

});

function displayBookmarks(bookmarks) {

    const list = $('#lieblinks_list');

    for (let child of [...list.childNodes]) {
        list.removeChild(child);
    }

    for (let bookmark of bookmarks) {
        const li = document.createElement("li");
        const a = document.createElement("a");
        a.href = bookmark.url;
        a.title = bookmark.description;
        a.text = bookmark.url;
        li.appendChild(a);
        const info = document.createTextNode(` (${bookmark.description})`);
        li.appendChild(info);
        list.appendChild(li);
    }

}

function onCreateFormSubmit(evt) {

    const url = $("#url").value;
    const description = $("#description").value;

    bookmarks.create(url, description)
        .then(bookmarks.readAll)
        .then(displayBookmarks);

    evt.preventDefault();
}

function getPageTitle(url) {
    return fetch(`api/page/title?url=${encodeURI(url)}`).then(res => res.text());
}