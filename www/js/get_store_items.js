function gen(name) { return document.getElementsByName(name) }
function gid(id) { return document.getElementById(id) }

function getItems(catId) {
	var xhr = new XMLHttpRequest()
	xhr.open('GET', 'get_items.php?q=' + catId, true)
	xhr.onload = function() {
		if (this.status == 200) {
			gen('cat-items').forEach(element => element.style.display = 'none' )

			gid(catId).innerHTML = this.responseText
			gid(catId).style.display = 'block'
		}
	}
	xhr.send()
}
