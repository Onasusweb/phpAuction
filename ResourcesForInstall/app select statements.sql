SELECT id, ititle,isummary,ipicture FROM items ORDER BY id desc;

SELECT items.isummary, items.ipicture, items.itemadded, items.ilastdate, items.imin, items.iincrement, bids.bAmount, bids.dateAdded, people.usrfirst FROM items INNER JOIN bids ON items.id = bids.itemId INNER JOIN people ON people.id = bids.userId WHERE items.id =1 ORDER BY bids.id DESC  LIMIT 1
/*
CREATE TABLE IF NOT EXISTS `bids` (
  `id` int(11) NOT NULL auto_increment,
  `itemId` varchar(50) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `bAmount` decimal(10,0) default NULL,
  `dateAdded` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL auto_increment,
  `ititle` varchar(250) NOT NULL,
  `isummary` text NOT NULL,
  `ipicture` varchar(60) default NULL,
  `itemadded` datetime default NULL,
  `ilastdate` datetime default NULL,
  `imin` decimal(10,0) NOT NULL,
  `iincrement` decimal(10,0) NOT NULL,
  `iaddedby` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `people` (
  `id` int(11) NOT NULL auto_increment,
  `usrfirst` varchar(60) NOT NULL,
  `usrlast` varchar(60) NOT NULL,
  `usremail` varchar(250) NOT NULL,
  `usrpass` varchar(250) default NULL,
  `usrbids` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
*/