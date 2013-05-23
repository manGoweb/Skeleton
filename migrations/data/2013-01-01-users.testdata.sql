-- test user; password is 'test' (username as a salt)
INSERT INTO `users` (`username`, `password`) VALUES ('test', sha1('testtest'));
