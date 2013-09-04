CREATE USER 'theagent'@'%' IDENTIFIED BY 'tempPass';

GRANT USAGE ON *.* TO 'theagent'@'%';
GRANT SELECT, UPDATE, INSERT  ON `auctionsite`.* TO 'theagent'@'%';
FLUSH PRIVILEGES;