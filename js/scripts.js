function check(site) {
    $.get("check.php?site="+site, function() {
        window.location.reload();
    });
}
