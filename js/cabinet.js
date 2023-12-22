document.addEventListener('DOMContentLoaded', () => {
    const formInfo = document.querySelector("#formInfo");
    const lastName = document.querySelector("#LastName");
    const lastNameErr = document.querySelector("#lastNameErr");
    const name = document.querySelector("#Name");
    const nameErr = document.querySelector("#nameErr");
    const patronymic = document.querySelector("#Patronymic");
    const patrinymicErr = document.querySelector("#patrinymicErr");

    formInfo.addEventListener("submit", (e) => {
        if (validateLastName(lastName, lastNameErr) && validateIm(name, nameErr) && validateOtch(patronymic, patrinymicErr))
        {
            
        }
        else
            e.preventDefault();
    });

    lastName.addEventListener("blur", () => {
        validateLastName(lastName, lastNameErr);
    });

    name.addEventListener("blur", () => {
        validateIm(name, nameErr);
    });

    patronymic.addEventListener("blur", () => {
        validateOtch(patronymic, patrinymicErr);
    });
});

function validateLastName(element, elementErr) {
    if (element.value === '') {
        elementErr.innerText = 'Фамилия является обязательным полем.';
        return false;
    } else if (!/^[A-ЯЁа-яё]+$/.test(element.value)) {
        elementErr.innerText = 'Поле может содержать только кириллицу.';
        return false;
    } else {
        elementErr.innerText = '';
    }
    return true;
}

function validateIm(element, elementErr) {
    if (element.value === '') {
        elementErr.textContent = 'Имя является обязательным полем.';
        return false;
    } else if (!/^[A-ЯЁа-яё]+$/.test(element.value)) {
        elementErr.textContent = 'Поле может содержать только кириллицу.';
        return false;
    } else {
        elementErr.textContent = '';
    }
    return true;
}

function validateOtch(element, elementErr) {
    if (element.value === '') {
        elementErr.textContent = 'Отчество является обязательным полем.';
        return false;
    } else if (!/^[A-ЯЁа-яё]+$/.test(element.value)) {
        elementErr.textContent = 'Поле может содержать только кириллицу.';
        return false;
    } else {
        elementErr.textContent = '';
    }

    return true;
}