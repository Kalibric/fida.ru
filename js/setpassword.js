document.addEventListener('DOMContentLoaded', () => {
    const newPass = document.querySelector('input[name="newPass"]');
    const refreshPass = document.querySelector('input[name="refreshPass"]');
    const formPassword = document.querySelector('#formPassword');
    const newPasswordError = document.querySelector('#newPassword');
    const refreshPasswordError = document.querySelector('#refreshPassword');
    formPassword.addEventListener("submit", (e) => {
        if (!checkLenght(newPass, newPasswordError))
        {
            e.preventDefault();
            return;
        }

        if (!checkRefresh(newPass, refreshPass, newPasswordError, refreshPasswordError))
        {
            e.preventDefault();
            return;
        }
    });

    newPass.addEventListener("blur", () => {
        if (checkLenght(newPass, newPasswordError))
        {
            if (refreshPass.length > 0)
                checkRefresh(newPass, refreshPass, newPasswordError, refreshPasswordError);
        }
    });

    refreshPass.addEventListener("blur", () => {
        checkRefresh(newPass, refreshPass, newPasswordError, refreshPasswordError);
    });

    function checkLenght(element, errorElement)
    {
        if (element.value.length < 6)
        {
            errorElement.innerText = "Пароль должен быть не менее 6 символов";
            return false;
        }
        else
            errorElement.innerText = "";
        return true;
    }

    function checkRefresh(element1, element2, errorElement1, errorElement2)
    {
        if (element1.value != element2.value)
        {
            errorElement1.innerText = "Новый пароль и повтор нового пароля не совпадают";
            errorElement2.innerText = "Новый пароль и повтор нового пароля не совпадают";
            return false; 
        }
        else
        {
            newPasswordError.innerText = "";
            refreshPasswordError.innerText = "";
        }
        return true;
    }
});