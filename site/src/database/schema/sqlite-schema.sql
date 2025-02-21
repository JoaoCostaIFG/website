-- || BLOG --
CREATE TABLE IF NOT EXISTS "blogs" (
  id INTEGER PRIMARY KEY ASC,
  date INTEGER NOT NULL DEFAULT (strftime('%s', CURRENT_TIMESTAMP)),
  title TEXT UNIQUE NOT NULL,
  intro TEXT,
  content TEXT NOT NULL,
  visible INTEGER NOT NULL DEFAULT 0
);

CREATE INDEX idx_blog_date
ON "blogs"(date);

-- || TAG --
CREATE TABLE IF NOT EXISTS "tags" (
  id INTEGER PRIMARY KEY ASC,
  name TEXT UNIQUE NOT NULL
);

CREATE TABLE blog_tags (
  blog_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL,
  FOREIGN KEY(blog_id) REFERENCES blogs,
  FOREIGN KEY(tag_id) REFERENCES tags,
  PRIMARY KEY(blog_id, tag_id)
);

-- || USER --
CREATE TABLE IF NOT EXISTS "users" (
  id INTEGER PRIMARY KEY ASC,
  username TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL
);

-- || PROJ --
CREATE TABLE IF NOT EXISTS "projs" (
  id INTEGER PRIMARY KEY ASC,
  title TEXT UNIQUE NOT NULL,
  description TEXT,
  url TEXT UNIQUE NOT NULL,
  img TEXT UNIQUE NOT NULL
);


CREATE TABLE IF NOT EXISTS "migrations" ("id" integer not null primary key autoincrement, "migration" varchar not null, "batch" integer not null);
CREATE TABLE IF NOT EXISTS "personal_access_tokens" ("id" integer not null primary key autoincrement, "tokenable_type" varchar not null, "tokenable_id" integer not null, "name" varchar not null, "token" varchar not null, "abilities" text, "last_used_at" datetime, "expires_at" datetime, "created_at" datetime, "updated_at" datetime);
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens" ("tokenable_type", "tokenable_id");
CREATE UNIQUE INDEX "personal_access_tokens_token_unique" on "personal_access_tokens" ("token");
INSERT INTO migrations VALUES(1,'2019_12_14_000001_create_personal_access_tokens_table',1);
