var http = require('http'),
    fs = require('fs'),
    socketio = require('socket.io'),
    child_pty = require('child_pty'),
    ss = require('socket.io-stream'),
    mysql = require('mysql'),
    exec = require('child_process').exec,
    path = require('path');

var config = require('./config.json');

var server = http.createServer()
	.listen(config.port, config.interface);
	var ptys = {};


/**
 *  Debug argument, for development, close it on deploy
 */

var debug = true;
if(debug){
    console.log('**************  Warning *************');
    console.log('You ar under debug mode, plz close this setting in app.js if you are note debugging');

    // Run an alternative docker container
    DEBUG_DOCKER_CMD = "var pty = child_pty.spawn('/bin/sh', ['-c', 'echo \" ***** YOU ARE UNDER DEBUG MODE, PLZ CLOSE IT IN app.js IF YOU ARE NOT DEBUGGING! *****\"; echo \"\" ; bash'], options);" ;

}


/** 
 * connect to MySQL
 */
var db_conn = mysql.createConnection({
	host: 'localhost',
	user: 'ctf',
	password: 'ctf'
});
var is_db_connected = false;
db_conn.connect(function(err){
	if (err) throw err;
	console.log('Connected to MySQL!');
	is_db_connected = true;
});
function query_db(sql, f){
	if(!is_db_connected){
		f('');
		return;
	}
	db_conn.query(sql, function(err, result){
		var ret = err ? '' : result;
		f(result);
	});
}


/**
 *  Deal with file request
 */
server.on('request', function(req, res) {
	var file = null;
	console.log(req.url);
	switch(req.url) {
		case '/':
		case '/index.html':
			file = '/index.html';
			break;
		case '/webterm.css':
			console.log('css');
			file = '/webterm.css';
			break;
		case '/webterm.js':
			file = '/webterm.js';
			break;
		case '/terminal.js':
			file = '/node_modules/terminal.js/dist/terminal.js';
			break;
		case '/socket.io-stream.js':
			file = '/node_modules/socket.io-stream/socket.io-stream.js';
			break;
		default:
			res.writeHead(404, {'Content-Type': 'text/plain'});
			res.end('404 Not Found');
			return;
	}

    // write CORS header
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Request-Method', '*');
    res.setHeader('Access-Control-Allow-Headers', '*');
    res.writeHead(200);

	fs.createReadStream(path.join(__dirname, file)).pipe(res);
});

/**
 *  Deal with new connection.
 */
socketio(server).of('pty').on('connection', function(socket) {

	var ip = socket.handshake.address;

	socket.emit('measure', {'msg': 'Creating webterm ... '});

	// receives a bidirectional pipe from the client see index.html
	// for the client-side
	ss(socket).on('new', function(stream, options) {
		var name = options.name;

		console.log('New connection from : ' + ip + ' : ' + name);
		composeDockerIdentifier(ip, name, function(uid){

            // Run a replaced docker image
            if (debug){
                eval(DEBUG_DOCKER_CMD);
                pty.stdin.on('data', function(c){
                	if(c.length>10){
                    	console.log(10);
                    	return;
                	}
                })
                pty.stdout.pipe(stream).pipe(pty.stdin);
                ptys[uid] = pty;
                socket.on('disconnect', function() {
                	pty.kill('SIGHUP');
                	killDocker(uid);
                	delete ptys[uid];
                });
                return;
            }


			// user or docker-container does not exists, throw error message to user
			if(uid==null){
				var err_msg = 'Fatal Error: No such user, please login again';
				stream.write(new ss.Buffer(err_msg));
				//var pty = child_pty.spawn('/bin/sh', [], options);
				//pty.stdin.write(err_msg);
				//pty.stdout.pipe(stream);
				//socket.on('disconnect', function(){
				//	pty.kill('SIGHUP');
				//});
			}

			// give the identified docker container shell to user
			else{
				var pty = startDocker(uid, options);
				pty.stdout.pipe(stream).pipe(pty.stdin);
				ptys[uid] = pty;

				socket.on('disconnect', function() {
					pty.kill('SIGHUP');
					killDocker(uid);
					delete ptys[uid];
				});
			}
		});
	});
});

process.on('exit', function() {
	var k = Object.keys(ptys);
	var i;

	for(i = 0; i < k.length; i++) {
		var uid = k[i];
		ptys[uid].kill('SIGHUP');
		killDocker(uid);
	}
});

console.log('Listening on ' + config.interface + ':' + config.port);


/**
 * Utilities
 */

function composeDockerIdentifier(ip, name, f){
	sql = 'SELECT * FROM ctf.Userinfo where LastIP="' + ip + '" AND ID="' + name+'"';
	query_db(sql, function(result){
		// the ip-name pair is undefined
		if(result==='' || result.length!=1){
			f(null);
		}
		else{
			var uid = result[0]['uid'];
			isUidValid(uid, function(isValid){
				if(isValid)
					f(result[0]['uid']);
				else
					f(null);
			})
		}
	});
}

function isUidValid(uid, f){
	exec('docker ps -a | grep -a '+uid, function(err, stdout, srderr){
		if(stdout) 
			return f(true);
		else 
			return f(false);
	});
}

function startDocker(uid, options){
	var docker_start_cmd = "docker start user-"+uid ;
	var docker_exec_cmd  = "docker exec -it user-" + uid + " script /dev/null -c 'tmux'";
	var docker_cmd = docker_start_cmd + ' ; ' + docker_exec_cmd;
	var pty = child_pty.spawn('/bin/sh', ['-c', docker_cmd], options);
	return pty;
}

function killDocker(uid){
	var cmd = "docker stop user-"+uid;
	exec(cmd, function(error, stout, stderr){
		if(error || stderr){
			var e = error ? error : stderr;
			console.log('Error occurs while killing uid='+uid+', error:'+e);
		}
	});
}

/**
 *	Strict the maximum size of data a stream can send.
 *
 *	stream: the stream gonna strict
 *	strictSize: the maximum length of characters a stream can send
 */
strictSize = 10000;
function strictStream(stream){
	stream.on('data', function(chunk){
		if(chunk.length >= strictSize){
			return; // TODO: find a way to do this work.
		}
	})
}
