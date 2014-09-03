<?php
/**
 * zmq-API v@PACKAGE_VERSION@ Docs build by DocThor [2014-08-19]
 * @package zmq
 */

/**
 * @package zmq
 */
class ZMQ
{
	const SOCKET_PAIR = 0;
	const SOCKET_PUB = 1;
	const SOCKET_SUB = 2;
	const SOCKET_XSUB = 10;
	const SOCKET_XPUB = 9;
	const SOCKET_REQ = 3;
	const SOCKET_REP = 4;
	const SOCKET_XREQ = 5;
	const SOCKET_XREP = 6;
	const SOCKET_PUSH = 8;
	const SOCKET_PULL = 7;
	const SOCKET_DEALER = 5;
	const SOCKET_ROUTER = 6;
	const SOCKET_STREAM = 11;
	const SOCKET_UPSTREAM = 7;
	const SOCKET_DOWNSTREAM = 8;
	const POLL_IN = 1;
	const POLL_OUT = 2;
	const MODE_SNDMORE = 2;
	/**
	 * @deprecated use MODE_DONTWAIT
	 */
	const MODE_NOBLOCK = 1;
	const MODE_DONTWAIT = 1;
	const DEVICE_FORWARDER = 2;
	const DEVICE_QUEUE = 3;
	const DEVICE_STREAMER = 1;
	const ERR_INTERNAL = -99;
	const ERR_EAGAIN = 35;
	const ERR_ENOTSUP = 45;
	const ERR_EFSM = 156384763;
	const ERR_ETERM = 156384765;
	const LIBZMQ_VER = '4.0.4';
	const SOCKOPT_HWM = 201;
	const SOCKOPT_SNDHWM = 23;
	const SOCKOPT_RCVHWM = 24;
	const SOCKOPT_AFFINITY = 4;
	const SOCKOPT_IDENTITY = 5;
	const SOCKOPT_RATE = 8;
	const SOCKOPT_RECOVERY_IVL = 9;
	const SOCKOPT_SNDBUF = 11;
	const SOCKOPT_RCVBUF = 12;
	const SOCKOPT_LINGER = 17;
	const SOCKOPT_RECONNECT_IVL = 18;
	const SOCKOPT_RECONNECT_IVL_MAX = 21;
	const SOCKOPT_BACKLOG = 19;
	const SOCKOPT_MAXMSGSIZE = 22;
	const SOCKOPT_SUBSCRIBE = 6;
	const SOCKOPT_UNSUBSCRIBE = 7;
	const SOCKOPT_TYPE = 16;
	const SOCKOPT_RCVMORE = 13;
	const SOCKOPT_FD = 14;
	const SOCKOPT_EVENTS = 15;
	const SOCKOPT_SNDTIMEO = 28;
	const SOCKOPT_RCVTIMEO = 27;
	const SOCKOPT_IPV4ONLY = 31;
	const SOCKOPT_LAST_ENDPOINT = 32;
	const SOCKOPT_TCP_KEEPALIVE = 34;
	const SOCKOPT_TCP_KEEPALIVE_IDLE = 36;
	const SOCKOPT_TCP_KEEPALIVE_CNT = 35;
	const SOCKOPT_TCP_KEEPALIVE_INTVL = 37;
	const SOCKOPT_TCP_ACCEPT_FILTER = 38;
	const SOCKOPT_DELAY_ATTACH_ON_CONNECT = 39;
	const SOCKOPT_XPUB_VERBOSE = 40;
	const SOCKOPT_ROUTER_RAW = 41;
	const SOCKOPT_IPV6 = 42;
	const SOCKOPT_PLAIN_SERVER = 44;
	const SOCKOPT_PLAIN_USERNAME = 45;
	const SOCKOPT_PLAIN_PASSWORD = 46;
	const SOCKOPT_CURVE_SERVER = 47;
	const SOCKOPT_CURVE_PUBLICKEY = 48;
	const SOCKOPT_CURVE_SECRETKEY = 49;
	const SOCKOPT_CURVE_SERVERKEY = 50;
	const SOCKOPT_PROBE_ROUTER = 51;
	const SOCKOPT_REQ_CORRELATE = 52;
	const SOCKOPT_REQ_RELAXED = 53;
	const SOCKOPT_CONFLATE = 54;
	const SOCKOPT_ZAP_DOMAIN = 55;
	const CTXOPT_MAX_SOCKETS = 2;
	const CTXOPT_MAX_SOCKETS_DEFAULT = 1023;
	/**
	 * A monotonic clock
	 *
	 * @return integer
	 */
	public function clock() {}
}
/**
 * @package zmq
 */
class ZMQContext
{
	/**
	 * Build a new ZMQContext object
	 *
	 * @param NULL|integer $io_threads
	 * @param NULL|boolean $persistent
	 * @return ZMQContext
	 */
	public function __construct($io_threads=NULL, $persistent=NULL) {}
	public function getSocket($type, $dsn, $on_new_socket=NULL) {}
	public function isPersistent() {}
	/**
	 * Set a context option
	 *
	 * @param int $option
	 * @param int $value
	 * @return ZMQContext
	 */
	public function setOpt($option, $value) {}
	/**
	 * Set a context option
	 *
	 * @param int $option
	 * @return ZMQContext
	 */
	public function getOpt($option) {}
}
/**
 * @package zmq
 */
class ZMQSocket
{
	/**
	 * Build a new ZMQSocket object
	 *
	 * @param ZMQContext $context
	 * @param integer $type
	 * @param string $persistent_id
	 * @param NULL|callback $on_new_socket
	 * @return ZMQSocket
	 */
	public function __construct(ZMQContext $context, $type, $persistent_id="", $on_new_socket=NULL) {}
	/**
	 * Send a message. Return true if message was sent and false on EAGAIN
	 *
	 * @param string $message
	 * @param NULL|integer $mode
	 * @return ZMQSocket
	 */
	public function send($message, $mode=NULL) {}

	/**
	 * @param NULL|string $mode
	 * @return string message
	 */
	public function recv($mode=NULL) {}
	/**
	 * Send a multipart message. Return true if message was sent and false on EAGAIN
	 *
	 * @param array $message
	 * @param NULL|integer $mode
	 * @return ZMQSocket
	 */
	public function sendMulti(array $message, $mode=NULL) {}
	public function recvMulti($mode="") {}
	/**
	 * Bind the socket to an endpoint
	 *
	 * @param string $dsn
	 * @param NULL|boolean $force
	 * @return ZMQSocket
	 */
	public function bind($dsn, $force=FALSE) {}
	/**
	 * Connect the socket to an endpoint
	 *
	 * @param string $dsn
	 * @param NULL|boolean $force
	 * @return ZMQSocket
	 */
	public function connect($dsn, $force=FALSE) {}
	/**
	 * Unbind the socket from an endpoint
	 *
	 * @param string $dsn
	 * @return ZMQSocket
	 */
	public function unbind($dsn) {}
	/**
	 * Disconnect the socket from an endpoint
	 *
	 * @param string $dsn
	 * @return ZMQSocket
	 */
	public function disconnect($dsn) {}
	public function setSockOpt($key, $value) {}
	public function getEndpoints() {}
	public function getSocketType() {}
	public function isPersistent() {}
	public function getPersistentId() {}
	public function getSockOpt($key) {}
	public function sendMsg($message, $mode="") {}
	public function recvMsg($mode="") {}
}
/**
 * @package zmq
 */
class ZMQPoll {
	/**
	 * Add a ZMQSocket object into the pollset
	 *
	 * @param mixed $entry
	 * @param integer $type
	 * @return string
	 */
	public function add($entry, $type) {}
	/**
	 * Poll the sockets
	 *
	 * @param array $readable
	 * @param array $writable
	 * @param integer $timeout
	 * @return integer
	 */
	public function poll(array &$readable, array &$writable, $timeout=-1) {}

	/**
	 * @return array
	 */
	public function getLastErrors() {}
	/**
	 * Remove item from poll set
	 *
	 * @param mixed $item
	 * @return boolean
	 */
	public function remove($item) {}
	/**
	 * Returns the number of items in the set
	 *
	 * @return integer
	 */
	public function count() {}
	/**
	 * Clear the pollset
	 *
	 * @return ZMQPoll
	 */
	public function clear() {}
}
/**
 * @package zmq
 */
class ZMQDevice {

	/**
	 * Construct a device
	 *
	 * @param ZMQSocket $frontend
	 * @param ZMQSocket $backend
	 * @param ZMQSocket $listener
	 */
	public function __construct(ZMQSocket $frontend, ZMQSocket $backend, ZMQSocket $listener=NULL) {}
	/**
	 * Start a device
	 *
	 * @return void
	 */
	public function run() {}

	/**
	 * @param callable $idle_callback
	 * @param integer $timeout
	 * @param NULL|mixed $user_data
	 */
	public function setIdleCallback(callable $idle_callback, $timeout, $user_data=NULL) {}

	/**
	 * @param integer $timeout
	 */
	public function setIdleTimeout($timeout) {}
	public function getIdleTimeout() {}
	public function setTimerCallback($idle_callback, $timeout, $user_data=NULL) {}
	public function setTimerTimeout($timeout) {}
	public function getTimerTimeout() {}
}
/**
 * @package zmq
 */
class ZMQException extends Exception {
}
/**
 * @package zmq
 */
class ZMQContextException extends ZMQException {
}
/**
 * @package zmq
 */
class ZMQSocketException extends ZMQException {
}
/**
 * @package zmq
 */
class ZMQPollException extends ZMQException {
}
/**
 * @package zmq
 */
class ZMQDeviceException extends ZMQException {
}
