document.addEventListener('DOMContentLoaded', () => {
    let url = new URL(window.location.href);
    if (!url.searchParams.has("reason"))
    {
        let reason = "";
        while (reason == null || reason.length == 0)
        {
            reason = prompt("Введите причину отказа");
        }
        location.href = window.location.href + "&reason=" + reason;
    }

});