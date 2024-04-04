Table: edits

|Column name|Data type|Description          |
|-----------|---------|---------------------|
|edit_id    |integer  |Primary key, auto-increment|
|article_id |integer  |Foreign key referencing articles|
|ip_address |varchar  |Stores the IP address of the editor|
|edit_time  |datetime |The date and time the edit was made|


Indexes:
Primary key index on edit_id
Index on article_id to efficiently retrieve edits related to a specific article
Index on ip_address for efficient retrieval of edits made from a specific IP address
Index on edit_time for time-based queries


Table: articles

|Column name|Data type|Description          |
|-----------|---------|---------------------|
|article_id |integer  |Primary key, auto-increment|
|title      |varchar  |Stores the title of the article|
|body       |text     |Stores the content of the article|
|created_at |datetime |The date and time the article was created|
|updated_at |datetime |The date and time the article was last updated|


Indexes:
Primary key index on article_id
Index on title for efficient retrieval of article details by title


//Queries

CREATE TABLE edits (
  edit_id INT AUTO_INCREMENT PRIMARY KEY,
  article_id INT NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  edit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX(article_id),
  INDEX(ip_address),
  INDEX(edit_time)
);

CREATE INDEX edits_article_id_idx ON edits (article_id);
CREATE INDEX edits_ip_address_idx ON edits (ip_address);
CREATE INDEX edits_edit_time_idx ON edits (edit_time);


CREATE TABLE articles (
  article_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX idx_articles_title ON articles (title(255));
