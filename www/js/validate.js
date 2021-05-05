function gid(id) { return document.getElementById(id) }

function validateForm() {
	let errors = []

	if (gid('first-name').value == '' || gid('last-name').value == '') {
		errors.push('ERROR: Please enter your full name')
	}

	if (gid('address').value == '') {
		errors.push('ERROR: Please enter an address!')
	} 

	if (gid('city').value == '') {
		errors.push('ERROR: Please enter your city!')
	} 

	if (gid('state').value == '') {
		errors.push('ERROR: Please enter your state!')
	} 

	if (gid('postcode').value == '') {
		errors.push('ERROR: Please enter your postcode!')
	} 

	if (gid('tel').value == '') {
		errors.push('ERROR: Please enter your telephone number!')
	} 

	const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/

	if (!gid('email').value.match(emailRegex)) {
		errors.push('ERROR: Please enter a valid email address!')
	}

	if (errors.length > 0) { renderBox(gid('error-box'), errors); return false }
}

function renderBox(boxType, array) {
	boxType.innerHTML = ''
	array.forEach(el => { boxType.innerHTML += `<p>${el}</p>` })
	boxType.style.display = 'block'
}
