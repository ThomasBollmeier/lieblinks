const $ = selector => document.querySelector(selector);

document.addEventListener("DOMContentLoaded", () => {

    readBookmarks().then(displayBookmarks);

    $("#create-form").addEventListener("submit", onCreateFormSubmit);

});

function readBookmarks() {
    return fetch("api/bookmarks").then(response => response.json());
}

function displayBookmarks(bookmarks) {

    const list = $('#lieblinks_list');

    const children = [...list.childNodes];

    for (let child of children) {
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

    fetch('api/bookmarks', {
        method: "POST",
        body: JSON.stringify({url, description}),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    }).then(readBookmarks).then(displayBookmarks);

    evt.preventDefault();
}