const getFormFieldValue = (input) => {
    if (input.type === "checkbox") {
        return input.checked;
    }

    return input.value;
};

export const getFormData = (id, isUpdate) => {
    const formData = new FormData();

    // laravel - PUT method
    if (isUpdate) {
        formData.append("_method", "PUT");
    }

    document
        .getElementById(id)
        .querySelectorAll(`select,input,textarea`)
        .forEach((input) =>
            formData.append(input.name, getFormFieldValue(input))
        );

    return formData;
};

export const debounce = (func, delay = 700) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
};

export const clearFields = (id) => {
    const container = document.getElementById(id);
    const inputs = container.querySelectorAll("input, textarea, select");

    inputs.forEach((input) => {
        switch (input.type) {
            case "checkbox":
            case "radio":
                input.checked = false;
                break;
            default:
                input.value = "";
                break;
        }
    });
};
