/**
 * 
 * This function async submit a form using its method and values
 * 
 * @param object form the form you need to submit
 * 
 */
async function SubmitForm(form){
    // Post data using the Fetch API
    fetch(form.action, {
        method: form.method,
        body: new FormData(form),
    })
    .catch((e) => {
      console.log(e)
    });
}

// assign js submit 
const assign_form_submit = async function(){
    document.querySelectorAll('form').forEach(e=>{
        console.log(e);
        e.onsubmit = async ee=>{
            ee.preventDefault();
            const form = ee.target;
            await SubmitForm(form);
        };
    });
}

window.addEventListener('DOMContentLoaded', (e) => {
    // remove the preloader
    //document.querySelector('.preloader').classList.remove("preloader");

    //assign js async submit
    assign_form_submit();
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