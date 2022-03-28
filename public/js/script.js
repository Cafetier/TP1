window.addEventListener('DOMContentLoaded', (event) => {
    // remove the preloader
    //document.querySelector('.preloader').classList.remove("preloader");

    // assign masks to pattern elem
    new Inputmask();
    const elem_pattern = document.querySelectorAll('[pattern]');
    for (let i = 0; i < elem_pattern.length; i++)
        Inputmask({ regex: elem_pattern[i].pattern }).mask(elem_pattern[i]);

    // assign telephone masks to input tel
    const tel_inputs = document.querySelectorAll('input[type=tel]');
    for (let i = 0; i < tel_inputs.length; i++)
        Inputmask({ regex: `\\([0-9]{3}\\) [0-9]{3}-[0-9]{4}` }).mask(tel_inputs[i]);
});