const $tabsToDropdown = $(".tabs-to-dropdown");

function generateDropdownLinksMarkup(items) {
    let markup = "";
    items.each(function () {
        const textLink = $(this).find("a").text();
        markup += `<a class="dropdown-item" href="#">${textLink}</a>`;
    });

    return markup;
}

function showDropdownHandler(e) {
    const $this = $(e.target);
    const $dropdownToggle = $this.find(".dropdown-toggle");
    const dropdownToggleText = $dropdownToggle.text().trim();
    const $dropdownMenuLinks = $this.find(".dropdown-menu a");
    const dNoneClass = "d-none";
    $dropdownMenuLinks.each(function () {
        const $this = $(this);
        if ($this.text() == dropdownToggleText) {
            $this.addClass(dNoneClass);
        } else {
            $this.removeClass(dNoneClass);
        }
    });
}

function clickHandler(e) {
    e.preventDefault();
    const $this = $(this);
    const index = $this.index();
    const text = $this.text();
    $this.closest(".dropdown").find(".dropdown-toggle").text(`${text}`);
    $this
        .closest($tabsToDropdown)
        .find(`.nav-pills li:eq(${index}) a`)
        .tab("show");
}

function shownTabsHandler(e) {
    const $this = $(e.target);
    const index = $this.parent().index();
    const $parent = $this.closest($tabsToDropdown);
    const $targetDropdownLink = $parent.find(".dropdown-menu a").eq(index);
    const targetDropdownLinkText = $targetDropdownLink.text();
    $parent.find(".dropdown-toggle").text(targetDropdownLinkText);
}

$tabsToDropdown.each(function () {
    const $this = $(this);
    const $pills = $this.find('a[data-toggle="pill"]');

    generateDropdownMarkup($this);

    const $dropdown = $this.find(".dropdown");
    const $dropdownLinks = $this.find(".dropdown-menu a");

    $dropdown.on("show.bs.dropdown", showDropdownHandler);
    $dropdownLinks.on("click", clickHandler);
    $pills.on("shown.bs.tab", shownTabsHandler);
});

function toggleComments(postId) {
    const comments = document.getElementById(postId);
    const btn = comments.previousElementSibling;
    if (comments.classList.contains('d-none')) {
        comments.classList.remove('d-none');
        btn.textContent = 'Hide Comments';
    } else {
        comments.classList.add('d-none');
        btn.textContent = 'Show Comments';
    }
}


