function gid(id) { return document.getElementById(id) }

function validateForm() {
	let errors = []

	if (gid('first-name').value == '' || gid('last-name').value == '') {
		errors.push('ERROR: Please enter your full name!')
	}

	if (gid('address').value == '') errors.push('ERROR: Please enter an address!')
	if (gid('city').value == '') errors.push('ERROR: Please enter your city!')
	if (gid('state').value == '') errors.push('ERROR: Please enter your state!')

	// matches exactly 4 occurances of any base 10 digit e.g 1234 2378 2345
	const postcodeRegex = /^[0-9]{4}$/
	if (!gid('postcode').value.match(postcodeRegex)) errors.push('ERROR: Please enter a valid postcode!')

	// regular expression explained: https://regex101.com/r/eiufOH/2
	const telRegex = /^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$/
	if (!gid('tel').value.match(telRegex)) errors.push('ERROR: Please enter a valid telephone number!')

	// regular expression explained: https://regex101.com/r/46ITmE/1
	const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
	if (!gid('email').value.match(emailRegex)) errors.push('ERROR: Please enter a valid email address!')

	if (errors.length > 0) { renderBox(gid('error-box'), errors); return false }
}

function renderBox(boxType, array) {
	boxType.innerHTML = ''
	array.forEach(el => { boxType.innerHTML += `<p>${el}</p>` })
	boxType.style.display = 'block'
}
