const $ = selector => document.querySelector(selector);

document.addEventListener('DOMContentLoaded', () => {

    bookmarks.readAll().then(displayBookmarks);

    $('#create-form').addEventListener('submit', onCreateFormSubmit);

    const $url = $('#url');
    const $description = $('#description');

    $url.focus();
    $url.addEventListener('blur', () => {

        if ($description.value !== '') {
            return;
        }

        getPageTitle($url.value).then((title) => {
           $description.value = title;
        });
    });

});

function displayBookmarks(bookmarkList) {

    const $list = $('#lieblinks_list');

    const $newList = document.createElement('ul');
    $newList.setAttribute('id', 'lieblinks_list');

    bookmarkList.forEach(bookmark => {

        const $li = document.createElement('li');
        const $a = document.createElement('a');
        $a.href = bookmark.url;
        $a.title = bookmark.description;
        $a.text = bookmark.url;
        $li.appendChild($a);

        const $descr = document.createTextNode(` (${bookmark.description}) `);
        $li.appendChild($descr);

        createButton($li, 'Ändern', () => {
            //alert(bookmark.links.bookmark);
            const newDescription = `${bookmark.description} (changed)`;
            bookmarks.update(bookmark.links.bookmark, bookmark.url, newDescription)
                .then(bookmarks.readAll)
                .then(displayBookmarks);
        });

        createButton($li, 'Löschen', () => {
            bookmarks.remove(bookmark.links.bookmark)
                .then(bookmarks.readAll)
                .then(displayBookmarks);
        });

        $newList.appendChild($li);
    });

    $list.parentNode.replaceChild($newList, $list);
}

function createButton($parent, label, handler) {

    const $btn = document.createElement('button');
    $btn.textContent = label;
    $btn.addEventListener('click', handler);

    $parent.appendChild($btn);

}

function onCreateFormSubmit(evt) {

    const $url = $('#url');
    const $description = $('#description');

    //TODO: validation

    bookmarks.create($url.value, $description.value)
        .then(bookmarks.readAll)
        .then(displayBookmarks);

    // clear input
    $url.value = '';
    $description.value = '';

    evt.preventDefault();
}

function getPageTitle(url) {
    return fetch(`api/page/title?url=${encodeURI(url)}`).then(res => res.text());
}