var container = document.getElementById('webterm'),
socket = io('http://127.0.0.1:3000/pty'), term, stream;

// used to measure how large the webterm's col/row should be.
container.innerHTML = "<div>Connecting to server ... </div><div id='sample' style='position:absolute;'>&nbsp;</div>";

// Workaround exception on send. See https://github.com/nkzawa/socket.io-stream/issues/87.
ss.forceBase64 = true;

// setting tabindex makes the element focusable
container.tabindex = 0;

// create terminal and measure its col/row size
function resizeWebterm(isFirstLoad){
	var el = document.getElementsByTagName('pre')[0];
	var hh,ww;
	if(isFirstLoad){
		hh = el.getBoundingClientRect().height;
		ww = document.getElementById('sample').getBoundingClientRect().width;
	}
	else{
		console.log(el.childNodes);
		hh = el.childNodes[0].getBoundingClientRect().height;
		ww = document.querySelector("pre span")[0].getBoundingClientRect().width;
	}

	var body = document.getElementsByTagName('body')[0];
	//console.log(window.innerHeight);
	var HH = window.innerHeight - 10;// sub the padding 5*2 pixel
	var WW = window.innerWidth - 10; // sub the padding 5*2 pixel

	var col = Math.floor(WW/ww)-1;
	var row = Math.floor(HH/hh)-1;

	col = col ? col : 100;
	row = row ? row : 20;

	container.dataset.columns = col;
	container.dataset.rows = row;
}
resizeWebterm(true);
term = new Terminal(container.dataset);

// TODO on page resize, write to socket and make server size change its option

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
var u_name = getCookie('username');
u_name = u_name=='' ? '87878787' : u_name
container.dataset.name = u_name;

// Create bidirectional stream
stream = ss.createStream({decodeStrings: false, encoding: 'utf-8'});

// Send stream and options to the server
ss(socket).emit('new', stream, container.dataset);

if(container.dataset.exec)
	stream.write(container.dataset.exec + "\n");

// Connect everything up
stream.pipe(term).dom(container).pipe(stream);





document.addEventListener('DOMContentLoaded',function(){

	// auto-focus to webterm after page loaded
    //
    // TODO:
    // This doesn't work on FireFox, current workaround is set unfocus to nav-bar in index.php, got to find a better solution.
    //
    // Note:
    // "focus()" not work in FireFox. It might because we want to focus into an iframe, which is blocked by FireFox because of security issue.
	document.getElementById('webterm').focus();

	document.getElementById('webterm').addEventListener('keydown', function(e){
		var k = e.charCode || e.keyCode;

		// F5
		if(k==116){
			window.location.reload();
		}

		// NOTE:
		// Other key handling is modified in terminal.js directly.
		// All modification is commented with "HUBERT" tag

	});

});





