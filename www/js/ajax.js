const Ajax = {
	gid: id => { return document.getElementById(id) },

	getItems: catId => {
		var xhr = new XMLHttpRequest()

		xhr.open('GET', 'get_items.php?q=' + catId, true)
		xhr.setRequestHeader('Cache-Control', 'max-age=300')

		xhr.onload = function() {
			if (this.status == 200) {
				document.getElementsByName('cat-items').forEach(element => 
					element.style.display = 'none' )

				Ajax.gid(catId).innerHTML = this.responseText
				Ajax.gid(catId).style.display = 'block'
			}
		}
		xhr.send()
	},

	removeItem: id => {
		var xhr = new XMLHttpRequest()

		xhr.open('GET', 'removefromcart.php?id=' + id, true)
		xhr.onload = function() {
			if (this.status == 200) {
				Ajax.gid('cart-container').innerHTML = this.responseText
			}
		}
		xhr.send()
	}
}
