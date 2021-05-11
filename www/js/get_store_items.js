function gid(id) { return document.getElementById(id) }

function getItems(catId) {
	var xhr = new XMLHttpRequest()

	xhr.open('GET', 'get_items.php?q=' + catId, true)
	xhr.setRequestHeader('Cache-Control', 'max-age=300')

	xhr.onload = function() {
		if (this.status == 200) {
			// FIXME: we should only set style to none for el that's set to block
			document.getElementsByName('cat-items').forEach(element => 
				element.style.display = 'none' )

			gid(catId).innerHTML = this.responseText
			gid(catId).style.display = 'block'
		}
	}
	xhr.send()
}
