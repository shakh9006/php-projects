(function () {
    const form = document.querySelector('#form')
    form.addEventListener('submit', (e) => {
        e.preventDefault()
        let data = null
        const action = e.target.action

        if ( action && action.indexOf('sign-in') !== -1 )
             data = init_sign_in()
        else if (action && action.indexOf('sign-up') !== -1 )
             data = init_sign_up()

        if ( data )
            send(action, data)
    })
})();

function init_sign_in() {
    let email = document.querySelector('#inputEmail')
    let password = document.querySelector('#inputPassword')
    return { email, password }
}

function init_sign_up() {
    const errorData = [];
    let email = document.querySelector('#inputEmail')
    let name = document.querySelector('#inputName')
    let password = document.querySelector('#inputPassword')
    let rePassword = document.querySelector('#inputPasswordRepeat')

    if ( name.length < 2 )
        errorData.push('Name field length must be at least 3')

    if ( password !== rePassword )
        errorData.push('Re-password is incorrect')

    if ( errorData.length ) {
        render_info('error', errorData)
        return false
    }

    return { email, name, password }
}

function render_info( type , data) {
    let info_content = document.querySelector('#info-content')
    console.log(info_content)
    info_content.className = type
    info_content.innerHTML = ''

    if ( typeof data === 'object' && !Array.isArray(data) )
        data = Object.values(data)

    console.log(data)
    data.forEach(info => info_content.innerHTML += `<div class="info-item">${info}</div>` )
}

function send() {
    console.log('send')
}