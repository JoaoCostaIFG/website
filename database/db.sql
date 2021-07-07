-- || USER --
DROP TABLE IF EXISTS User;
CREATE TABLE User (
  user_id INTEGER PRIMARY KEY ASC,
  user_username TEXT UNIQUE NOT NULL,
  user_password TEXT NOT NULL
);

-- || BLOG --
DROP TABLE IF EXISTS Blog;
CREATE TABLE Blog (
  blog_id INTEGER PRIMARY KEY ASC,
  blog_date INTEGER NOT NULL DEFAULT (strftime('%s', CURRENT_TIMESTAMP)),
  blog_title TEXT UNIQUE NOT NULL,
  blog_intro TEXT,
  blog_content TEXT NOT NULL,
  blog_visible INTEGER NOT NULL DEFAULT 0
);

DROP INDEX IF EXISTS idx_blog_date;
CREATE INDEX idx_blog_date
ON Blog(blog_date);

DROP TABLE IF EXISTS Edit;
CREATE TABLE Edit (
  edit_id INTEGER PRIMARY KEY ASC,
  edit_date INTEGER NOT NULL DEFAULT (strftime('%s', CURRENT_TIMESTAMP)),
  edit_content TEXT NOT NULL,
  blog_id INTEGER NOT NULL,
  FOREIGN KEY(blog_id) REFERENCES Blog
);

DROP INDEX IF EXISTS idx_edit_date;
CREATE INDEX idx_edit_date
ON Edit(edit_date);

DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
  tag_id INTEGER PRIMARY KEY ASC,
  tag_name TEXT UNIQUE NOT NULL
);

DROP TABLE IF EXISTS BlogTag;
CREATE TABLE BlogTag (
  blog_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL,
  FOREIGN KEY(blog_id) REFERENCES Blog,
  FOREIGN KEY(tag_id) REFERENCES Tag,
  PRIMARY KEY(blog_id, tag_id)
);

-- || PROJ --
DROP TABLE IF EXISTS Proj;
CREATE TABLE Proj (
  proj_id INTEGER PRIMARY KEY ASC,
  proj_title TEXT UNIQUE NOT NULL,
  proj_description TEXT,
  proj_url TEXT UNIQUE NOT NULL,
  proj_img TEXT UNIQUE NOT NULL
);

