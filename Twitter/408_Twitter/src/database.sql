


CREATE TABLE User(
  id INT AUTO_INCREMENT NOT NULL,
  email VARCHAR (100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  fullName VARCHAR(100) NOT NULL,
  active TINYINT(1) DEFAULT 1,
  PRIMARY KEY(id) 
)
CREATE TABLE Tweets(
  id INT AUTO_INCREMENT NOT NULL,
  text VARCHAR(140),
  user_id INT NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
)

CREATE TABLE Comments(
    id INT AUTO_INCREMENT,
    comment varchar(160),
    tweet_id int,
    user_id int,
    PRIMARY KEY(id),
    FOREIGN KEY(tweet_id) REFERENCES Tweets(id),
    FOREIGN KEY(user_id) REFERENCES User(id)
)