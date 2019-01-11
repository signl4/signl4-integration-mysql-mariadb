
/* Create sample database table */
CREATE TABLE `MachineData` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MachineName` varchar(150) DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL,
  `Temperature` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4


/* Insert sample data */
INSERT INTO MachineData (MachineName, Timestamp, Temperature) VALUES ('Machine4', Now(), 40);
INSERT INTO MachineData (MachineName, Timestamp, Temperature) VALUES ('Machine4', Now(), 42);
INSERT INTO MachineData (MachineName, Timestamp, Temperature) VALUES ('Machine4', Now(), 84);
INSERT INTO MachineData (MachineName, Timestamp, Temperature) VALUES ('Machine5', Now(), 38);
