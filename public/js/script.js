/**
 * This function async submit a form using its method and values
 * @param object form the form you need to submit
 */
async function SubmitForm(form) {
    const f = new FormData(form);
    let object = {};
    f.forEach((value, key) => object[key] = value);
    const json = JSON.stringify(object);
    const r = await fetch(form.action, {
        method: form.method,
        headers: { "Content-type": "application/json" },
        body: json
    })
        .catch((e) => {
            throw new Error(e);
        });
    const data = await r.text();
    console.log(data);
    return data;
}

// assign js submit 
async function AssignAsyncForms() {
    document.querySelectorAll('form').forEach(e => {
        e.onsubmit = async ee => {
            ee.preventDefault();
            const form = ee.target;
            console.log('asking db...');
            try {
                const r = await SubmitForm(form);
                if (r === null) window.location.href = "Index";  // this should not be here
                console.log('successfully entered in db');
            }
            catch (e) {
                console.log(e);
            }
        };
    });
}

/**
 * This is an event handler for nullable filters
 * @param object checkbox  the checkbox input 
 */
const OnCheckboxInput = checkbox => {
    const parent = checkbox.parentElement.parentElement.parentElement;
    const inputs = parent.querySelectorAll('input:not(.filter-title input), select');
    // disable child inputs if checkbox unchecked
    !checkbox.checked ?
        inputs.forEach(e =>
            e.disabled = true
        ) :
        inputs.forEach(e =>
            e.disabled = false
        );
}

window.addEventListener('DOMContentLoaded', (e) => {
    // remove the preloader
    document.querySelector('.preloader').classList.remove("preloader");

    // assign masks to pattern elem
    new Inputmask();
    const elem_pattern = document.querySelectorAll('[pattern]');
    for (let i = 0; i < elem_pattern.length; i++)
        Inputmask({ regex: elem_pattern[i].pattern }).mask(elem_pattern[i]);

    // assign telephone masks to input tel
    const tel_inputs = document.querySelectorAll('input[type=tel]');
    for (let i = 0; i < tel_inputs.length; i++)
        Inputmask({ regex: `\\([0-9]{3}\\) [0-9]{3}-[0-9]{4}` }).mask(tel_inputs[i]);

    // nullable value
    const null_checkbox = document.querySelectorAll('.filter-title input[type=checkbox]');
    null_checkbox.forEach(e => {
        OnCheckboxInput(e);
        e.onchange = e => { OnCheckboxInput(e.target) };
    });

    const filter_btn_reset = document.querySelector('#filter_reset');
    if (filter_btn_reset === null) return;
    filter_btn_reset.onclick = e => {
        const inputs = document.querySelectorAll('.filter-title input');
        inputs.forEach(e =>
            e.checked = false
        );
        null_checkbox.forEach(e =>
            OnCheckboxInput(e)
        );
    };
});