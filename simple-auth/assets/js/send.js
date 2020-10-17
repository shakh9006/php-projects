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
    let email = document.querySelector('#inputEmail') || {}
    let password = document.querySelector('#inputPassword') || {}
    return { email: email.value, password: password.value }
}

function init_sign_up() {
    const errorData = []
    let email = document.querySelector('#inputEmail') || {}
    let name = document.querySelector('#inputName') || {}
    let password = document.querySelector('#inputPassword') || {}
    let rePassword = document.querySelector('#inputPasswordRepeat') || {}

    if ( name.value && name.value.length < 2 )
        errorData.push('Name field length must be at least 3')

    if ( (Object.values(password).length && Object.values(rePassword).length) &&  password.value !== rePassword.value )
        errorData.push('Re-password is incorrect')

    if ( errorData.length ) {
        render_info('error', errorData)
        return false
    }

    return { email: email.value, name: name.value, password: password.value }
}

function render_info( type , data) {
    if ( !(data && data.length) )
        return

    let info_content = document.querySelector('#info-content')
    info_content.className = type
    info_content.innerHTML = ''

    if ( typeof data === 'object' && !Array.isArray(data) )
        data = Object.values(data)

    data.forEach(info => info_content.innerHTML += `<div class="info-item">${info}</div>` )
}

function send(action, data) {
    const xhr = new XMLHttpRequest()
    let esc   = encodeURIComponent;
    const url = Object.keys(data).map((k) => `${esc(k)}=${esc(data[k])}`).join('&')

    xhr.open('GET', action + '?' + url)
    xhr.send(JSON.stringify(data))
    xhr.onload = () => {
        if (xhr.status !== 200) {
            alert(`Error ${xhr.status}: ${xhr.statusText}`)
        } else {
            const response = JSON.parse(xhr.response)
            Object.keys(response).forEach(k => {
                if ( typeof response[k] === "object" )
                    render_info(k, response[k])

                if ( response.success && response.redirect )
                    window.location.replace(response.redirect)
            })
        }
    }
}