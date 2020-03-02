
DROP TABLE IF EXISTS member;

CREATE TABLE member(
member_id int(10) NOT NULL AUTO_INCREMENT primary key,
fname varchar(55) NOT NULL,
lname varchar(255) NOT NULL,
age int(3) NOT NULL,
gender varchar(9),
phone VARCHAR(20) NOT NULL,
email varchar(255) NOT NULL,
state varchar(40) NOT NULL,
seeking varchar(9) NOT NULL,
bio varchar(8000),
premium tinyint(4) NOT NULL,
image varchar(255) DEFAULT 'images/default.png'
);

insert into member values(null, 'testy', 'test', 24, 'male', '(123)213-2214', 'marblemadness@mail.com', 'wa', 'female',
'I am the globglogabgalab, the shwabble dobble shwibble shwobble dibble dabble shwab', 0, null);



DROP TABLE IF EXISTS interest;

CREATE TABLE interest(
interest_id int(10) NOT NULL AUTO_INCREMENT primary key,
interest varchar(55) NOT NULL,
type varchar(15) NOT NULL
);

insert into interest values(null, "TV", "indoor");
insert into interest values(null, "Movies", "indoor");
insert into interest values(null, "Cooking", "indoor");
insert into interest values(null, "Board games", "indoor");
insert into interest values(null, "Puzzles", "indoor");
insert into interest values(null, "Reading", "indoor");
insert into interest values(null, "Playing cards", "indoor");
insert into interest values(null, "Videogames", "indoor");

insert into interest values(null, "Hiking", "outdoor");
insert into interest values(null, "Biking", "outdoor");
insert into interest values(null, "Swimming", "outdoor");
insert into interest values(null, "Collecting", "outdoor");
insert into interest values(null, "Walking", "outdoor");
insert into interest values(null, "Climbing", "outdoor");




DROP TABLE IF EXISTS member_interest;

CREATE TABLE member_interest(
member_id int(10) NOT NULL,
interest_id int(10),
FOREIGN KEY (member_id) REFERENCES member(member_id),
FOREIGN KEY (interest_id) REFERENCES interest(interest_id)
);