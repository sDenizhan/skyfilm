function openKCFinder(field, domain) {
    window.KCFinder = {
        callBack: function(url) {
            document.getElementById(field).value = url;
            window.KCFinder = null;
        }
    };
    window.open(domain+'kcfinder/browse.php?type=files&dir=', 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}