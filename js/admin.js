document.addEventListener('DOMContentLoaded', () => {
    const selectStatuses = document.querySelectorAll('#SelectStatus');

    selectStatuses.forEach(function(elem) 
    {
        elem.addEventListener("change", function(e) 
        {
            $.ajax({
                type: "POST",
                url: "editUser.php",
                data: {
                    "status" : elem.value,
                    "id" : elem.attributes.userid.value
                },
                dataType: "json",
                success: function (response) {
                    location.reload();
                }
            });
        });
    });
});