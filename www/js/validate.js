function gid(id) { return document.getElementById(id) }

function validateForm() {
	let errors = []

	const letterRegex = /^[a-z]+$/i
	const alphanumericRegex = /^[a-z0-9]+$/i
	// matches exactly 4 occurances of any base 10 digit e.g 1234 2378 2345
	const postcodeRegex = /^[0-9]{4}$/
	// credit: https://stackoverflow.com/questions/39990179/regex-for-australian-phone-number-validation
	// regular expression explained: https://regex101.com/r/dkFASs/6
	const telRegex = /^(?:\+?(61))? ?(?:\((?=.*\)))?(0?[2-57-8])\)? ?(\d\d(?:[- ](?=\d{3})|(?!\d\d[- ]?\d[- ]))\d\d[- ]?\d[- ]?\d{3})$/
	// credit: https://www.w3resource.com/javascript/form/email-validation.php
	// regular expression explained: https://regex101.com/r/46ITmE/1
	const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/

	if (!gid('first-name').value.match(letterRegex) || gid(('first-name').value === '')) {
		errors.push('ERROR: Please enter a valid first name!')
	}

	if (!gid('last-name').value.match(letterRegex) || gid(('last-name').value === '')) {
		errors.push('ERROR: Please enter a valid last name!')
	}

	if (!gid('address').value.match(alphanumericRegex) || gid('address').value === '') {
		errors.push('ERROR: Please enter an address!')
	}

	if (!gid('city').value.match(letterRegex) || gid('city').value == '') errors.push('ERROR: Please a valid city!')
	if (!gid('state').value.match(letterRegex) || gid('state').value == '') errors.push('ERROR: Please a valid state!')
	if (!gid('postcode').value.match(postcodeRegex)) errors.push('ERROR: Please enter a valid postcode!')
	if (!gid('tel').value.match(telRegex)) errors.push('ERROR: Please enter a valid telephone number!')
	if (!gid('email').value.match(emailRegex)) errors.push('ERROR: Please enter a valid email address!')
	if (errors.length > 0) { renderBox(gid('error-box'), errors); return false }
}

function renderBox(boxType, array) {
	boxType.innerHTML = ''
	array.forEach(el => { boxType.innerHTML += `<p>${el}</p>` })
	boxType.style.display = 'block'
}
