function alertbox(msg_title, msg_alert, icon, href) {
    Swal.fire(msg_title, msg_alert, icon).then(() => {
        if (href) {
            window.location.href = href != '' ? href : "?page=home";
        }
    });
}