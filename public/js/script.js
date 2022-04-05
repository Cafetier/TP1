/**
 * 
 * This function async submit a form using its method and values
 * 
 * @param object form the form you need to submit
 * 
 */
async function SubmitForm(form){
    fetch(form.action, {
        method: form.method,
        headers: {"Content-type": "application/x-www-form-urlencoded; charset=UTF-8"},
        body: new FormData(form),
    })
    .catch((e) => {
        throw new Error(e);
    });
}

// assign js submit 
async function AssignAsyncForms(){
    document.querySelectorAll('form').forEach(e=>{
        e.onsubmit = async ee => {
            ee.preventDefault();
            const form = ee.target;
            console.log('asking db...');
            try{
                await SubmitForm(form);
                console.log('successfully entered in db');
            }
            catch(e){
                console.log(e);
            }
        };
    });
}

window.addEventListener('DOMContentLoaded', (e) => {
    // remove the preloader
    //document.querySelector('.preloader').classList.remove("preloader");

    //assign js async submit
    AssignAsyncForms();
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