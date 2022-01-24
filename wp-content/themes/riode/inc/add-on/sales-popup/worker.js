var products = [], try_count = 0, current = 0, interval_timer = null;

function load_products(ajaxurl, nonce) {
	if (products.length) {
		current = ( current + 1 ) % products.length;
		postMessage(products[current]);
	} else if (try_count < 3) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', ajaxurl, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
			if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
				try {
					res = JSON.parse( xhr.responseText );
					if ( res.length ) {
						products = res;
						postMessage(products[0]);
					}
				} catch ( error ) {
					console.warn( error );
				}
			}
		};
		xhr.send('action=riode_sales_popup_products&nonce=' + nonce);
		try_count++;
	} else if (interval_timer) {
		clearInterval(interval_timer);
		close();
	}
}

onmessage = function(e) {
	if (e.data) {
		if (e.data.init) {
			setTimeout(function() {
				load_products(e.data.ajaxurl, e.data.nonce);
				interval_timer = setInterval(function() {
					load_products(e.data.ajaxurl, e.data.nonce);
				}, parseInt(e.data.interval, 10));
			}, parseInt(e.data.start, 10));
		} else if (e.data.exit) {
			close();
		}
	}
};
